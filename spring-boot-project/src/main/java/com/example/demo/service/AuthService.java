package com.example.demo.service;

import com.example.demo.entities.*;
import com.example.demo.repository.UserRepository;
import lombok.RequiredArgsConstructor;

import java.time.LocalDateTime;
import java.util.HashMap;
import java.util.Map;

import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

@Service
@RequiredArgsConstructor
public class AuthService {

    private final UserRepository userRepo;
    private final ConfirmationTokenService tokenService;
    private final EmailService emailService;
    private final PasswordEncoder passwordEncoder;
    private final AuthenticationManager authManager;
    private final CustomUserDetailsService customUserDetailsService; // Ajouté
    private final JwtService jwtService; // Ajouté

    public String register(User user,Role role) {
        if (userRepo.findByEmail(user.getEmail()).isPresent()) {
            return "Email already registered.";
        }

        user.setPassword(passwordEncoder.encode(user.getPassword()));
        user.setRoles(role);
        user.setEnabled(false);
        userRepo.save(user);

        ConfirmationToken token = tokenService.createToken(user);

        String link = "http://localhost:8084/api/auth/confirm?token=" + token.getToken();
        String body = "Clique ici pour confirmer ton compte :\n" + link;

        emailService.sendEmail(user.getEmail(), "Confirmation de compte", body);

        return "Inscription réussie ! Vérifie ton email pour confirmer ton compte.";
    }



    public Map<String, Object> login(String email, String password) {
        // 1. Vérifier que l'utilisateur existe
        User user = userRepo.findByEmail(email)
                .orElseThrow(() -> new RuntimeException("Email ou mot de passe incorrect"));
        
        // 2. Vérifier que le compte est confirmé
        if (!user.isEnabled()) {
            throw new RuntimeException("Veuillez confirmer votre email avant de vous connecter");
        }
    
        // 3. Authentifier
        authManager.authenticate(
            new UsernamePasswordAuthenticationToken(email, password)
        );
        
        // 4. Charger les UserDetails et générer le token
        UserDetails userDetails = customUserDetailsService.loadUserByUsername(email);
        String token = jwtService.generateToken(userDetails);
        
        // 5. Retourner la réponse enrichie
        Map<String, Object> response = new HashMap<>();
        response.put("token", token);
        response.put("message", "Connexion réussie !");
        response.put("userId",   user.getId());  
        response.put("role", user.getRoles().name()); // Ajout du rôle directement
        
        return response;
    }
    public String confirmToken(String tokenValue) {
        ConfirmationToken token = tokenService.getToken(tokenValue);

        if (token == null || token.getExpiresAt().isBefore(LocalDateTime.now())) {
            return "Lien invalide ou expiré.";
        }

        User user = token.getUser();
        user.setEnabled(true);
        userRepo.save(user);
        tokenService.deleteToken(token);

        return "Compte confirmé avec succès !";
    }
}
