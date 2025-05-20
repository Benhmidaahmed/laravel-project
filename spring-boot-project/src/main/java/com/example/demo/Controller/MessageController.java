package com.example.demo.Controller;

import com.example.demo.dto.SendMessageRequest;
import com.example.demo.dto.ConversationRequest;
import com.example.demo.entities.Message;
import com.example.demo.entities.User;
import com.example.demo.repository.MessageRepository;
import com.example.demo.repository.UserRepository;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.time.LocalDateTime;
import java.util.List;

@RestController
@RequestMapping("/api/messages")
public class MessageController {

    @Autowired
    private MessageRepository messageRepository;

    @Autowired
    private UserRepository userRepository;

    @PostMapping("/send")
    //tout simplement ye5ou el id mt3 el sender wel receivier , w m3ahom el content mt3 l message
    //b3dika yzid el row heki fel table message wm3aha el time li sarit fih l'operation
    //bien sure el ID auto increment w auto gen
    //TEST BODY EXAMPLE:
    // {
    //     "senderId": 6,
    //     "receiverId": 7,
    //     "message": "Hello, how are you?"
    //   }
      
    public Message sendMessage(@RequestBody SendMessageRequest request) {
        User sender = userRepository.findById(request.senderId).orElseThrow();
        User receiver = userRepository.findById(request.receiverId).orElseThrow();

        Message message = new Message();
        message.setSender(sender);
        message.setReceiver(receiver);
        message.setContent(request.message);
        message.setTimestamp(LocalDateTime.now());

        return messageRepository.save(message);
    }

    @PostMapping("/conversation")
    //tist79 zouz 7ajet bich tloadi el conversation , el id mt3 el user lowel , wel id mt3 el user etheni
    //traja3lik body JSON bel messaget mratbin ascendant 
    //TEST BODY EXAMPLE:
    // {
    //     "user1Id": 6,
    //     "user2Id": 7
    //   }
      
    public List<Message> getConversation(@RequestBody ConversationRequest request) {
        User user1 = userRepository.findById(request.user1Id).orElseThrow();
        User user2 = userRepository.findById(request.user2Id).orElseThrow();

        return messageRepository.loadConversation(
            user1, user2
        );
    }
}