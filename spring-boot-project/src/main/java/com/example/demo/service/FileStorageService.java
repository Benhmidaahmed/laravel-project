package com.example.demo.service;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;
import org.springframework.util.StringUtils;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.io.InputStream;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;

@Service
public class FileStorageService {

    @Value("${file.upload-dir}")
    private String uploadDir;

    /**
     * Stores the given file in the configured upload directory.
     * Returns the URL path that can be used to access the file.
     */
    public String storeFile(MultipartFile file) throws IOException {
        // Normalize filename
        String originalFilename = StringUtils.cleanPath(file.getOriginalFilename());
        if (originalFilename.contains("..")) {
            throw new IOException("Invalid path sequence in file name " + originalFilename);
        }

        // Ensure directory exists
        Path targetLocation = Paths.get(uploadDir).toAbsolutePath().normalize();
        Files.createDirectories(targetLocation);

        // Copy file to the target location (replacing existing file with same name)
        try (InputStream in = file.getInputStream()) {
            Path destination = targetLocation.resolve(originalFilename);
            Files.copy(in, destination, StandardCopyOption.REPLACE_EXISTING);
        }

        // Return the publicly accessible URL (this assumes you configured /images/** to serve from uploadDir)
        return "/images/" + originalFilename;
    }
}
