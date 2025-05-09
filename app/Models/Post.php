<?php
namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['content', 'author_id', 'thread_id'];

    public function thread()
    {
        return $this->belongsTo(ForumThread::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
