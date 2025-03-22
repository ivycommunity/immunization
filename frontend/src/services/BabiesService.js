import axios from 'axios';
import  useUserStore  from '@/stores/userStore';

export default class BabiesService {
  constructor() {
    this.userStore = useUserStore();
    this.api = axios.create({
      baseURL: '/api',
      withCredentials: true
    });
    
    // Add request interceptor to automatically add auth token
    this.api.interceptors.request.use(config => {
      const token = this.userStore.token;
      if (token) {
        config.headers.Authorization = `Bearer ${token}`;
      }
      return config;
    });
  }
  
  // Get all babies
  async getAllBabies() {
    try {
      const response = await this.api.get('/babies');
      return response.data;
    } catch (error) {
      console.error('Error fetching babies:', error);
      throw error;
    }
  }
  
  // Get a specific baby
  async getBaby(id) {
    try {
      const response = await this.api.get(`/babies/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching baby ${id}:`, error);
      throw error;
    }
  }
  // Get a specific baby
  async getBabyByGuardian(guardian_id) {
    try {
      const response = await this.api.get(`/guardians/${guardian_id}/babies`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching baby ${id}:`, error);
      throw error;
    }
  }
  
  // Create a new baby
  async createBaby(babyData) {
    try {
      const response = await this.api.post('/babies', babyData);
      return response.data;
    } catch (error) {
      console.error('Error creating baby:', error);
      throw error;
    }
  }
  
  // Update a baby
  async updateBaby(id, babyData) {
    try {
      const response = await this.api.put(`/babies/${id}`, babyData);
      return response.data;
    } catch (error) {
      console.error(`Error updating baby ${id}:`, error);
      throw error;
    }
  }
  
  // Delete a baby
  async deleteBaby(id) {
    try {
      const response = await this.api.delete(`/babies/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error deleting baby ${id}:`, error);
      throw error;
    }
  }
}