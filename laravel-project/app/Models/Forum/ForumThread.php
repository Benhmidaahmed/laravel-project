<?php

namespace App\Models\Forum;

use App\Models\utilisateur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumThread extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_id'];

    public function author()
    {
        return $this->belongsTo(utilisateur::class, 'author_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'thread_id');
    }
}
