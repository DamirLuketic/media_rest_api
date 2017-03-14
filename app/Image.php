<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable =
        [
            'url', 'featured',
    ];

    // Permit data store from other table (in polymorphic relation) \\ Audio & Video
    public function imageable()
    {
        return $this->morphTo();
    }
}
