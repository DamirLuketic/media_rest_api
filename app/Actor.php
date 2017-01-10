<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $fillable =
        [
            'name'
        ];

    // Access videos -> through pivot table
    public function videos()
    {
        return $this->belongsToMany('App\Video');
    }
}
