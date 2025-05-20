package com.example.demo.Controller;

import com.example.demo.dto.CreateAppointmentRequest;
import com.example.demo.entities.Appointment;
import com.example.demo.service.AppointmentService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/appointments")
public class AppointmentController {
    @Autowired
    private AppointmentService appointmentService;

    @PostMapping
    public ResponseEntity<Appointment> createAppointment(
            @RequestBody CreateAppointmentRequest req) {
        Appointment saved = appointmentService.createAppointment(
            req.getClient(), req.getDate(), req.getUserId(), req.getEmail());
        return ResponseEntity.status(HttpStatus.CREATED).body(saved);
    }

    }