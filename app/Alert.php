<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{

    protected $fillable = [
        'alert_message', 'unread', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
