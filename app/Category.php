<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Category extends CacheModel
{
    protected $fillable = ['name', 'slug', 'description'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    
    protected $cachetags = ['all'];

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($category) {
            $category->update(['slug' => $category->name]);
        });
    }

    /**
     * Access the description attribute.
     *
     * @param  string $description
     * @return string
     */
    public function getDescriptionAttribute($description)
    {
        return \Purify::clean($description);
    }

    /** 
     * Get all items to post on custom RSS feed
     * 
     * @return Collection
     * 
     * @version 2020-01-21  Rearranged order of posts to be descending in published_at
     */
    public static function getFeedItems()
    {
        $posts = collect();
        $categories = Setting::get('rss.customFeedCategories');

        if (!is_array($categories)) {
            return $posts;
        }
        
        foreach ($categories as $c) {
            $category = Category::whereSlug($c)->first();

            if($category) {
                $posts = $posts->merge($category->publishedPosts()->whereType('post')->get());
            }
        }

        $posts = $posts->sortByDesc('published_at');

        return $posts->unique('id');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * The Posts that belong to the Category.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }

    public function publishedPosts()
    {
        return $this->belongsToMany('App\Post')->where('published', true)->where('published_at', '<', now());
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function url()
    {
        return config('app.url').'/category/'.$this->{$this->getRouteKeyName()};
    }
}
