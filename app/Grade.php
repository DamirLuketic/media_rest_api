<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable =
        [
            'user_id', 'comment_id', 'status'
        ];

    // Access user
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Access comment
    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
}
