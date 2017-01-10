<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable =
        [
            'user_id', 'video_category_id', 'condition_id', 'name', 'director', 'year',
            'for_change', 'description', 'allowed'
        ];

    // Access actors -> through pivot table
    public function actors()
    {
        return $this->belongsToMany('App\Actor');
    }

    // Access video category
    public function video_category()
    {
        return $this->belongsTo('App\VideoCategory');
    }

    // Access condition
    public function condition()
    {
        return $this->belongsTo('App\Condition');
    }

    // Access polymorphic table for images
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    // Access user
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Access polymorphic table for comments
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
