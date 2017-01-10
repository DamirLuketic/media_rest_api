<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =
        [
            'user_id', 'commentable_id', 'commentable_type', 'title', 'content'
        ];

    // Permit data store from other table (in polymorphic relation) \\ Audio & Video
    public function commentable()
    {
        return $this->morphTo();
    }

    // Access user
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Access grades
    public function grades()
    {
        return $this->hasMany('App\Grade');
    }
}
