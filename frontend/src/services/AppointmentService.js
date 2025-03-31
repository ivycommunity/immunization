import axios from 'axios';
import userStore from '@/stores/userStore';
import API from './API';

export default class AppointmentsService {
  constructor() {
    this.userStore = userStore();
    this.api = API;
  }

  async getAllAppointments() {
    try {
      const response = await this.api.get('/appointments');
      return response.data;
    } catch (error) {
      throw error;
    }
  }

  async getAppointment(id) {
    try {
      const response = await this.api.get(`/appointments/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching appointment ${id}:`, error);
      throw error;
    }
  }

  async createAppointment(appointmentData) {
    try {
      const response = await this.api.post('/appointments', appointmentData);
      return response.data;
    } catch (error) {
      console.error('Error creating appointment:', error);
      throw error;
    }
  }

  async updateAppointment(id, appointmentData) {
    console.log('updateAppointment in service', id, appointmentData);
    try {
      const response = await this.api.put(`/appointments/${id}`, appointmentData);
      return {
        response : response.data, 
        updatedAppointment: appointmentData
      };
    } catch (error) {
      console.error(`Error updating appointment ${id}:`, error);
      throw error;
    }
  }

  async deleteAppointment(id) { //not being used
    try {
      const response = await this.api.delete(`/appointments/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error deleting appointment ${id}:`, error);
      throw error;
    }
  }

  async getAppointmentsByBaby(babyId) { //not being used
    try {
      const response = await this.api.get(`/appointments?babyId=${babyId}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching appointments for baby ${babyId}:`, error);
      throw error;
    }
  }

  async getAppointmentsByGuardian(guardianId) {
    try {
      const response = await this.api.get(`/appointments/guardian/vaccination-history/${guardianId}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching appointments for guardian ${guardianId}:`, error);
      throw error;
    }
  }

  async vaccinationBabyHistory(babyId) {
    try {
      const response = await this.api.get(`/appointments/baby/vaccination-history/${babyId}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching appointments for Baby ${babyId}:`, error);
      throw error;
    }
  }

  async getAppointmentsByDoctor(doctorId) {
    try {
      const response = await this.api.get(`/appointments?doctorId=${doctorId}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching appointments for doctor ${doctorId}:`, error);
      throw error;
    }
  }

  async getAppointmentsByDate(date) {
    try {
      const response = await this.api.get(`/appointments?date=${date}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching appointments for date ${date}:`, error);
      throw error;
    }
  }

  async getAppointmentsByStatus(status) {
    try {
      const response = await this.api.get(`/appointments?status=${status}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching appointments with status ${status}:`, error);
      throw error;
    }
  }
}
