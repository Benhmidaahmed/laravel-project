<template>
  <div class="forum-chat-wrapper">
    <!-- SIDEBAR: THREADS -->
    <aside class="forum-sidebar">
      <div class="sidebar-header">
        <h3>Threads</h3>
      </div>
      <div class="sidebar-threads">
        <div class="new-thread">
          <input
            v-model="newThreadTitle"
            placeholder="New thread title"
          />
          <button @click="createThread">+</button>
        </div>
        <ul>
          <li
            v-for="thread in threads"
            :key="thread.id"
            :class="{ active: selectedThread?.id === thread.id }"
            @click="selectThread(thread)"
          >
            <span class="thread-title">{{ thread.title }}</span>
            <span class="thread-author">{{ thread.author_id.username || thread.author_id.email }}</span>
          </li>
        </ul>
      </div>
    </aside>

    <!-- MAIN: POST + COMMENTS -->
    <main class="forum-main">
      <div v-if="selectedThread" class="thread-content">
        <div class="thread-header">
          <h2>{{ selectedThread.title }}</h2>
        </div>
        
        <!-- If a post is selected, show only that post and its comments -->
        <div v-if="selectedPost">
          <div class="selected-post-bubble">
            <span class="author">{{ selectedPost.author_id.username || selectedPost.author_id.email }}</span>
            <div class="bubble-message">{{ selectedPost.content }}</div>
            <button class="back-btn" @click="selectedPost = null">← Back to posts</button>
          </div>
          <div class="comments-title">Comments</div>
          <div class="comments-list">
            <div
              v-for="comment in comments"
              :key="comment.id"
              class="comment-bubble"
            >
              <span class="author">{{ comment.author_id.username || comment.author_id.email }}</span>
              <div class="bubble-message">{{ comment.text }}</div>
            </div>
          </div>
          <div class="new-comment-row">
            <input
              v-model="newCommentText"
              placeholder="Add a comment..."
            />
            <button @click="createComment">Send</button>
          </div>
        </div>

        <!-- If NO post is selected, show all posts -->
        <div v-else>
          <div class="posts-chat">
            <div
              v-for="post in posts"
              :key="post.id"
              class="post-bubble"
              @click="selectPost(post)"
            >
              <div class="bubble-content">
                <span class="author">{{ post.author_id.username || post.author_id.email }}</span>
                <div class="bubble-message">{{ post.content }}</div>
              </div>
            </div>
          </div>
          <div class="new-post-row">
            <textarea v-model="newPostContent" placeholder="Write a post..."></textarea>
            <button @click="createPost">Post</button>
          </div>
        </div>
      </div>
      <div v-else class="empty-message">
        <p>Select a thread to view posts.</p>
      </div>
    </main>
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
  author_id: User
}

interface Post {
  id: number
  content: string
  author_id: User
}

