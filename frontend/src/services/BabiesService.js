import axios from 'axios';
import useUserStore from '@/stores/userStore';
import API from './API';

export default class BabiesService {
  constructor() {
    this.userStore = useUserStore();
    this.api = API;
  }

  async getAllBabies() {
    try {
      const response = await this.api.get('/babies');
      return response.data;
    } catch (error) {
      console.error('Error fetching babies:', error);
      throw error;
    }
  }

  async getBaby(id) {
    try {
      const response = await this.api.get(`/babies/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching baby ${id}:`, error);
      throw error;
    }
  }

  async getBabyByGuardian(guardian_id) {
    try {
      const response = await this.api.get(`/guardians/${guardian_id}/babies`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching baby for guardian ${guardian_id}:`, error);
      throw error;
    }
  }

  async createBaby(babyData) {
    try {
      const response = await this.api.post('/babies', babyData);
      return response.data;
    } catch (error) {
      console.error('Error creating baby:', error);
      throw error;
    }
  }

  async updateBaby(id, babyData) {
    try {
      const response = await this.api.put(`/babies/${id}`, babyData);
      return response.data;
    } catch (error) {
      console.error(`Error updating baby ${id}:`, error);
      throw error;
    }
  }

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