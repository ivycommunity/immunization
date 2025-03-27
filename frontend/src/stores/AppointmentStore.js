import { defineStore } from 'pinia';
import AppointmentsService from '@/services/AppointmentService';

export const useAppointmentsStore = defineStore('appointments', {
  state: () => ({
    allAppointments: [],
    currentAppointment: {},
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
      
      this.currentAppointment = this.allAppointments.data.filter(a => a.id === id);
      
      console.log("currentAppointment", this.currentAppointment); 
      
      const originalAppointment = this.allAppointments.data.find(a => a.id === id);
      
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
        const updatedAppointment = await service.updateAppointment(id, updateData);
        console.log("Updated Appointment", updateData);
        
        // Confirm update with actual data
        this.allAppointments = this.allAppointments.data.map(a => 
          a.id === id ? updatedAppointment : a
        );
        
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
      this.currentAppointment = this.allAppointments.data.filter(a => a.id === id);
      try {
        // const cancelData = { 
        //   ...this.currentAppointment,
        //   this.currentAppointment:
        //   {
        //     status = 'canceled',
        //     updated_at = new Date().toISOString(),

        const cancelData = this.currentAppointment[0];
        cancelData.status = 'Cancelled';
        const mysqlFormat = new Date().toISOString()
                                      .replace('T', ' ')
                                      .replace(/\..+/, '');
        
        console.log("Cancel Data", cancelData);

        return await this.updateAppointment(id, cancelData);
      } catch (error) {
        console.log("Error in updateAppointment", error);
        throw error;
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