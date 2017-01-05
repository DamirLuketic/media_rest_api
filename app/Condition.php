<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable = [
      'id', 'name'
    ];

    // Access media
    public function media(){
        return $this->belongsTo('App\Media');
    }
}
