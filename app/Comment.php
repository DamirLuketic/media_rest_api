<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
      'id', 'user_id', 'media_id', 'title', 'content'
    ];

    // Access user
    public function user(){
        return $this->belongsTo('App\User');
    }

    // Access media
    public function media(){
        return $this->belongsTo('App\Media');
    }
}
