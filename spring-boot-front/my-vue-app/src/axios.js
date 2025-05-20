// src/axios.js
import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost:8084/api',
  withCredentials: true,
});

export default instance;
