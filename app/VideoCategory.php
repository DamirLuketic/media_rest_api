<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    protected $fillable =
        [
            'name'
        ];

    // Access video
    public function videos()
    {
        return $this->hasMany('App\Video');
    }
}
