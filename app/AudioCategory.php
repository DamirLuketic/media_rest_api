<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioCategory extends Model
{
    protected $fillable =
        [
            'name'
        ];

    public function audio()
    {
        return $this->hasMany('App\Audio');
    }
}
