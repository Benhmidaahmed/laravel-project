<?php

namespace App\Http\Controllers;

use App\Services\ForumService;
use App\Models\User;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    protected $forumService;

    public function __construct(ForumService $forumService)
    {
        $this->forumService = $forumService;
    }

    // Create a thread
    public function createThread(Request $request)
    {
        $user = User::find(1); // Or any logic to get the authenticated user
        $thread = $this->forumService->createThread($request->title, $user);

        return response()->json($thread, 201);
    }

    // Create a post
    public function createPost($threadId, Request $request)
    {
        $user = User::find(1);
        $post = $this->forumService->createPost($threadId, $request->content, $user);

        return response()->json($post, 201);
    }

    // Add a comment
    public function addComment($postId, Request $request)
    {
        $user = User::find(1);
        $comment = $this->forumService->addComment($postId, $request->text, $user);

        return response()->json($comment, 201);
    }

    // Get all threads
    public function getAllThreads()
    {
        $threads = $this->forumService->getAllThreads();
        return response()->json($threads);
    }

    // Get posts by thread ID
    public function getPostsByThreadId($threadId)
    {
        $posts = $this->forumService->getPostsByThreadId($threadId);
        return response()->json($posts);
    }

    // Get comments by post ID
    public function getCommentsByPostId($postId)
    {
        $comments = $this->forumService->getCommentsByPostId($postId);
        return response()->json($comments);
    }
}
