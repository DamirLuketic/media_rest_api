<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Identifier extends Model
{
    protected $fillable =
        [
            'title', 'input'
        ];

    // Permit data store from other table (in polymorphic relation) \\ Audio & Video
    public function identifierable()
    {
        return $this->morphTo();
    }
}
