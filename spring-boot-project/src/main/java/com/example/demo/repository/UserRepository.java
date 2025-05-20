package com.example.demo.repository;

import com.example.demo.entities.User;
import com.example.demo.entities.Role; // ➡️ Import CORRECT (votre enum)
import org.springframework.data.jpa.repository.JpaRepository;
// import org.springframework.data.jpa.repository.Query;
// import org.springframework.data.repository.query.Param;

import java.util.List;
import java.util.Optional;

public interface UserRepository extends JpaRepository<User, Integer> {
    List<User> findByRoles(Role role);
 
    Optional<User> findByEmail(String email);
}
