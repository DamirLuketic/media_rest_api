<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_send_id', 'user_receive_id', 'title', 'content'
    ];

    // Access user (for "send" and "receive")
    public function user_messages()
    {
        return $this->belongsTo('App\User');
    }
}
