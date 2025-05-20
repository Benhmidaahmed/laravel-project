package com.example.demo.Controller;
import com.example.demo.dto.PsychologistDto;
import com.example.demo.entities.Role;
import com.example.demo.repository.UserRepository;
import org.springframework.web.bind.annotation.*;
import java.util.List;
import java.util.stream.Collectors;
@RestController
@RequestMapping("/api/psychologists")
@CrossOrigin(origins = "*")
public class PsychologistController {
  private final UserRepository repo;
  public PsychologistController(UserRepository repo) { this.repo = repo; }

  @GetMapping
  public List<PsychologistDto> listAll() {
    return repo.findByRoles(Role.Psy)
      .stream()
      .map(u -> new PsychologistDto(
         u.getId(),
         u.getFirstName(),
         u.getLastName(),
         u.getSpecialization(),
         u.getUrlImage()
      ))
      .collect(Collectors.toList());
  }
}
