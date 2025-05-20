   

package com.example.demo.Controller;

import com.example.demo.entities.Appointment;
import com.example.demo.repository.AppointmentRepository;

import java.util.List;

import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController

@RequestMapping("/api/appointments")
@CrossOrigin(origins = "*")
public class UserController {

    private final AppointmentRepository appointmentRepository;

    public UserController(AppointmentRepository appointmentRepository) {
        this.appointmentRepository = appointmentRepository;
    }

    @PostMapping("/submit")
    public ResponseEntity<String> submitAppointment(@RequestBody Appointment appointment) {
        System.out.println("Received appointment: " + appointment);

        if (appointment.getClient() == null || appointment.getDate() == null) {
            return ResponseEntity.badRequest().body("Missing required fields!");
        }

        appointmentRepository.save(appointment);
        return ResponseEntity.ok("Appointment saved successfully!");
    }
    @GetMapping
    public ResponseEntity<List<Appointment>> getAllAppointments() {
        return ResponseEntity.ok(appointmentRepository.findAll());
    }
    
    
}
