// package com.example.demo.Controller;

// import com.example.demo.dto.LoginRequest;
// import com.example.demo.dto.PsychologistRegisterRequest;
// import com.example.demo.dto.StudentRegisterRequest;
// import com.example.demo.entities.Role;
// import com.example.demo.entities.User;
// import com.example.demo.service.AuthService;
// import lombok.RequiredArgsConstructor;

// import java.util.Map;

// import org.springframework.http.ResponseEntity;
// import org.springframework.web.bind.annotation.*;

// @RestController
// @RequestMapping("/api/auth")
// @RequiredArgsConstructor
// public class AuthController {

//     private final AuthService authService;

//     // Inscription avec envoi d’email
   
//     @PostMapping("/student/register")
//     public String registerStudent(@RequestBody StudentRegisterRequest request) {
//         User user = new User();
//         // Set common fields
//         user.setFirstName(request.getFirstName());
//         user.setLastName(request.getLastName());
//         user.setEmail(request.getEmail());
//         user.setPassword(request.getPassword());
//         user.setNumTel(request.getPhoneNumber());
        
//         // Set student-specific fields
//         user.setStudentCardNumber(request.getStudentCardNumber());
//         user.setUniversity(request.getUniversity());
//         user.setStudyLevel(request.getStudyLevel());
        
//         return authService.register(user, Role.STUDENT);
//     }

//     @PostMapping("/psychologist/register")
//     public String registerPsychologist(@RequestBody PsychologistRegisterRequest request) {
//         User user = new User();
//         // Set common fields
//         user.setFirstName(request.getFirstName());
//         user.setLastName(request.getLastName());
//         user.setEmail(request.getEmail());
//         user.setPassword(request.getPassword());
//         user.setNumTel(request.getPhoneNumber());
        
//         // Set psychologist-specific fields
//         user.setAdeliNumber(request.getAdeliNumber());
//         user.setSpecialization(request.getSpecialization());
        
//         return authService.register(user, Role.Psy);
//     }


//     // Connexion simple (on peut plus tard ajouter un token JWT)
//     @PostMapping("/login")
//     public ResponseEntity<?> login(@RequestBody LoginRequest loginRequest) {
//         try {
//             // Modifiez pour retourner plus d'informations
//             Map<String, Object> response = authService.login(loginRequest.getEmail(), loginRequest.getPassword());
//             return ResponseEntity.ok(response);
//         } catch (RuntimeException e) {
//             return ResponseEntity.status(401).body(e.getMessage());
//         }
//     }

//     // Confirmation de compte via lien reçu par email
//     @GetMapping("/confirm")
//     public String confirm(@RequestParam String token) {
//         return authService.confirmToken(token);
//     }
// }
package com.example.demo.Controller;

import com.example.demo.dto.LoginRequest;
import com.example.demo.entities.Role;
import com.example.demo.entities.User;
import com.example.demo.service.AuthService;
import com.example.demo.service.FileStorageService;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.Map;

@RestController
@RequestMapping("/api/auth")
public class AuthController {

    private final AuthService authService;
    private final FileStorageService fileStorageService;

    public AuthController(AuthService authService, FileStorageService fileStorageService) {
        this.authService = authService;
        this.fileStorageService = fileStorageService;
    }

    // Inscription étudiant (multipart/form-data afin de gérer un upload optionnel)
    @PostMapping(path = "/student/register", consumes = MediaType.MULTIPART_FORM_DATA_VALUE)
    public ResponseEntity<?> registerStudent(
            @RequestPart("firstName") String firstName,
            @RequestPart("lastName") String lastName,
            @RequestPart("email") String email,
            @RequestPart("password") String password,
            @RequestPart("phoneNumber") String phoneNumber,
            @RequestPart("studentCardNumber") String studentCardNumber,
            @RequestPart("university") String university,
            @RequestPart("studyLevel") String studyLevel,
            @RequestPart(value = "profileImage", required = false) MultipartFile profileImage
    ) throws IOException {
        User user = new User();
        user.setFirstName(firstName);
        user.setLastName(lastName);
        user.setEmail(email);
        user.setPassword(password);
        user.setNumTel(phoneNumber);
        user.setStudentCardNumber(studentCardNumber);
        user.setUniversity(university);
        user.setStudyLevel(studyLevel);

        if (profileImage != null && !profileImage.isEmpty()) {
            String imageUrl = fileStorageService.storeFile(profileImage);
            user.setUrlImage(imageUrl);
        }

        authService.register(user, Role.STUDENT);
        return ResponseEntity.ok("Inscription de l'étudiant réussie");
    }

    // Inscription psychologue (multipart/form-data pour upload obligatoire ou non)
    @PostMapping(path = "/psychologist/register", consumes = MediaType.MULTIPART_FORM_DATA_VALUE)
    public ResponseEntity<?> registerPsychologist(
            @RequestPart("firstName") String firstName,
            @RequestPart("lastName") String lastName,
            @RequestPart("email") String email,
            @RequestPart("password") String password,
            @RequestPart("phoneNumber") String phoneNumber,
            @RequestPart("adeliNumber") String adeliNumber,
            @RequestPart("specialization") String specialization,
            @RequestPart(value = "profileImage", required = false) MultipartFile profileImage
    ) throws IOException {
        User user = new User();
        user.setFirstName(firstName);
        user.setLastName(lastName);
        user.setEmail(email);
        user.setPassword(password);
        user.setNumTel(phoneNumber);
        user.setAdeliNumber(adeliNumber);
        user.setSpecialization(specialization);

        if (profileImage != null && !profileImage.isEmpty()) {
            String imageUrl = fileStorageService.storeFile(profileImage);
            user.setUrlImage(imageUrl);
        }

        authService.register(user, Role.Psy);
        return ResponseEntity.ok("Inscription du psychologue réussie");
    }

    // Connexion
    @PostMapping("/login")
    public ResponseEntity<?> login(@RequestBody LoginRequest loginRequest) {
        try {
            Map<String, Object> response = authService.login(
                    loginRequest.getEmail(),
                    loginRequest.getPassword()
            );
            return ResponseEntity.ok(response);
        } catch (RuntimeException e) {
            return ResponseEntity.status(401).body(e.getMessage());
        }
    }

    // Confirmation de compte via token
    @GetMapping("/confirm")
    public String confirm(@RequestParam String token) {
        return authService.confirmToken(token);
    }
}
