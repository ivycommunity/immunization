import { defineStore } from 'pinia';
import AppointmentsService from '@/services/AppointmentService';

export const useAppointmentsStore = defineStore('appointments', {
  state: () => ({
    allAppointments: null, // Change from empty array to null
    currentAppointment: null,
    filters: {
      babyId: null,
      guardianId: null,
      doctorId: null,
      date: null,
      status: null
    }
  }),
  
  actions: {
    async updateAppointment(id, updateData) {
      const service = new AppointmentsService();
      
      console.log("currentAppointment", this.currentAppointment); 
      
      const originalAppointment = this.allAppointments.data.find(a => a.id === id);
      
      if (!originalAppointment) {
        throw new Error(`Appointment with id ${id} not found`);
      }
      
      console.log("Original Appointment", originalAppointment);
      
      console.log("Update Data", updateData);
      
      // console.log("All Appointments Before Update", this.allAppointments);
      try {
        if (originalAppointment) {
          
          const optimisticUpdate = { ...originalAppointment, ...updateData };
          
          this.allAppointments.data = this.allAppointments.data.map(a => 
            a.id === id ? optimisticUpdate : a
          );
          
          if (this.currentAppointment?.id === id) {
            this.currentAppointment = optimisticUpdate;
          }
        }

        // Actual API call
        const { updatedAppointment } = await service.updateAppointment(id, updateData);
        console.log("Updated Appointment", updateData);
        
        // Confirm update with actual data
        // this.allAppointments = this.allAppointments.data.map(a => 
        //   a.id === id ? updatedAppointment : a
        // );

        this.allAppointments = {
          ...this.allAppointments,
          data: this.allAppointments.data.map(a => 
            a.id === id ? updatedAppointment : a
          )
        };
        
        if (this.currentAppointment?.id === id) {
          this.currentAppointment = updatedAppointment;
        }
        
        return updatedAppointment;
      } catch (error) {
        // Revert optimistic update on error
        if (originalAppointment) {
          this.allAppointments = this.allAppointments.data.map(a => 
            a.id === id ? originalAppointment : a
          );
          
          if (this.currentAppointment?.id === id) {
            this.currentAppointment = originalAppointment;
          }
        }
        console.log("Error in updateAppointment", error);
        throw error;
      }finally{
        console.log("All Appointments After Update", this.allAppointments);
        this.currentAppointment = null;
      }
    },

    async cancelAppointment(id) {
      
      // Check if allAppointments and data exist
      if (!this.allAppointments || !this.allAppointments.data) {
        console.error('No appointments data available');
        throw new Error('No appointments data available');
      }

      // Find the appointment by id
      const appointmentToCancel = this.allAppointments.data.find(a => a.id === id);

      if (!appointmentToCancel) {
        console.error(`Appointment with id ${id} not found`);
        throw new Error(`Appointment with id ${id} not found`);
      }

      // Set current appointment
      this.currentAppointment = appointmentToCancel;

      try {
        // Create a copy of the appointment to modify
        const cancelData = { ...appointmentToCancel };
        cancelData.status = 'Cancelled';
        
        // Create MySQL-formatted timestamp
        const mysqlFormat = new Date().toISOString()
                                      .replace('T', ' ')
                                      .replace(/\..+/, '');
        cancelData.updated_at = mysqlFormat;
        
        console.log("Cancel Data", cancelData);

        return await this.updateAppointment(id, cancelData);
      } catch (error) {
        console.log("Error in cancelAppointment", error);
        throw error;
      } finally {
        // Reset current appointment
        this.currentAppointment = null;
      }
    },

    async fetchAllAppointments() {
      const service = new AppointmentsService();
      
      try {
        this.allAppointments = await service.getAllAppointments();
        console.log("All appointment After fetching them all",this.allAppointments);
        return this.allAppointments;
      } catch (error) {
        console.log("Error in updateAppointment", error);
        throw error;
      }
    },

    async fetchAppointmentsByBaby(babyId) {
      const appointmentService = new AppointmentsService();
      try {
        const appointments = await appointmentService.getAppointmentsByBaby(babyId);
        return appointments;
      } catch (error) {
        console.error(error);
        throw error;
      }
    },
    // Fetch Vaccination History by baby ID
    async fetchVaccinationHistoryByBaby(babyId) {
      const appointmentService = new AppointmentsService();
      try {
        const appointments = await appointmentService.vaccinationBabyHistory(babyId);
        return appointments;
      } catch (error) {
        console.error(error);
        throw error;
      }
    },

    // Fetch appointments by guardian ID
    async fetchAppointmentsByGuardian(guardianId) {
      const appointmentService = new AppointmentsService();
      this.filters.guardianId = guardianId;

      try {
        const appointments = await appointmentService.getAppointmentsByGuardian(guardianId);
        return appointments;
      } catch (error) {
        console.error(error);
        throw error;
      }
    },


  },
  
  getters: {
    // Enhanced getters with memoization
    filteredAppointments: (state) => {
      const { babyId, guardianId, doctorId, date, status } = state.filters;
      return state.allAppointments.filter(appt => {
        return (
          (!babyId || appt.baby?.id === babyId) &&
          (!guardianId || appt.guardian?.id === guardianId) &&
          (!doctorId || appt.doctor?.id === doctorId) &&
          (!date || appt.appointment_details?.date === date) &&
          (!status || appt.appointment_details?.status === status)
        );
      });
    },

    getAllAppointments: (state) => {
      return state.allAppointments ? state.allAppointments.data : null;
    },
    getCurrentAppointment: (state) => {
      return state.currentAppointment;
    },


    // ... other getters remain similar
  },
  
  persist: {
    enabled: true,
    strategies: [
      {
        key: 'appointments-store',
        storage: localStorage,
        paths: ['allAppointments', 'currentAppointment', 'lastUpdated']
      }
    ]
  }
});