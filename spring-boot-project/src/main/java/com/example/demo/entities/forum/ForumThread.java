package com.example.demo.entities.forum;

import java.util.List;

import com.example.demo.entities.User;
import com.fasterxml.jackson.annotation.JsonIgnore;
import com.fasterxml.jackson.annotation.JsonManagedReference;

import jakarta.persistence.CascadeType;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.Id;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.OneToMany;

@Entity
public class ForumThread {
    @Id 
    @GeneratedValue
    private Long id;
    private String title;

    @ManyToOne
    private User author;

    @OneToMany(mappedBy = "thread", cascade = CascadeType.ALL)
    //important pour eviter la recursion infini mta3 el java
    //mathalan yebda 3andk ken element bark fel table mte3ik 
    //el endpoint yraja3 body m3ebi bel 7aja heya bidha
    @JsonManagedReference
    private List<Post> posts;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public User getAuthor() {
        return author;
    }

    public void setAuthor(User author) {
        this.author = author;
    }

    public List<Post> getPosts() {
        return posts;
    }

    public void setPosts(List<Post> posts) {
        this.posts = posts;
    }


    
}
