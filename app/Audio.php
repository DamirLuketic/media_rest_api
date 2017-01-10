<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $fillable =
        [
            'user_id', 'audio_category_id', 'condition_id', 'band', 'album', 'year', 'for_change',
            'description', 'allowed'
        ];

    // Access audio category
    public function audio_category()
    {
        return $this->belongsTo('App\AudioCategory');
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
