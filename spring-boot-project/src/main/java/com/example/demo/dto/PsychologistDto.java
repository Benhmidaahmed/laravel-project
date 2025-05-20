package com.example.demo.dto;

public class PsychologistDto {
    private Integer id;
  private String firstName;
  private String lastName;
  private String specialization;
  private String urlImage;
  public Integer getId() {
    return id;
  }
  public String getFirstName() {
    return firstName;
  }
  public String getLastName() {
    return lastName;
  }
  public String getSpecialization() {
    return specialization;
  }
  public String getUrlImage() {
    return urlImage;
  }
  public void setId(Integer id) {
    this.id = id;
  }
  public void setFirstName(String firstName) {
    this.firstName = firstName;
  }
  public void setLastName(String lastName) {
    this.lastName = lastName;
  }
  public void setSpecialization(String specialization) {
    this.specialization = specialization;
  }
  public void setUrlImage(String urlImage) {
    this.urlImage = urlImage;
  }
  public PsychologistDto(Integer id, String firstName, String lastName, String specialization, String urlImage) {
    this.id = id;
    this.firstName = firstName;
    this.lastName = lastName;
    this.specialization = specialization;
    this.urlImage = urlImage;
  }
  
}
