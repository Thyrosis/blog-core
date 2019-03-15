<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $fillable = ['code', 'label', 'description'];

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('value')->withTimestamps();
    }

    public function using($value = null)
    {
        $using = array();

        foreach ($this->users as $user) {
            if ($value == $user->pivot->value) {
                $using[] = $user;
            }
        }

        return collect($using);
    }
}
