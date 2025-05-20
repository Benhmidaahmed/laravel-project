<?php
namespace App\Models\Forum;

use App\Models\utilisateur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'author_id', 'thread_id'];

    public function thread()
    {
        return $this->belongsTo(ForumThread::class, 'thread_id');
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\utilisateur::class, 'author_id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }


}
