<template>
    <div class="forum-page">
      <!-- Create a new thread -->
      <section class="new-thread">
        <input
          v-model="newThreadTitle"
          placeholder="Enter new thread title"
        />
        <button @click="createThread">Create Thread</button>
      </section>
      <section class="threads">
        <h2>Threads</h2>
        <ul>
          <li
            v-for="thread in threads"
            :key="thread.id"
            :class="{ active: selectedThread?.id === thread.id }"
            @click="selectThread(thread)"
          >
            {{ thread.title }}
            <small>by {{ thread.author.username || thread.author.email }}</small>
          </li>
        </ul>
      </section>
      <!-- Posts in the selected thread -->
      <section
        v-if="selectedThread"
        class="posts"
      >
        <h3>Posts: "{{ selectedThread.title }}"</h3>
  
        <div class="new-post">
          <textarea
            v-model="newPostContent"
            placeholder="Write a post..."
          />
          <button @click="createPost">Post</button>
        </div>
  
        <ul>
          <li
            v-for="post in posts"
            :key="post.id"
            :class="{ active: selectedPost?.id === post.id }"
            @click="selectPost(post)"
          >
            <p>{{ post.content }}</p>
            <small>by {{ post.author.username || post.author.email }}</small>
          </li>
        </ul>
      </section>
  
      <!-- Comments on the selected post -->
      <section
        v-if="selectedPost"
        class="comments"
      >
        <h4>Comments on Post #{{ selectedPost.id }}</h4>
  
        <div class="new-comment">
          <input
            v-model="newCommentText"
            placeholder="Add a comment..."
          />
          <button @click="createComment">Comment</button>
        </div>
  
        <ul>
          <li
            v-for="comment in comments"
            :key="comment.id"
          >
            <p>{{ comment.text }}</p>
            <small>by {{ comment.author.username || comment.author.email }}</small>
          </li>
        </ul>
      </section>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  
  interface User {
    id: number
    username?: string
    email?: string
  }
  
  interface ForumThread {
    id: number
    title: string
    author: User
  }
  
  interface Post {
    id: number
    content: string
    author: User
  }
  
  interface Comment {
    id: number
    text: string
    author: User
  }
  
  const threads = ref<ForumThread[]>([])
  const selectedThread = ref<ForumThread | null>(null)
  const posts = ref<Post[]>([])
  const selectedPost = ref<Post | null>(null)
  const comments = ref<Comment[]>([])
  
  const newThreadTitle = ref('')
  const newPostContent = ref('')
  const newCommentText = ref('')
  
  // TODO: replace with real current user ID from your auth
  const currentUserId = 1
  
  async function fetchThreads() {
    try {
      const { data } = await axios.get<ForumThread[]>('http://localhost:8084/api/forum/threads')
      threads.value = data
    } catch (err) {
      console.error('Error loading threads', err)
    }
  }
  
  async function selectThread(thread: ForumThread) {
    selectedThread.value = thread
    selectedPost.value = null
    comments.value = []
    newPostContent.value = ''
  
    try {
      const { data } = await axios.get<Post[]>(
        `/api/forum/threads/${thread.id}/posts`
      )
      posts.value = data
    } catch (err) {
      console.error('Error loading posts', err)
    }
  }
  
  async function selectPost(post: Post) {
    selectedPost.value = post
    newCommentText.value = ''
  
    try {
      const { data } = await axios.get<Comment[]>(
        `/api/forum/posts/${post.id}/comments`
      )
      comments.value = data
    } catch (err) {
      console.error('Error loading comments', err)
    }
  }
  
  async function createThread() {
    if (!newThreadTitle.value.trim()) return
    try {
      const { data } = await axios.post<ForumThread>(
        '/api/forum/threads',
        { title: newThreadTitle.value, author_id: currentUserId }
      )
      threads.value.push(data)
      newThreadTitle.value = ''
    } catch (err) {
      console.error('Error creating thread', err)
    }
  }
  
  async function createPost() {
  if (!selectedThread.value || !newPostContent.value.trim()) return
  try {
    const { data } = await axios.post<Post>(
      `/api/forum/threads/${selectedThread.value.id}/posts`, // Remove /forum
      { 
        content: newPostContent.value, 
        author_id: currentUserId 
      }
    )
    posts.value.push(data)
    newPostContent.value = ''
  } catch (err) {
    console.error('Error creating post', err.response?.data || err.message)
  }
}
  
  async function createComment() {
    if (!selectedPost.value || !newCommentText.value.trim()) return
    try {
      const { data } = await axios.post<Comment>(
        `/api/forum/posts/${selectedPost.value.id}/comments`,
        { text: newCommentText.value, author_id: currentUserId }
      )
      comments.value.push(data)
      newCommentText.value = ''
    } catch (err) {
      console.error('Error creating comment', err)
    }
  }
  
  onMounted(fetchThreads)
  </script>
  
  <style scoped>
  .forum-page {
    max-width: 800px;
    margin: auto;
    padding: 1rem;
  }
  section {
    margin-bottom: 2rem;
  }
  ul {
    list-style: none;
    padding: 0;
  }
  li {
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 0.5rem;
    cursor: pointer;
  }
  li.active {
    background-color: #f0f0f0;
  }
  .new-thread,
  .new-post,
  .new-comment {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
  }
  .new-post textarea {
    flex: 1;
    resize: vertical;
  }
  .new-thread input,
  .new-comment input {
    flex: 1;
    padding: 0.5rem;
  }
  button {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  button:hover {
    background-color: #eee;
  }
  </style>
  