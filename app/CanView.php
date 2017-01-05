<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanView extends Model
{
    protected $fillable = [
      'user_id', 'can_view_id'
    ];

    // Access user (owner)
    public function user(){
        return $this->belongsTo('App\User');
    }
}
