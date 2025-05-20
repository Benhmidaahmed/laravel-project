package com.example.demo.entities;

import jakarta.persistence.*;

@Entity
@Table(name = "users")
public class User {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private int id;

    @Column(unique = true)
    private String email;

    private String password;

    private String firstName;

    private String lastName;

    private String numTel;

    private String urlImage;

    @Enumerated(EnumType.STRING) // Important pour stocker le nom de l'enum
    private Role roles;
    // ou `@Enumerated(EnumType.STRING)` si tu veux utiliser un enum

    private boolean enabled = false; // Pour activer le compte après email

    private String provider; // Pour savoir si c’est google, facebook, ou local
// Champs spécifiques aux étudiants
private String studentCardNumber;
private String university;
private String studyLevel; // L1, L2, L3, M1, M2

// Champs spécifiques aux psychologues
private String adeliNumber;
private String specialization;
// Ajoutez les nouveaux getters et setters
public String getStudentCardNumber() {
    return studentCardNumber;
}

public void setStudentCardNumber(String studentCardNumber) {
    this.studentCardNumber = studentCardNumber;
}

public String getUniversity() {
    return university;
}

public void setUniversity(String university) {
    this.university = university;
}

public String getStudyLevel() {
    return studyLevel;
}

public void setStudyLevel(String studyLevel) {
    this.studyLevel = studyLevel;
}

public String getAdeliNumber() {
    return adeliNumber;
}

public void setAdeliNumber(String adeliNumber) {
    this.adeliNumber = adeliNumber;
}

public String getSpecialization() {
    return specialization;
}

public void setSpecialization(String specialization) {
    this.specialization = specialization;
}
    // Getters and Setters

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public Role getRoles() {
        return roles;
    }
    
    public void setRoles(Role roles) {
        this.roles = roles;
    }
    

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getNumTel() {
        return numTel;
    }

    public void setNumTel(String numTel) {
        this.numTel = numTel;
    }

    public String getUrlImage() {
        return urlImage;
    }

    public void setUrlImage(String urlImage) {
        this.urlImage = urlImage;
    }

    public boolean isEnabled() {
        return enabled;
    }

    public void setEnabled(boolean enabled) {
        this.enabled = enabled;
    }

    public String getProvider() {
        return provider;
    }

    public void setProvider(String provider) {
        this.provider = provider;
    }

   
}
