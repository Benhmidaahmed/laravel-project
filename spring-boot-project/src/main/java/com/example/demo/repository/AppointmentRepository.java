package com.example.demo.repository;

import com.example.demo.entities.Appointment;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;

public interface AppointmentRepository extends JpaRepository<Appointment,Integer> {
    List<Appointment> findByUserId(int userId);
}