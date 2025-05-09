<?php

namespace App\Services;

use App\Models\Forum\ForumThread;
use App\Models\Forum\Post;
use App\Models\Forum\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ForumService
{
    // Create a new thread
    public function createThread(string $title, User $author)
    {
        $thread = new ForumThread();
        $thread->title = $title;
        $thread->author_id = $author->id; // Assuming author is a User model
        $thread->save();
        
        return $thread;
    }

    // Create a new post under a thread
    public function createPost($threadId, string $content, User $author)
    {
        $thread = ForumThread::find($threadId);

        if (!$thread) {
            throw new ModelNotFoundException("Thread not found");
        }

        $post = new Post();
        $post->content = $content;
        $post->author_id = $author->id;
        $post->thread_id = $thread->id;
        $post->save();

        return $post;
    }

    // Add a comment to a post
    public function addComment($postId, string $text, User $author)
    {
        $post = Post::find($postId);

        if (!$post) {
            throw new ModelNotFoundException("Post not found");
        }

        $comment = new Comment();
        $comment->text = $text;
        $comment->author_id = $author->id;
        $comment->post_id = $post->id;
        $comment->save();

        return $comment;
    }

    // Get all threads
    public function getAllThreads()
    {
        return ForumThread::all();
    }

    // Get posts for a specific thread
    public function getPostsByThreadId($threadId)
    {
        $thread = ForumThread::find($threadId);

        if (!$thread) {
            throw new ModelNotFoundException("Thread not found");
        }

        return $thread->posts;
    }

    // Get comments for a specific post
    public function getCommentsByPostId($postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            throw new ModelNotFoundException("Post not found");
        }

        return $post->comments;
    }
}
