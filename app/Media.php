<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
      'id', 'user_id', 'category_id', 'condition_id',
        'm_name', 'm_director', 'm_actor',
        'a_band', 'a_album', 'year', 'for_change'
    ];

    // Access owner (User)
    public function user(){
        return $this->belongsTo('App\User');
    }

    // Access categories
    public function categories(){
        return $this->hasMany('App\Category');
    }

    // Access conditions
    public function conditions(){
        return $this->hasMany('App\Condition');
    }

    // Access comments
    public function comments(){
        return $this->hasMany('App\Comment');
    }

    // Access grades
    public function grades(){
        return $this->hasMany('App\Grade');
    }
}
