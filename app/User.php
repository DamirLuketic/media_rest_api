<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'confirmation_code', 'admin', 'visible'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Access image from Polymorphic table -> one image
    public function image(){
        return $this->morphOne('App\Image', 'imageable');
    }

    // Access media
    public function media(){
        return $this->hasMany('App\Media');
    }

    // Access comment -> has many
    public function comments(){
        return $this->hasMany('App\Comment');
    }

    // Access grades
    public function grades(){
        return $this->hasMany('App\Grade');
    }

    // Access can view
    public function can_view(){
        return $this->hasMany('App\CanView');
    }
}
