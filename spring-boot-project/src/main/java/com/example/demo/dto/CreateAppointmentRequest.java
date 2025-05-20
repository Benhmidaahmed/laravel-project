package com.example.demo.dto;

import java.time.ZonedDateTime;

public class CreateAppointmentRequest {
    private String client;
    private ZonedDateTime date;
    private int userId;
    private String email;

    // Getters and setters
    public String getClient() { return client; }
    public void setClient(String client) { this.client = client; }

    public ZonedDateTime getDate() { return date; }
    public void setDate(ZonedDateTime date) { this.date = date; }

    public int getUserId() { return userId; }
    public void setUserId(int userId) { this.userId = userId; }

    public String getEmail() { return email; }
    public void setEmail(String email) { this.email = email; }
}