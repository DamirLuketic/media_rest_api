<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable =
        [
            'name'
        ];

    // Access audio
    public function audio()
    {
        return $this->hasMany('App\Audio');
    }

    // Access video
    public function videos()
    {
        return $this->hasMany('App\Video');
    }
}
