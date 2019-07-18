<?php

namespace App;

use App\Comment;
use App\Mail\NewComment;
use App\View;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Illuminate\Support\Facades\Route;

class Post extends Model implements Feedable
{
    protected $fillable = ['user_id', 'title', 'longTitle', 'slug', 'summary', 'body', 'commentable', 'featured', 'published', 'featureimage', 'published_at', 'created_at', 'updated_at', 'type', 'hash'];
    protected $dates = ['published_at', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();
    }

    public function body()
    {
        return $this->attributes['body'];
    }

    /**
     * Return the attached categories instances
     * 
     * @return  App\Category
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /** 
     * Create a slug for the post
     * 
     * @param   string $value   Value to create a slug from
     * @return  string
     */
    public static function createSlug($value)
    {
        $slug = Str::slug($value);

        while (static::whereSlug($slug)->exists()) {
            $slug = static::slug($value);
        } 

        return $slug;
    }

    /**
     * Define the relationship between posts and comments. 
     * 
     * Each post can have many comments, but each comment
     * only belongs to one post.
     * 
     * @return Illuminate\Database\Eloquent\Relations
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Duplicate a post object, including all tags and categories
     * 
     * @return      App\Post
     * @version     20190702
     * @todo        Duplicate the category and tags too
     */
    public function duplicate()
    {
        $newPost = $this->replicate();
        $newPost->slug = static::createSlug($newPost->title);
        $newPost->save();
        
        return $newPost->fresh();
    }

    /**
     * Generate a random hash 
     * 
     * @param   int $characters     Amount of characters has should be long
     * @return  string
     */
    public static function generateHash($characters = 5)
    {
        return Str::random($characters);
    }

    /**
     * Access the body attribute.
     *
     * @param  string $body
     * @return string
     * @version 20190123    Added parsing of Forms
     */
    public function getBodyAttribute($body)
    {
        if (Setting::get('post.purify')) {
            $body = \Purify::clean($body);
        }

        return $this->parse($body);
    }

    /**
     * Returns the URL to the feature image (if used)
     * 
     * @param   bool    default     Whether to return the default featureImage
     * @return string
     * 
     * @version     20181111    Added parameter 'default'
     */
    public function getFeatureImage($default = true)
    {
        if ($this->featureimage) {
            return $this->featureimage;
        }

        if ($default) {
            return Setting::get('post.defaultFeatureImage');
        }

        return false;
    }

    /** 
     * Get all items to post on RSS feed
     * 
     * @return Collection
     */
    public static function getFeedItems()
    {
        return static::getPublished()->whereType('post')->get();
    }

    /**
     * Get a custom set link attribute (including hostname)
     * 
     * @return string
     */
    public function getLinkAttribute()
    {
        return config('app.url') . $this->path;
    }

    /**
     * Returns the used Long Title, or just
     * the regular title if it isn't set.
     * 
     * @return string
     * @deprecated  20190702    Replaced by the more logical getTitle()
     */
    public function getLongTitle()
    {
        return $this->getTitle();
    }

    /**
     * Return a custom path attribute (internal linking)
     * 
     * @return string
     */
    public function getPathAttribute()
    {
        return "/{$this->slug}";
    }

    /**
     * Return a collection of published posts
     * 
     * @return Illuminate\Support\Collection
     */
    public static function getPublished()
    {
        return static::where('published', true)->where('published_at', '<', now())->orderBy('published_at', 'DESC')->orderBy('id', 'DESC');
    }
    
    /**
     * Defines the route keyname used by Larave.
     * 
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }   

    /**
     * Returns the summary if it was created,
     * or just the first 75 words of the body if not.
     * 
     * @return string
     */
    public function getSummary()
    {
        if (!empty($this->summary)) {
            return $this->summary;
        }

        return $this->wordLimit();
    }

    /**
     * Access the summary attribute.
     *
     * @param  string $summary
     * @return string
     */
    public function getSummaryAttribute($summary)
    {
        if (Setting::get('post.purify')) {
            $summary = \Purify::clean($summary);
        }

        return $summary;
    }

    /**
     * Returns the used Long Title, or just
     * the regular title if it isn't set.
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->longTitle ?? $this->title;
    } 

    /**
     * Return the current published status.
     * 
     * If the status is 0, return false.
     * If the status is 1, first check if the post published date
     * is in the past. If so, return true, otherwise false.
     * 
     * @return boolean
     */
    public function isPublished()
    {
        if ($this->published == 0) {
            return false;
        }

        return $this->published_at->isPast();
    }

