<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    private $replies = [];

    protected $fillable = ['slug', 'question_id'];

    public function question () {
        return $this->belongsTo(Question::class);
    }

    public function replies () {
        return $this->hasMany(Reply::class, 'parent_id');
    }

    public function addReply($reply) {
        array_push($this->replies, $reply);
    }

    public function getReplies () {
        return $this->replies;
    }
}
