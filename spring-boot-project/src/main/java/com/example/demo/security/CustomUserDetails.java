// package com.example.demo.security;

// import com.example.demo.entities.User;
// import lombok.Getter;
// import org.springframework.security.core.GrantedAuthority;
// import org.springframework.security.core.authority.SimpleGrantedAuthority;
// import org.springframework.security.core.userdetails.UserDetails;

// import java.util.Collection;
// import java.util.List;

// @Getter
// public class CustomUserDetails implements UserDetails {
//     private final User user;

//     public CustomUserDetails(User user) {
//         this.user = user;
//     }

//     // Expose the DB primary key of the user
//     public int getId() {
//         return user.getId();
//     }

//     @Override
//     public Collection<? extends GrantedAuthority> getAuthorities() {
//         // Map Role enum to Spring Security authorities
//         return List.of(
//             new SimpleGrantedAuthority("ROLE_" + user.getRoles().name())
//         );
//     }

//     @Override
//     public String getPassword() {
//         return user.getPassword();
//     }

//     @Override
//     public String getUsername() {
//         return user.getEmail();
//     }

//     @Override
//     public boolean isAccountNonExpired() {
//         return true;
//     }

//     @Override
//     public boolean isAccountNonLocked() {
//         return true;
//     }

//     @Override
//     public boolean isCredentialsNonExpired() {
//         return true;
//     }

//     @Override
//     public boolean isEnabled() {
//         return true;
//     }
// }