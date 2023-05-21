<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable=[
        'user_id','tweet',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }

    public function likedBy($user)
    {
        return Like::where('user_id',$user->id)->where('tweet_id',$this->id);
    }
}
