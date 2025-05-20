package com.example.demo.Controller;

import com.example.demo.entities.User;
import com.example.demo.entities.forum.Comment;
import com.example.demo.entities.forum.ForumThread;
import com.example.demo.entities.forum.Post;
import com.example.demo.repository.UserRepository;
import com.example.demo.service.ForumService;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/forum")
public class ForumController {

    @Autowired
    private ForumService forumService;

    @Autowired
    private UserRepository userRepository;


    @GetMapping("/threads")
    public List<ForumThread> getAllThreads() {
        return forumService.getAllThreads();
    }

    @GetMapping("/threads/{threadId}/posts")
    public List<Post> getPostsByThread(@PathVariable Long threadId) {
        return forumService.getPostsByThreadId(threadId);
    }

    @GetMapping("/posts/{postId}/comments")
    public List<Comment> getCommentsByPost(@PathVariable Long postId) {
        return forumService.getCommentsByPostId(postId);
    }



    @PostMapping("/threads")
    public ForumThread createThread(@RequestBody CreateThreadRequest request) {
        User user = userRepository.findById(request.userId)
            .orElseThrow(() -> new IllegalArgumentException("Utilisateur pas trouve"));
        System.out.println(user);
        return forumService.createThread(request.title, user);
    }

    @PostMapping("/threads/{threadId}/posts")
    public Post createPost(@PathVariable Long threadId,
                           @RequestBody CreatePostRequest request) {
        User user = userRepository.findById(request.userId)
            .orElseThrow(() -> new IllegalArgumentException("Utilisateur pas trouve"));
        return forumService.createPost(threadId, request.content, user);
    }

    @PostMapping("/posts/{postId}/comments")
    public Comment addComment(@PathVariable Long postId,
                              @RequestBody AddCommentRequest request) {
        User user = userRepository.findById(request.userId)
            .orElseThrow(() -> new IllegalArgumentException("Utilisateur pas trouve"));
        return forumService.addComment(postId, request.text, user);
    }


}


class CreateThreadRequest {
    public String title;
    public int userId;
}

class CreatePostRequest {
    public String content;
    public int userId;
}

class AddCommentRequest {
    public String text;
    public int userId;
}