    /**
     * Returns the direct link, including the URL
     */
    public function link()
    {
        return config('app.url').$this->path();
    }

    /**
     * Find the post published after this one
     * 
     * @return App\Post
     */
    public function next()
    {
        return self::where('published', true)->where('published_at', '<', Carbon::now())->where('published_at', '>', $this->published_at)->orderBy('published_at', 'ASC')->first();
    }

    /**
     * Send an email to all subscribed commenters to this post.
     * 
     * Forget the current commenters email address to avoid receiving an email yourself when posting.
     * 
     * @param App\Comment $comment
     * @version 2018-08-10  Added forget to the collection
     */
    public function notifySubscribers($comment)
    {
        $subscribers = $this->subscribers()->filter(function ($value) use ($comment) {
            return $comment->emailaddress !== $value;
        });

        $subscribers->each( function ($subscriber) use ($comment) {
            Mail::to($subscriber)->queue(new NewComment($comment));
        });
    }

    /**
     * Queue an email to all subscribed email addresses
     */
    public function notifySubscriptions($comment)
    {
        $this->subscriptions->each(function ($subscription) use ($comment) {
            Mail::to($subscription->emailaddress)->queue(new NewComment($comment));
        });
    }

    /**
     * Parse the text for use of placeholders.
     * 
     * Currently active:
     *   Forms : ||FORM||{id}||
     * 
     * Planned:
     *   Mentions : @[username]
     * 
     * @param   string $text    Text to parse for placeholders
     * @return  string
     * @version 20190123
     */
    public function parse($text)
    {
        if (Str::contains($text, "||FORM||")) {
            $temptext = explode("||", $text);

            $form = Form::find($temptext[2]);

            $text = Str::replaceFirst("||FORM||{$temptext[2]}||", $form->toHTML(), $text);
            
            $client = Setting::get('recaptcha.client');
            
            if ($client) {
                $text .= "<script src='https://www.google.com/recaptcha/api.js?render=".$client."'></script>
                <script>
                grecaptcha.ready(function() {
                    grecaptcha.execute('".$client."', {action: 'contact'}).then(function(token) {
                        var recaptchaResponse = document.getElementById('recaptchaResponse');
                        recaptchaResponse.value = token;
                    });
                });
                </script>";
            }
        }

        return $text;
    }

    /**
     * Returns the direct path (no URL)
     */
    public function path()
    {
        return "/{$this->slug}";
    }

    /**
     * Find the post published before this one
     * 
     * @return App\Post
     */
    public function previous()
    {
        return self::where('published', true)->where('published_at', '<', $this->published_at)->orderBy('published_at', 'DESC')->first();
    }

    /**
     * Process a posts data on create or update.
     * 
     * @param   array   $data
     * @return  array   Processed $data
     * @version 20181002    - Only update user_id if there isn't one
     *                      - Only update slug if there is a title
     */
    public static function processData($data) 
    {
        // A post is always linked to the currently authenticated user
        if (!isset($data['user_id'])) {
            $data['user_id'] = auth()->id();
        }        

        // If there isn't a slug (and therefor it's a new post) a slug should be created
        if (!isset($data['slug']) && isset($data['title'])) {
            $data['slug'] = static::createSlug($data['title']);
        }

        // Pull the date and time together in a published at Carbon instance
        if (isset($data['published_at_date']) && isset($data['published_at_time'])) {
            $data['published_at'] = Carbon::parse($data['published_at_date'] . " " . $data['published_at_time']);
        }
    
        // Set the hash if it's just been enabled, remove when disabled
        if (isset($data['use_hash'])) {
            if ($data['use_hash'] == 1) {
                if (!isset($data['hash'])) {
                    $data['hash'] = static::generateHash(10);
                }
            } else {
                $data['hash'] = null;
            }
        }

        // Return the data array and continue with whatever you were doing.
        return $data;
    }

    /**
     * Update this posts published status to 1
     * 
     * @return boolean
     */
    public function publish()
    {
        return $this->update(['published' => 1]);
    }

    /**
     * Calculate the average read time for this post.
     * 
     * The average time is calculated using 175 words per minute as reading speed.
     * 250 is the average adult's reading speed, according to some researches,
     * but drops to 150 when reading technical content.
     * 
     * @return int
     */
    public function readTime()
    {
        return (floor($this->words() / 175) > 0) ? floor($this->words() / 175) : 1;
    }

