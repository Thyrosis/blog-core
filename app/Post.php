<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewComment;
use Illuminate\Support\Facades\Log;

class Post extends Model implements Feedable
{
    protected $fillable = ['user_id', 'title', 'longTitle', 'slug', 'summary', 'body', 'views', 'commentable', 'featured', 'published', 'featureimage', 'published_at', 'created_at', 'updated_at'];
    protected $dates = ['published_at', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Create a custom slug with specified amount of random trailing characters
     */
    public static function slug($value, $random = 5) {
        return str_slug($value) . "-" . str_random($random);
    }

    public static function createSlug($value)
    {
        $slug = str_slug($value);

        while (static::whereSlug($slug)->exists()) {
            $slug = static::slug($value);
        } 

        return $slug;
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
     * Process a posts data on create or update.
     * 
     * @param   array   $data
     * @return  array   Processed $data
     * @version 20181002    - Only update user_id if there isn't one
     *                      - Only update slug if there is a title
     */
    public static function processData($data) {
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
    
        // Return the data array and continue with whatever you were doing.
        return $data;
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
            $post->tags()->sync($request->tags);
        }

        // If the request has categories, sync them.
        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        return $this;
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
     * Returns the URL to the feature image (if used)
     * 
     * @return string
     */
    public function getFeatureImage()
    {
        if ($this->featureimage) {
            return $this->featureimage;
        }

        return config('custom.featureImage');
    }

    /**
     * Returns the used Long Title, or just
     * the regular title if it isn't set.
     * 
     * @return string
     */
    public function getLongTitle()
    {
        return $this->longTitle ?? $this->title;
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
        return \Purify::clean($summary);
    }

    /**
     * Access the body attribute.
     *
     * @param  string $body
     * @return string
     */
    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }

    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary( (!empty($this->summary)) ? $this->summary : $this->wordLimit(50) )
            ->updated($this->published_at)
            ->link($this->link)
            ->author($this->user->name);
    }

    public static function getFeedItems()
    {
        return static::getPublished()->get();
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
     * Return a custom path attribute (internal linking)
     * 
     * @return string
     */
    public function getPathAttribute()
    {
        return "/{$this->slug}";
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
     * Returns the direct path (no URL)
     */
    public function path()
    {
        return "/{$this->slug}";
    }

    /**
     * Returns the direct link, including the URL
     */
    public function link()
    {
        return config('app.url').$this->path();
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
     * Return the attached tags instances
     * 
     * @return  App\Tag
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
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
     * Update this posts published status to 0
     * 
     * @return boolean
     */
    public function unpublish()
    {
        return $this->update(['published' => 0]);
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
     * Find the post published before this one
     * 
     * @return App\Post
     */
    public function previous()
    {
        return self::where('published', true)->where('published_at', '<', $this->published_at)->orderBy('published_at', 'DESC')->first();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class); 
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

    /**
     * Calculate the average read time for this post.
     * 
     * The average time is calculated using 250 words per minute as reading speed.
     * 250 is the average adult's reading speed, according to some researches.
     * 
     * @return int
     */
    public function readTime()
    {
        return floor($this->words() / 250);
    }

    /** PROBABLY DEPRECATED FUNCTIONS - NEED CLEANING UP **/

    /**
     * Collect all email addresses of commenters who've subscribed to the post
     * 
     * @return Illuminate\Support\Collection $emails
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

    public function notifySubscriptions($comment)
    {
        $this->subscriptions->each(function ($subscription) use ($comment) {
            Mail::to($subscription->emailaddress)->queue(new NewComment($comment));
        });
    }
}
