<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
      'id', 'user_id', 'comment_id', 'status'
    ];

    // Access user
    public function user(){
        return $this->belongsTo('App\User');
    }

    // Access media
    public function media(){
        return $this->belongsTo('App\Grade');
    }
}
