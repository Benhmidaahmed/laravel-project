package com.example.demo.service;

import com.example.demo.entities.ConfirmationToken;
import com.example.demo.entities.User;
import com.example.demo.repository.ConfirmationTokenRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.util.UUID;

@Service
@RequiredArgsConstructor
public class ConfirmationTokenService {

    private final ConfirmationTokenRepository tokenRepo;

    public ConfirmationToken createToken(User user) {
        String token = UUID.randomUUID().toString();
        ConfirmationToken confirmationToken = ConfirmationToken.builder()
                .token(token)
                .user(user)
                .createdAt(LocalDateTime.now())
                .expiresAt(LocalDateTime.now().plusMinutes(30))
                .build();

        return tokenRepo.save(confirmationToken);
    }

    public ConfirmationToken getToken(String token) {
        return tokenRepo.findByToken(token).orElse(null);
    }

    public void deleteToken(ConfirmationToken token) {
        tokenRepo.delete(token);
    }
}
