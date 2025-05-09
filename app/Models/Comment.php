<?php
namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['text', 'author_id', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
