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
    protected $fillable =
        [
        'name', 'email', 'password', 'active', 'confirmation_code', 'admin', 'image_url', 'items_visible',
            'email_available'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden =
        [
        'password', 'remember_token',
    ];

    // Access can view
    public function can_view()
    {
        return $this->hasMany('App\CanView');
    }

    // Access comments
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    // Access grades
    public function grades()
    {
        return $this->hasMany('App\Grade');
    }

    // Access audio
    public function audio()
    {
        return $this->hasMany('App\Audio');
    }

    // Access videos
    public function videos()
    {
        return $this->hasMany('App\Video');
    }

    // Access messages (for "send" and "receive")
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
