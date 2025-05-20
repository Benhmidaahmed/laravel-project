package com.example.demo.service;


import com.example.demo.entities.User;
import com.example.demo.entities.forum.Comment;
import com.example.demo.entities.forum.Post;
import com.example.demo.entities.forum.ForumThread;
import com.example.demo.repository.forum.CommentRepository;
import com.example.demo.repository.forum.PostRepository;
import com.example.demo.repository.forum.ThreadRepository;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class ForumService {
    @Autowired
    private ThreadRepository threadRepo;

    @Autowired
    private PostRepository postRepo;

    @Autowired
    private CommentRepository commentRepo;

    public ForumThread createThread(String title, User author) {
        ForumThread thread = new ForumThread();
        thread.setTitle(title);
        thread.setAuthor(author);
        return threadRepo.save(thread);
    }

    public Post createPost(Long threadId, String content, User author) {
        Optional<ForumThread> threadOpt = threadRepo.findById(threadId);
        if (threadOpt.isEmpty()) throw new IllegalArgumentException("Thread pas trouve");

        Post post = new Post();
        post.setContent(content);
        post.setAuthor(author);
        post.setThread(threadOpt.get());
        return postRepo.save(post);
    }

    public Comment addComment(Long postId, String text, User author) {
        Optional<Post> postOpt = postRepo.findById(postId);
        if (postOpt.isEmpty()) throw new IllegalArgumentException("Post pas trouve");

        Comment comment = new Comment();
        comment.setText(text);
        comment.setAuthor(author);
        comment.setPost(postOpt.get());
        return commentRepo.save(comment);
    }
    public List<ForumThread> getAllThreads() {
        return threadRepo.findAll();
    }
    
    public List<Post> getPostsByThreadId(Long threadId) {
        ForumThread thread = threadRepo.findById(threadId)
            .orElseThrow(() -> new IllegalArgumentException("Thread pas trouve"));
        return thread.getPosts();
    }
    
    public List<Comment> getCommentsByPostId(Long postId) {
        Post post = postRepo.findById(postId)
            .orElseThrow(() -> new IllegalArgumentException("Post pas trouve"));
        return post.getComments();
    }
    
    
}
