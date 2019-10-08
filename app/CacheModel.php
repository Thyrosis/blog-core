<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CacheModel extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->forgetCache();
        });

        static::deleted(function ($model) {
            $model->forgetCache();
        });

        static::saved(function ($model) {
            $model->forgetCache();
        });

        static::updated(function ($model) {
            $model->forgetCache();
        });
    }
    
    public static function all($columns = [])
    {
        if (!empty($columns)) {
            return parent::all($columns);
        }

        return Cache::rememberForever(self::getModelName().'.all', function () {
            return parent::all();
        });
    }

    /**
     * Forget all post related cache items
     * 
     * @version     2019-10-05
     * @todo        Maybe limit it to specific posts, not all post caches?
     */
    public function forgetCache()
    {
        foreach ($this->cachetags as $tag) {
            Cache::forget(self::getModelName().'.'.$tag);
        }
    }

    public static function getModelName()
    {
        return Str::slug(static::class);
    }
}
