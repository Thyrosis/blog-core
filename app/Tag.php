<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    protected static function boot()
    {
        parent::boot();
        
        // On creation of the tag, update the model with a corresponding slug
        static::created(function ($tag) {
            $tag->update(['slug' => $tag->name]);
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
     * Create a slug for the tag
     */
    public function setSlugAttribute($value)
    {        
        $this->attributes['slug'] = str_slug($value);
    }

    /**
     * The Posts that belong to the Tag.
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
        return config('app.url') . '/tag/' . $this->{$this->getRouteKeyName()};
    }
}
