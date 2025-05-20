package com.example.demo.repository.forum;

import org.springframework.data.jpa.repository.JpaRepository;

import com.example.demo.entities.forum.Post;

public interface PostRepository extends JpaRepository<Post, Long> {}