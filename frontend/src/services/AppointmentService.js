import axios from 'axios';
import userStore from '@/stores/userStore';

export default class AppointmentsService {
  constructor() {
    this.userStore = userStore();
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
  
  // Get all appointments
  async getAllAppointments() {
    try {
      const response = await this.api.get('/appointments');
      return response.data;
    } catch (error) {
      throw error;
    }
  }
  
  // Get a specific appointment
  async getAppointment(id) {
    try {
      const response = await this.api.get(`/appointments/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching appointment ${id}:`, error);
      throw error;
    }
  }
  
  // // Create a new appointment
  async createAppointment(appointmentData) {
    try {
      const response = await this.api.post('/appointments', appointmentData);
      return response.data;
    } catch (error) {
      console.error('Error creating appointment:', error);
      throw error;
    }
  }
  
  // Update an appointment
  async updateAppointment(id, appointmentData) {
    try {
      const response = await this.api.put(`/appointments/${id}`, appointmentData);
      return response.data;
    } catch (error) {
      console.error(`Error updating appointment ${id}:`, error);
      throw error;
    }
  }
  
  // Delete an appointment
  async deleteAppointment(id) {
    try {
      const response = await this.api.delete(`/appointments/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error deleting appointment ${id}:`, error);
      throw error;
    }
  }
  
  // Get appointments for a specific baby by filtering all appointments
  async getAppointmentsByBaby(babyId) {
    try {
      const allAppointments = await this.getAllAppointments();
      return allAppointments.filter(appointment => appointment.baby.id === babyId);
    } catch (error) {
      console.error(`Error fetching appointments for baby ${babyId}:`, error);
      throw error;
    }
  }
  
  // // Get appointments for a specific guardian
  async getAppointmentsByGuardian(guardianId) {
    try {
      const response = await this.api.get(`/appointments/guardian/vaccination-history/${guardianId}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching appointments for guardian ${guardianId}:`, error);
      throw error;
    }
  }
  // // Get vacsHistory for a specific baby
  async vaccinationBabyHistory(babyId) {
    try {
      const response = await this.api.get(`/appointments/baby/vaccination-history/${babyId}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching appointments for Baby ${guardianId}:`, error);
      throw error;
    }
  }
  
  // Get appointments for a specific doctor
  async getAppointmentsByDoctor(doctorId) {
    try {
      const allAppointments = await this.getAllAppointments();
      return allAppointments.filter(appointment => appointment.doctor.id === doctorId);
    } catch (error) {
      console.error(`Error fetching appointments for doctor ${doctorId}:`, error);
      throw error;
    }
  }
  
  // Get appointments by date
  async getAppointmentsByDate(date) {
    try {
      const allAppointments = await this.getAllAppointments();
      return allAppointments.filter(appointment => 
        appointment.appointment_details.date === date
      );
    } catch (error) {
      console.error(`Error fetching appointments for date ${date}:`, error);
      throw error;
    }
  }
  
  // Get appointments by status
  async getAppointmentsByStatus(status) {
    try {
      const allAppointments = await this.getAllAppointments();
      return allAppointments.filter(appointment => 
        appointment.appointment_details.status === status
      );
    } catch (error) {
      console.error(`Error fetching appointments with status ${status}:`, error);
      throw error;
    }
  }
}