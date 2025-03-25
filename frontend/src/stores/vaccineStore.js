import { defineStore } from 'pinia';
import { useVaccineService } from '@/services/vaccineService';

export const useVaccineStore = defineStore('vaccines', {
    state: () => ({
        allVaccines: [],
    }),
    actions: {
        async fetchAllVaccines() {
            try {
                const vaccineService = useVaccineService();
                this.allVaccines = await vaccineService.getAllVaccines();
            } catch (error) {
                console.error('Error fetching all vaccines:', error);
                throw error;
            }
        },
        async fetchVaccineById(vaccine_id) {
            try {
                const vaccineService = useVaccineService();
                return await vaccineService.getVaccineById(vaccine_id);
            } catch (error) {
                console.error(`Error fetching vaccine ${vaccine_id}:`, error);
                throw error;
            }
        }
    },
    getters: {
        getVaccineById: (state) => (vaccine_id) => {
            return state.allVaccines.find(vaccine => vaccine.id === vaccine_id);
        }
    }
});
