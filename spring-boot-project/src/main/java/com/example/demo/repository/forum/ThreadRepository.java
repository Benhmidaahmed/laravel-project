package com.example.demo.repository.forum;

import org.springframework.data.jpa.repository.JpaRepository;

import com.example.demo.entities.forum.ForumThread;

public interface ThreadRepository extends JpaRepository<ForumThread, Long> {}