package com.example.demo.repository;

import com.example.demo.entities.Message;
import com.example.demo.entities.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.util.List;

public interface MessageRepository extends JpaRepository<Message, Long> {
    //hethi l query eli trateb el messages in ascendant order
    //very basic juste ye5ou el user1 wel user2
    //ychouf kenhom ezouz mawjoudin , kenhom mawjoudin yraja3lk
    //200 OK status , sinn 500 internal error(normalement)
    //Ken el body empty ra8mili el users exist
    //tout simplement masaritch binethom conversation
    @Query("SELECT m FROM Message m WHERE " +
           "(m.sender = :user1 AND m.receiver = :user2) OR " +
           "(m.sender = :user2 AND m.receiver = :user1) " +
           "ORDER BY m.timestamp ASC")
    List<Message> loadConversation(@Param("user1") User user1, @Param("user2") User user2);
}