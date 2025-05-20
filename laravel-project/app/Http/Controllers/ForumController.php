<?php

namespace App\Http\Controllers;

use App\Services\ForumService;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ForumController extends Controller
{
    protected ForumService $forumService;

    public function __construct(ForumService $forumService)
    {
        $this->forumService = $forumService;
    }

    /**
     * Create a new thread.
     */
    public function createThread(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string',
            'author_id' => 'required|exists:utilisateur,id',
        ]);

        $user = Utilisateur::findOrFail($request->author_id);
        $thread = $this->forumService->createThread($request->title, $user);

        return response()->json($thread, 201);
    }

    /**
     * Retrieve all threads.
     */
    public function getAllThreads(): JsonResponse
    {
        $threads = $this->forumService->getAllThreads();
        return response()->json($threads);
    }

    /**
     * Retrieve posts by thread ID.
     */
    public function getPostsByThreadId(int $threadId): JsonResponse
    {
        $posts = $this->forumService->getPostsByThreadId($threadId);
        return response()->json($posts);
    }

    /**
     * Create a post in a thread.
     */
    public function createPost(int $threadId, Request $request): JsonResponse
    {
        $request->validate([
            'content' => 'required|string',
            'author_id' => 'required|exists:utilisateur,id',
        ]);

        $user = Utilisateur::findOrFail($request->author_id);
        $post = $this->forumService->createPost($threadId, $request->content, $user);

        return response()->json($post, 201);
    }

    /**
     * Add a comment to a post.
     */
    public function addComment(int $postId, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'author_id' => 'required|exists:utilisateur,id',
        ]);

        $user = Utilisateur::findOrFail($validated['author_id']);
        $comment = $this->forumService->addComment($postId, $validated['text'], $user);

        return response()->json($comment, 201);
    }

    /**
     * Get all comments by post ID.
     */
    public function getCommentsByPostId(int $postId): JsonResponse
    {
        $comments = $this->forumService->getCommentsByPostId($postId);
        return response()->json($comments);
    }
}
