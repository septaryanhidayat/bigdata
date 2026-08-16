import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

// Base URL Backend SmartEdu (Sesuaikan dengan domain / IP server lokal Anda)
export const BASE_API_URL = 'http://127.0.0.1:8000/api/v1/mobile';

const apiClient = axios.create({
  baseURL: BASE_API_URL,
  timeout: 15000,
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
});

// Interceptor untuk menyertakan Auth Token & User ID secara otomatis
apiClient.interceptors.request.use(
  async (config) => {
    try {
      const token = await AsyncStorage.getItem('user_token');
      const userId = await AsyncStorage.getItem('user_id');
      if (token) {
        config.headers.Authorization = `Bearer ${token}`;
      }
      if (userId) {
        config.headers['X-User-Id'] = userId;
      }
    } catch (e) {
      console.error('Error reading auth storage', e);
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default apiClient;
