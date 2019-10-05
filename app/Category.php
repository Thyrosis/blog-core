<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Category extends CacheModel
{
    protected $fillable = ['name', 'slug', 'description'];
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
