import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { Platform } from 'react-native';

// Auto-detect base URL:
// Di Web: gunakan http://bigdata.test/api/v1/mobile (Herd)
// Di HP Fisik (Expo Go): gunakan IP LAN Laptop (http://192.168.1.8/api/v1/mobile)
export const BASE_API_URL =
  Platform.OS === 'web'
    ? 'http://bigdata.test/api/v1/mobile'
    : 'http://192.168.1.8/api/v1/mobile';

const apiClient = axios.create({
  baseURL: BASE_API_URL,
  timeout: 8000,
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
      console.warn('Error reading auth storage', e);
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default apiClient;
