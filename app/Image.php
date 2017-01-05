<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
      'id', 'url', 'featured', 'imageable_id', 'imageable_type'
    ];

    // Access for image -> for 'User' and 'Media'
    public function imageable(){
        return $this->morphTo();
    }

    // Access image from Polymorphic table -> many image
    public function images(){
        return $this->morphMany('App\Image', 'imageable');
    }
}