interface Comment {
  id: number
  text: string
  author_id: User
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
      `/api/forum/threads/${selectedThread.value.id}/posts`,
      { 
        content: newPostContent.value, 
        author_id: currentUserId 
      }
    )
    posts.value.push(data)
    newPostContent.value = ''
  } catch (err) {
    if (typeof err === 'object' && err !== null && 'response' in err) {
      console.error('Error creating post', (err as any).response?.data || (err as any).message)
    } else {
      console.error('Error creating post', err)
    }
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
 
  .new-comment-row {
  display: flex;
  align-items: center;
  gap: 0.7rem;
  margin-top: 1.2rem;
  margin-bottom: 0.6rem;
  background: #f5fafd;
  padding: 0.7rem 1rem;
  border-radius: 1.2rem;
  box-shadow: 0 1px 7px rgba(80, 118, 255, 0.04);
}

.new-comment-row input {
  flex: 1;
  border-radius: 1.2rem;
  border: 1.3px solid #dae4f7;
  font-size: 1.09rem;
  padding: 0.83rem 1.4rem;
  background: #fff;
  outline: none;
}

.new-comment-row button {
  background: #4b8ef1;
  color: #fff;
  border: none;
  border-radius: 1.1rem;
  font-size: 1.13rem;
  font-weight: 600;
  padding: 0.7rem 2.1rem;
  cursor: pointer;
  box-shadow: 0 2px 10px rgba(80, 118, 255, 0.09);
  transition: background .16s;
}

.new-comment-row button:hover {
  background: #4b8ef1;
}
.selected-post-bubble + .comments-title + .comments-list + .new-comment-row {
  position: sticky;
  bottom: 0;
  z-index: 2;
  background: #f7fafd;
}

  .back-btn {
  margin-top: 1.1rem;
  background: #4b8ef1;
  color: #fff;
  border: none;
  border-radius: 1rem;
  font-size: 1rem;
  font-weight: 500;
  padding: 0.46rem 1.3rem;
  cursor: pointer;
  box-shadow: 0 2px 10px rgba(80, 118, 255, 0.08);
  transition: background .14s;
  display: inline-block;
}
.back-btn:hover {
  background: #4b8ef1;
}

  .forum-chat-wrapper {
  display: flex;
  height: 90vh;
  min-height: 540px;
  max-width: 1300px;
  margin: 32px auto;
  background: #fafbfc;
  border-radius: 20px;
  box-shadow: 0 12px 32px 0 rgba(90,110,145,.11), 0 2.5px 6px #ececec;
  overflow: hidden;
}

/* SIDEBAR */
.forum-sidebar {
  width: 290px;
  background: #f4f6fa;
  border-right: 1.5px solid #e9eef4;
  display: flex;
  flex-direction: column;
  padding: 0 0 0 0;
}

.sidebar-header {
  padding: 1.7rem 1.2rem 1rem 1.7rem;
  font-weight: 700;
  font-size: 1.3rem;
  border-bottom: 1.5px solid #e9eef4;
  color: #233862;
  background: #f6f8fc;
  letter-spacing: -.5px;
}

.sidebar-threads {
  flex: 1;
  overflow-y: auto;
  padding: 1.5rem 0.9rem 0.7rem 1.2rem;
}

.new-thread {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1.1rem;
}

.new-thread input {
  flex: 1;
  border-radius: 8px;
  border: 1.1px solid #d4e2f8;
  padding: 0.7rem 1rem;
  font-size: 1.01rem;
  background: #fff;
  transition: border 0.15s;
}

.new-thread input:focus {
  border: 1.2px solid #5c8efd;
}

.new-thread button {
  background: #4b8ef1;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1.4rem;
  width: 2.5rem;
  cursor: pointer;
  font-weight: bold;
  box-shadow: 0 2px 8px rgba(80, 118, 255, 0.07);
  transition: background .16s;
}

.new-thread button:hover { background: #4b8ef1; }

.sidebar-threads ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.sidebar-threads li {
  padding: 0.8rem 0.85rem;
  border-radius: 10px;
  background: #fff;
  margin-bottom: 0.5rem;
  cursor: pointer;
  border: none;
  font-size: 1.05rem;
  display: flex;
  flex-direction: column;
  gap: 0.11rem;
  box-shadow: 0 1px 5px rgba(80, 118, 255, 0.03);
  transition: background 0.14s;
}

.sidebar-threads li.active, .sidebar-threads li:hover {
  background: #e6edfb;
}

.thread-title { font-weight: 500; }
.thread-author { font-size: 0.93rem; color: #6b8199; }

/* MAIN AREA */
.forum-main {
  flex: 1;
  background: #f7fafd;
  display: flex;
  flex-direction: column;
  padding: 0;
  min-width: 0;
  height: 100%;
  position: relative;
}

.thread-content {
  height: 100%;
  display: flex;
  flex-direction: column;
  padding: 2.5rem 3rem 1.8rem 3rem; /* Spacing around main area */
  min-width: 0;
}

.thread-header h2 {
  font-size: 1.6rem;
  margin-bottom: 1.3rem;
  font-weight: 700;
  color: #253858;
  letter-spacing: -.7px;
}

.posts-chat {
  flex: none;
  display: flex;
  flex-direction: column;
  gap: 0.8rem;
  margin-bottom: 1.5rem;
}

.post-bubble {
  display: flex;
  align-items: flex-start;
  margin-bottom: 0.3rem;
  padding: 0.09rem;
  cursor: pointer;
  background: transparent;
  transition: background 0.15s;
}

.post-bubble.selected-post, .post-bubble:hover {
  background: #eef4fb;
  border-radius: 18px;
}

.bubble-content {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.bubble-content .author {
  font-size: 0.99rem;
  color: #5077b7;
  font-weight: 600;
  margin-bottom: 0.22rem;
}

.bubble-message {
  background: #f8fafc;
  color: #222c37;
  padding: 0.8rem 1.35rem 0.9rem 1.35rem;
  border-radius: 1.6rem;
  font-size: 1.11rem;
  box-shadow: 0 2px 8px rgba(65, 88, 158, 0.06);
  margin-bottom: 0.1rem;
}

.selected-post-bubble {
  background: #e5edfa;
  border-radius: 1.4rem;
  padding: 1.1rem 1.7rem;
  margin-bottom: 1.15rem;
  font-size: 1.14rem;
}

.selected-post-bubble .author {
  font-weight: bold;
  color: #4b8ef1;
  font-size: 1rem;
  margin-bottom: 0.3rem;
}

.comments-title {
  font-size: 1.09rem;
  font-weight: 600;
  color: #7d92b4;
  margin-bottom: 0.6rem;
  margin-top: 0.5rem;
}
.comments-container {
  display: flex;
  flex-direction: column;
  flex: 1;
  min-height: 0;
  background: #f7fafd;
  border-radius: 1.1rem;
  box-shadow: 0 1px 8px rgba(80, 118, 255, 0.04);
  padding: 1rem 0.2rem 0.5rem 0.2rem;
  margin-bottom: 0.2rem;
  height: 34vh;          /* <<<< ADJUST THIS TO MAKE COMMENTS ZONE TALLER/SHORTER */
  max-height: 38vh;      /* <<<< MAX HEIGHT FOR COMMENTS ZONE */
  position: relative;
}
.comments-list {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  max-height: 26vh;      /* <<<< ADJUST THIS FOR COMMENTS LIST HEIGHT (controls scroll area) */
  overflow-y: auto; 
  margin-bottom: 1.1rem;
}

.comment-bubble {
  align-self: flex-start;
  background: #fff;
  border-radius: 1.2rem;
  padding: 0.7rem 1.15rem 0.8rem 1.15rem;
  font-size: 1.01rem;
  box-shadow: 0 2px 8px rgba(80, 118, 255, 0.06);
  margin-bottom: 0.2rem;
  min-width: 110px;
}

.comment-bubble .author {
  color: #4b8ef1;
  font-size: 0.96rem;
  font-weight: 600;
  margin-bottom: 0.18rem;
  display: block;
}

.new-post-row, .new-comment-row {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  margin-top: 0.7rem;
}

.new-post-row textarea {
  flex: 1;
  border-radius: 1.2rem;
  border: 1.3px solid #dae4f7;
  font-size: 1.09rem;
  padding: 0.83rem 1.4rem;
  background: #f5fafd;
  min-height: 50px;
  resize: vertical;
}

.new-comment-row input {
  flex: 1;
  border-radius: 1.2rem;
  border: 1.3px solid #dae4f7;
  font-size: 1.09rem;
  padding: 0.83rem 1.4rem;
  background: #f5fafd;
}

.new-post-row button,
.new-comment-row button {
  background: #4b8ef1;
  color: #fff;
  border: none;
  border-radius: 1.1rem;
  font-size: 1.11rem;
  font-weight: 600;
  padding: 0.68rem 2.1rem;
  cursor: pointer;
  box-shadow: 0 2px 10px rgba(80, 118, 255, 0.08);
  transition: background .14s;
}
.new-post-row button:hover,
.new-comment-row button:hover {
  background: #4b8ef1;
}

.empty-message {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #aab1c9;
  font-size: 1.2rem;
  font-weight: 500;
}

@media (max-width: 950px) {
  .forum-chat-wrapper { flex-direction: column; }
  .forum-sidebar { width: 100%; border-right: none; border-bottom: 1.5px solid #e9eef4; }
  .forum-main { padding: 0.5rem 0; }
  .thread-content { padding: 1.3rem 0.2rem 1rem 0.2rem; }
}

  </style>
  