package com.example.demo.entities;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Table;
import java.time.LocalDateTime;
import java.time.ZonedDateTime;

@Entity
@Table(name = "Appointment")
public class Appointment {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private int id;
    private String client;

    private ZonedDateTime date;
    private String status;
    private int userId;
    private LocalDateTime createdAt;
    private LocalDateTime updatedAt;
     @Column(name = "E-mail")
    private String email;

    public String getEmail() {
        return email;
    }
    
    public Appointment setEmail(String email) {
        this.email = email;
        return this;
    }


    public int getId() {
        return id;
    }

    public String getClient() {
        return client;
    }

    public Appointment setClient(String client) {
        this.client = client;
        return this;
    }

    public ZonedDateTime getDate() {
        return date;
    }

    public Appointment setDate(ZonedDateTime date) {
        this.date = date;
        return this;
    }

    public String getStatus() {
        return status;
    }

    public Appointment setStatus(String status) {
        this.status = status;
        return this;
    }

    public LocalDateTime getCreatedAt() {
        return createdAt;
    }

    public Appointment setCreatedAt(LocalDateTime createdAt) {
        this.createdAt = createdAt;
        return this;
    }

    public LocalDateTime getUpdatedAt() {
        return updatedAt;
    }

    public Appointment setUpdatedAt(LocalDateTime updatedAt) {
        this.updatedAt = updatedAt;
        return this;
    }

    public int getUserId() {
        return userId;
    }

    public Appointment setUserId(int userId) {
        this.userId = userId;
        return this;
    }

}
