<?php
namespace App\Models\Forum;

use App\Models\utilisateur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'post_id', 'author_id'];

    public function author()
    {
        return $this->belongsTo(utilisateur::class, 'author_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }


}
