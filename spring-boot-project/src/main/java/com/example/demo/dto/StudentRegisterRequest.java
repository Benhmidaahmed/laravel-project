package com.example.demo.dto;

public class StudentRegisterRequest extends RegisterRequest {
    private String studentCardNumber;
    private String university;
    private String studyLevel;

    // Getter and Setter for studentCardNumber
    public String getStudentCardNumber() {
        return studentCardNumber;
    }
    public void setStudentCardNumber(String studentCardNumber) {
        this.studentCardNumber = studentCardNumber;
    }

    // Getter and Setter for university
    public String getUniversity() {
        return university;
    }
    public void setUniversity(String university) {
        this.university = university;
    }

    // Getter and Setter for studyLevel
    public String getStudyLevel() {
        return studyLevel;
    }
    public void setStudyLevel(String studyLevel) {
        this.studyLevel = studyLevel;
    }
}
