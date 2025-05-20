<?php

namespace App\Services;

use App\Models\Forum\ForumThread;
use App\Models\Forum\Post;
use App\Models\Forum\Comment;
use App\Models\utilisateur;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ForumService
{
    public function createThread(string $title, utilisateur $author)
    {
        $thread = new ForumThread([
            'title' => $title,
            'author_id' => $author->id,
        ]);
        $thread->save();

        return $thread;
    }

    public function getAllThreads()
    {
        return ForumThread::with('author')->get();
    }


    public function createPost($threadId, string $content, utilisateur $author)
    {
        $thread = ForumThread::findOrFail($threadId);

        $post = new Post([
            'content' => $content,
            'author_id' => $author->id,
            'thread_id' => $thread->id,
        ]);
        $post->save();

        return $post;
    }

    public function getPostsByThreadId($threadId)
    {
        $thread = ForumThread::findOrFail($threadId);
        return $thread->posts()->with('author')->get();
    }










        public function addComment($postId, string $text, utilisateur $author)
        {
            $post = Post::findOrFail($postId);

            $comment = new Comment([
                'text' => $text,
                'author_id' => $author->id,
                'post_id' => $post->id,
            ]);
            $comment->save();

            return $comment;
        }

            public function getCommentsByPostId($postId)
    {
        $post = Post::findOrFail($postId);
        return $post->comments()->with('author')->get();
    }




}

