<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($category) {
            $category->update(['slug' => $category->name]);
        });
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
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
