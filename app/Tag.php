<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        
        // On creation of the tag, update the model with a corresponding slug
        static::created(function ($tag) {
            $tag->update(['slug' => $tag->name]);
        });
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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function url()
    {
        return config('app.url') . '/tag/' . $this->{$this->getRouteKeyName()};
    }
}
