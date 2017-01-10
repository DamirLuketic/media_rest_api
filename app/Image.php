<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable =
        [
      'id', 'url', 'featured', 'imageable_id', 'imageable_type'
    ];

    // Permit data store from other table (in polymorphic relation) \\ Audio & Video
    public function imageable()
    {
        return $this->morphTo();
    }
}
