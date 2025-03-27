import { defineStore } from 'pinia';
import VaccinesService from '@/services/VaccinesService';

export const useVaccineStore = defineStore('vaccines', {
    state: () => ({
        allVaccines: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchAllVaccines() {
            this.loading = true;
            this.error = null;
            try {
                const vaccineService = new VaccinesService();
                const vaccines = await vaccineService.getAllVaccines();
                this.allVaccines = vaccines;
                return vaccines;
            } catch (error) {
                this.error = 'Failed to fetch vaccines';
                console.error('Error fetching all vaccines:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchVaccineById(vaccine_id) {
            this.loading = true;
            this.error = null;
            try {
                // Check if the vaccine already exists in state
                const existingVaccine = this.allVaccines.find(v => v.id === vaccine_id);
                if (existingVaccine) return existingVaccine;

                const vaccineService = new VaccinesService();
                return await vaccineService.getVaccineById(vaccine_id);
            } catch (error) {
                this.error = `Failed to fetch vaccine with ID ${vaccine_id}`;
                console.error(`Error fetching vaccine ${vaccine_id}:`, error);
                throw error;
            } finally {
                this.loading = false;
            }
        }
    },

    getters: {
        getVaccineById: (state) => (vaccine_id) => {
            return state.allVaccines.find(vaccine => vaccine.id === vaccine_id);
        },
        isLoading: (state) => state.loading,
        hasError: (state) => !!state.error
    },

    persist: {
        enabled: true,
        strategies: [
            {
                key: 'vaccines-store',
                storage: localStorage,
                paths: ['allVaccines']
            }
        ]
    }
});