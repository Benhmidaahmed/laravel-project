<?php
namespace App\Models\Forum;


use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    protected $fillable = ['title', 'author_id'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
