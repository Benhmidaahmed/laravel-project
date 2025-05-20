package com.example.demo.dto;

public class PsychologistRegisterRequest extends RegisterRequest {
    private String adeliNumber;
    private String specialization;

    // Getter and Setter for adeliNumber
    public String getAdeliNumber() {
        return adeliNumber;
    }
    public void setAdeliNumber(String adeliNumber) {
        this.adeliNumber = adeliNumber;
    }

    // Getter and Setter for specialization
    public String getSpecialization() {
        return specialization;
    }
    public void setSpecialization(String specialization) {
        this.specialization = specialization;
    }
}