    /**
     * Define all the routes related to post
     */
    public static function routes()
    {
        $home = Setting::get('home.url');

        if ($home) {
            Route::redirect('/', '/'.$home)->name('home');
        } else {
            Route::get('/', 'PostController@index')->name('home');
        }

        Route::get(Setting::get('post.index') ?? '', 'PostController@index')->name('post.index');

        Route::middleware(['auth', 'moderator'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('', 'Admin\PostController@index')->name('post.index');
            Route::get('post/create', 'Admin\PostController@create')->name('post.create');
            Route::post('post/', 'Admin\PostController@store')->name('post.store');
            Route::get('post/{post}/edit', 'Admin\PostController@edit')->name('post.edit');
            Route::patch('post/{post}', 'Admin\PostController@update')->name('post.update');
            Route::delete('post/{post}/delete', 'Admin\PostController@destroy')->name('post.destroy');
            Route::get('post/{post}', 'Admin\PostController@show')->name('post.show');
        });
    }

    /** 
     * Set the custom published at attribute
     * 
     * @param string    $datetime
     */
    public function setPublishedAtAttribute($datetime)
    {
        if (is_string($datetime)) {
            $this->attributes['published_at'] = Carbon::parse($datetime);
        } else {
            $this->attributes['published_at'] = $datetime;
        }
    }

    /**
     * Create a custom slug with specified amount of random trailing characters
     */
    public static function slug($value, $random = 5) {
        return Str::slug($value) . "-" . Str::random($random);
    }

    /**
     * Collect all email addresses of commenters who've subscribed to the post
     * 
     * @return Illuminate\Support\Collection $emails
     * @deprecated?
     */
    public function subscribers()
    {
        $emails = collect();

        $this->comments()->where('notify', 1)->get()->each(function ($comment) use ($emails) {
            $emails->push($comment->emailaddress);
        });

        return $emails->unique();
    }

    /**
     * @deprecated?
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class); 
    }

    /**
     * Sync a posts related tags and categories if needed
     * 
     * @param   Illuminate\Http\Request $request
     * @version 20181002
     */
    public function sync($request)
    {
        // If the request has tags, sync them.
        if ($request->has('tags')) {
            $this->tags()->sync($request->tags);
        }

        // If the request has categories, sync them.
        if ($request->has('categories')) {
            $this->categories()->sync($request->categories);
        }

        return $this;
    }

    /**
     * Return the attached tags instances
     * 
     * @return  App\Tag
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    /**
     * @version 20190108    Provided a default author in case user doesn't exist any more
     */
    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary( (!empty($this->summary)) ? strip_tags($this->summary) : $this->wordLimit(50) )
            ->updated($this->published_at)
            ->link($this->link)
            ->author($this->user->name ?? Setting::get('post.defaultAuthor'));
    }

    /**
     * Update this posts published status to 0
     * 
     * @return boolean
     */
    public function unpublish()
    {
        return $this->update(['published' => 0]);
    }

    /**
     * Define the relationship between posts and users.
     * 
     * Each post belongs to one user, but each user
     * can have many posts.
     * 
     * @return  App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Decides the logic for tracking views of this Post.
     * 
     * For now, being authenticated doesn't add a view.
     * When the user level functionality is done, only exlude admin users
     * for the view counting. Regular users will count.
     * 
     * This functionality replaces the original views-column on Posts.
     * 
     * @return      $this
     * @since       20190122
     */
    public function view()
    {
        if (auth()->guest()) {
            if (!Str::contains(request()->header('user-agent'), ['Googlebot', 'bing'])) {
                $view = View::create([
                    'post_id' => $this->id,
                    'url' => request()->url(),
                    'path' => request()->path(),
                    'ipaddress' => null,
                    'iphash' => View::encrypt(request()->ip()),
                    'user_agent' => View::encrypt(request()->header('user-agent')),
                ]);
            }
        }

        return $this;
    }

    /**
     * Relationship between Post and Views.
     * 
     * @return      Illuminate\Database\Eloquent\Relations
     * @since       20190122
     */
    public function views()
    {
        return $this->hasMany(View::class);
    }

    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    public function wordLimit($words = 75, $end = '...')
    {
        return \Illuminate\Support\Str::words(strip_tags($this->body), $words, $end);
    }

    /**
     * Count the amount of words in the post
     * 
     * @return int
     */
    public function words()
    {
        return str_word_count(strip_tags($this->body));
    }
}
