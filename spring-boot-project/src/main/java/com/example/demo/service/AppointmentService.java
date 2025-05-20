package com.example.demo.service;
import com.example.demo.entities.Appointment;
import com.example.demo.repository.AppointmentRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.time.ZonedDateTime;
import java.util.List;

@Service
public class AppointmentService {
    @Autowired
    private AppointmentRepository appointmentRepo;

    public Appointment createAppointment(
            String client, ZonedDateTime date, int userId, String email) {
        Appointment appt = new Appointment()
            .setClient(client)
            .setDate(date)
            .setUserId(userId)
            .setEmail(email)
            .setStatus("PENDING")
            .setCreatedAt(LocalDateTime.now());
        return appointmentRepo.save(appt);
    }

    public List<Appointment> getAppointmentsByPsychologist(int userId) {
        return appointmentRepo.findByUserId(userId);
    }
}