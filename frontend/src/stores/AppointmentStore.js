import { defineStore } from 'pinia';
import AppointmentsService from '@/services/AppointmentService';

export const useAppointmentsStore = defineStore('appointments', {
  state: () => ({
    allAppointments: [],
    currentAppointment: null,
    loading: false,
    error: null,
    filters: {
      babyId: null,
      guardianId: null,
      doctorId: null,
      date: null,
      status: null
    }
  }),
  
  actions: {
    // Set loading state
    setLoading(status) {
      this.loading = status;
    },
    
    // Set error
    setError(error) {
      this.error = error;
    },
    
    // Set filters
    setFilter(filterType, value) {
      this.filters[filterType] = value;
    },
    
    // Clear filters
    clearFilters() {
      this.filters = {
        babyId: null,
        guardianId: null,
        doctorId: null,
        date: null,
        status: null
      };
    },
    
    // Fetch all appointments
    async fetchAllAppointments() {
      const appointmentService = new AppointmentsService();
      this.setLoading(true);
      this.error = null;
      
      try {
        this.allAppointments = await appointmentService.getAllAppointments();
        return this.allAppointments;
      } catch (error) {
        this.setError(error.message || 'Failed to fetch appointments');
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Fetch a specific appointment by ID
    async fetchAppointment(id) {
      const appointmentService = new AppointmentsService();
      this.setLoading(true);
      this.error = null;
      
      try {
        const appointment = await appointmentService.getAppointment(id);
        this.currentAppointment = appointment;
        
        // Also update this appointment in the allAppointments array if it exists there
        const index = this.allAppointments.findIndex(a => a.id === id);
        if (index !== -1) {
          this.allAppointments[index] = appointment;
        }
        
        return appointment;
      } catch (error) {
        this.setError(error.message || `Failed to fetch appointment with ID ${id}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Create a new appointment
    async createAppointment(appointmentData) {
      const appointmentService = new AppointmentsService();
      this.setLoading(true);
      this.error = null;
      
      try {
        const newAppointment = await appointmentService.createAppointment(appointmentData);
        this.allAppointments.push(newAppointment);
        return newAppointment;
      } catch (error) {
        this.setError(error.message || 'Failed to create appointment');
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Update an appointment
    async updateAppointment(id, appointmentData) {
      const appointmentService = new AppointmentsService();
      this.setLoading(true);
      this.error = null;
      
      try {
        const updatedAppointment = await appointmentService.updateAppointment(id, appointmentData);
        
        // Update in allAppointments array
        const index = this.allAppointments.findIndex(a => a.id === id);
        if (index !== -1) {
          this.allAppointments[index] = updatedAppointment;
        }
        
        // Update currentAppointment if it's the same appointment
        if (this.currentAppointment && this.currentAppointment.id === id) {
          this.currentAppointment = updatedAppointment;
        }
        
        return updatedAppointment;
      } catch (error) {
        this.setError(error.message || `Failed to update appointment with ID ${id}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Delete an appointment
    async deleteAppointment(id) {
      const appointmentService = new AppointmentsService();
      this.setLoading(true);
      this.error = null;
      
      try {
        await appointmentService.deleteAppointment(id);
        
        // Remove from allAppointments array
        this.allAppointments = this.allAppointments.filter(appointment => appointment.id !== id);
        
        // Clear currentAppointment if it's the same appointment
        if (this.currentAppointment && this.currentAppointment.id === id) {
          this.currentAppointment = null;
        }
        
        return true;
      } catch (error) {
        this.setError(error.message || `Failed to delete appointment with ID ${id}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Fetch appointments by baby ID
    async fetchAppointmentsByBaby(babyId) {
      const appointmentService = new AppointmentsService();
      this.setLoading(true);
      this.error = null;
      this.filters.babyId = babyId;
      
      try {
        const appointments = await appointmentService.getAppointmentsByBaby(babyId);
        // Don't override all appointments, just filter the view
        return appointments;
      } catch (error) {
        this.setError(error.message || `Failed to fetch appointments for baby with ID ${babyId}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Fetch appointments by guardian ID
    async fetchAppointmentsByGuardian(guardianId) {
      const appointmentService = new AppointmentsService();
      this.setLoading(true);
      this.error = null;
      this.filters.guardianId = guardianId;
      
      try {
        const appointments = await appointmentService.getAppointmentsByGuardian(guardianId);
        return appointments;
      } catch (error) {
        this.setError(error.message || `Failed to fetch appointments for guardian with ID ${guardianId}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Fetch appointments by doctor ID
    async fetchAppointmentsByDoctor(doctorId) {
      const appointmentService = new AppointmentsService();
      this.setLoading(true);
      this.error = null;
      this.filters.doctorId = doctorId;
      
      try {
        const appointments = await appointmentService.getAppointmentsByDoctor(doctorId);
        return appointments;
      } catch (error) {
        this.setError(error.message || `Failed to fetch appointments for doctor with ID ${doctorId}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Fetch appointments by date
    async fetchAppointmentsByDate(date) {
      const appointmentService = new AppointmentsService();
      this.setLoading(true);
      this.error = null;
      this.filters.date = date;
      
      try {
        const appointments = await appointmentService.getAppointmentsByDate(date);
        return appointments;
      } catch (error) {
        this.setError(error.message || `Failed to fetch appointments for date ${date}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Fetch appointments by status
    async fetchAppointmentsByStatus(status) {
      const appointmentService = new AppointmentsService();
      this.setLoading(true);
      this.error = null;
      this.filters.status = status;
      
      try {
        const appointments = await appointmentService.getAppointmentsByStatus(status);
        return appointments;
      } catch (error) {
        this.setError(error.message || `Failed to fetch appointments with status ${status}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Clear current appointment
    clearCurrentAppointment() {
      this.currentAppointment = null;
    }
  },
  
  getters: {
    // Get appointment by ID from the store
    getAppointmentById: (state) => {
      return (id) => state.allAppointments.find(appointment => appointment.id === id);
    },
    
    // Get filtered appointments based on the current filters
    filteredAppointments: (state) => {
      let filtered = [...state.allAppointments];
      
      if (state.filters.babyId) {
        filtered = filtered.filter(appt => appt.baby.id === state.filters.babyId);
      }
      
      if (state.filters.guardianId) {
        filtered = filtered.filter(appt => appt.guardian.id === state.filters.guardianId);
      }
      
      if (state.filters.doctorId) {
        filtered = filtered.filter(appt => appt.doctor.id === state.filters.doctorId);
      }
      
      if (state.filters.date) {
        filtered = filtered.filter(appt => appt.appointment_details.date === state.filters.date);
      }
      
      if (state.filters.status) {
        filtered = filtered.filter(appt => appt.appointment_details.status === state.filters.status);
      }
      
      return filtered;
    },
    
    // Get upcoming appointments (those with a future date)
    upcomingAppointments: (state) => {
      const today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
      return state.allAppointments.filter(appt => 
        appt.appointment_details.date >= today &&
        appt.appointment_details.status !== 'canceled' &&
        appt.appointment_details.status !== 'completed'
      );
    },
    
    // Get appointments by status
    appointmentsByStatus: (state) => (status) => {
      return state.allAppointments.filter(appt => 
        appt.appointment_details.status === status
      );
    },
    
    // Get count of appointments by status
    appointmentCounts: (state) => {
      const counts = {
        total: state.allAppointments.length,
        scheduled: 0,
        completed: 0,
        canceled: 0,
        missed: 0
      };
      
      state.allAppointments.forEach(appt => {
        const status = appt.appointment_details.status.toLowerCase();
        if (counts.hasOwnProperty(status)) {
          counts[status]++;
        }
      });
      
      return counts;
    },
    
    // Is loading
    isLoading: (state) => state.loading,
    
    // Has error
    hasError: (state) => !!state.error
  },
  
  persist: {
    enabled: true,
    strategies: [
      {
        key: 'appointments-store',
        storage: localStorage,
        paths: ['allAppointments', 'currentAppointment']
      }
    ]
  }
});