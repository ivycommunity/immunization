import { defineStore } from 'pinia';
import BabiesService from '@/services/BabiesService';

export const useBabiesStore = defineStore('babies', {
  state: () => ({
    allBabies: [],
    currentBaby: null,
    loading: false,
    error: null
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
    
    // Fetch all babies
    async fetchAllBabies() {
      const babyService = new BabiesService();
      this.setLoading(true);
      this.error = null;
      
      try {
        this.allBabies = await babyService.getAllBabies();
        return this.allBabies;
      } catch (error) {
        this.setError(error.message || 'Failed to fetch babies');
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Fetch a specific baby by ID
    async fetchBaby(id) {
      const babyService = new BabiesService();
      this.setLoading(true);
      this.error = null;
      
      try {
        const baby = await babyService.getBaby(id);
        this.currentBaby = baby;
        
        // Also update this baby in the allBabies array if it exists there
        const index = this.allBabies.findIndex(b => b.id === id);
        if (index !== -1) {
          this.allBabies[index] = baby;
        }
        
        return baby;
      } catch (error) {
        this.setError(error.message || `Failed to fetch baby with ID ${id}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Fetch a specific baby by guardian_ID
    async fetchBabyByGuardian(guardian_ID) {
      const babyService = new BabiesService();
      this.setLoading(true);
      this.error = null;
      
      try {
        const baby = await babyService.getBabyByGuardian(guardian_ID);
        this.currentBaby = baby;
        
        // Also update this baby in the allBabies array if it exists there
        const index = this.allBabies.findIndex(b => b.id === id);
        if (index !== -1) {
          this.allBabies[index] = baby;
        }
        
        return baby;
      } catch (error) {
        this.setError(error.message || `Failed to fetch baby with ID ${id}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Create a new baby
    async createBaby(babyData) {
      const babyService = new BabiesService();
      this.setLoading(true);
      this.error = null;
      
      try {
        const newBaby = await babyService.createBaby(babyData);
        this.allBabies.push(newBaby);
        return newBaby;
      } catch (error) {
        this.setError(error.message || 'Failed to create baby');
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Update a baby
    async updateBaby(id, babyData) {
      const babyService = new BabiesService();
      this.setLoading(true);
      this.error = null;
      
      try {
        const updatedBaby = await babyService.updateBaby(id, babyData);
        
        // Update in allBabies array
        const index = this.allBabies.findIndex(b => b.id === id);
        if (index !== -1) {
          this.allBabies[index] = updatedBaby;
        }
        
        // Update currentBaby if it's the same baby
        if (this.currentBaby && this.currentBaby.id === id) {
          this.currentBaby = updatedBaby;
        }
        
        return updatedBaby;
      } catch (error) {
        this.setError(error.message || `Failed to update baby with ID ${id}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Delete a baby
    async deleteBaby(id) {
      const babyService = new BabiesService();
      this.setLoading(true);
      this.error = null;
      
      try {
        await babyService.deleteBaby(id);
        
        // Remove from allBabies array
        this.allBabies = this.allBabies.filter(baby => baby.id !== id);
        
        // Clear currentBaby if it's the same baby
        if (this.currentBaby && this.currentBaby.id === id) {
          this.currentBaby = null;
        }
        
        return true;
      } catch (error) {
        this.setError(error.message || `Failed to delete baby with ID ${id}`);
        throw error;
      } finally {
        this.setLoading(false);
      }
    },
    
    // Clear current baby
    clearCurrentBaby() {
      this.currentBaby = null;
    }
  },
  
  getters: {
    // Get baby by ID from the store
    getBabyById: (state) => {
      return (id) => state.allBabies.find(baby => baby.id === id);
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
        key: 'babies-store',
        storage: localStorage,
        paths: ['allBabies', 'currentBaby']
      }
    ]
  }
});