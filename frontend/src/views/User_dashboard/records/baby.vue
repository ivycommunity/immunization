<script setup>
    import { ref, onMounted, computed } from 'vue';
    import profileComponent from '@/components/User/profileComponent.vue';    
    import userLayout from '@/components/User/userLayout.vue';
    import { useBabiesStore } from '@/stores/babyStore';
    import userStore from '@/stores/userStore';
    import { useRoute, useRouter } from 'vue-router';
    import { 
        UserCircleIcon, 
        CalendarDaysIcon, 
        ClipboardDocumentCheckIcon
    } from '@heroicons/vue/24/outline'
    import { useAppointmentsStore } from '@/stores/AppointmentStore';
    import vacsHistory from '@/components/User/vacsHistory.vue';
    import spinner from '@/components/User/spinner.vue';

    import vacsHistoryCopy from '@/components/User/vacsHistory-copy.vue';

    const babiesStore = useBabiesStore();
    const appointmentStore = useAppointmentsStore();
    const useStore = userStore();
    const currentBaby = ref({});
    const VaccinationHistory = ref({});
    const dataLoading = ref(true);

    const route = useRoute();
    const router = useRouter();
    const babyId = route.params.id;
    const user = userStore();
    const isAuthenticated = computed(() => user.isAuthenticated);
    const currentUserID = computed(() => user.getUserID);

    const getBaby = async () => {
        try{
            const response = await babiesStore.fetchBaby(babyId);
            currentBaby.value = response;
        } catch (error) {
            console.error("Error fetching babies:", error);
        }
    }
    const getVaccinationHistory = async () => {
        try{
            // const response = await appointmentStore.fetchVaccinationHistoryByBaby(babyId);
            const response = await appointmentStore.fetchAllAppointments();
            // VaccinationHistory.value = response.data;
            console.log("currentUserID.value", currentUserID.value);
            console.log("babyID.value", babyId);
            VaccinationHistory.value = response.data.filter(appointment => {
                // return appointment.baby_id === babyId;
                return String(appointment.baby_id) === String(babyId);
            });
            console.log("V H response",response.data); //shows all appointments
            console.log("V H ref",VaccinationHistory.value); //shows filtered appointments but I am getting 0
        } catch (error) {
            console.error("Error vaccination History:", error);
        }
        finally{
            dataLoading.value = false;
        }
    }

    onMounted(() => {
        if(!useStore.isAuthenticated) {
            router.push({name: "userLogin"});
        } else {
            getBaby();
            getVaccinationHistory();
        }
    });
    
    // State for dropdowns
    const accountOpen = ref(false);
    const vaccinationOpen = ref(false);
    
    // Toggle functions
    const toggleAccount = () => {
        accountOpen.value = !accountOpen.value;
    };
    
    const toggleVaccination = () => {
        vaccinationOpen.value = !vaccinationOpen.value;
    };

    const filteredBabyData = computed(() => {
        const filtered = {};
        for (const [key, value] of Object.entries(currentBaby.value)) {
            if (!['id', 'created_at', 'updated_at'].includes(key)) {
                filtered[key] = value;
            }
            
            if (['next_appointment_date', 'date_of_birth'].includes(key)) {
                const date = new Date(value);
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                filtered[key] = date.toLocaleDateString(undefined, options);
            }

        }
        return filtered;
    });

    const childTitle = computed(() => {
        return useStore.no_of_children > 1 ? "Children" : "Child";
    });

    console.log("childtitle in baby : ",childTitle);

</script>

<template>

    <userLayout
        :topBartitle="'My '.concat(childTitle)"
        topBarMove="false"
        back-to="/user/records/babies"
    >
        <!-- Add a container for the spinner with proper positioning -->
        <div v-if="dataLoading" class="flex justify-center items-center py-8">
            <spinner :is-loading="dataLoading" variant="secondary" />
        </div>
    <div v-else>
        <profileComponent 
            :user-full-name = "currentBaby.first_name || 'Baby'" 
        />

        <div class="container mx-auto p-4">
        <!-- Account dropdown -->
        <div class="mb-4">
            <button 
            @click="toggleAccount" 
            class="flex items-center justify-between w-full text-left text-purple-800 font-medium text-2xl p-3 hover:bg-gray-50 focus:outline-none"
            >
            <div class="flex items-center gap-2">
                <UserCircleIcon class="w-6 h-6 mr-2" />
                <p>Account</p>
            </div>
            <svg 
                :class="{'transform rotate-180': accountOpen}" 
                class="w-6 h-6 transition-transform duration-200" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            </button>
            
            <div 
            v-show="accountOpen" 
            class="mt-2 p-4 bg-white border border-gray-200 rounded shadow-sm transition-all duration-300"
            >
            <!-- Account content goes here -->
                <div v-for="(value, key) in filteredBabyData" :key="key" class="grid grid-cols-12 gap-2 mb-4 items-center">
                    <div class="col-span-5 text-left">
                        <label :for="key" class="block text-[#432C81] font-medium">
                            {{ key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                        </label>
                    </div>
                    <div class="col-span-1 text-center font-medium text-gray-900/90">:</div>
                    <div class="col-span-6 text-left text-gray-900/90">
                        <p>{{ value }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Vaccination History dropdown -->
        <div class="mb-4">
            <button 
            @click="toggleVaccination" 
            class="flex items-center justify-between w-full text-left text-purple-800 font-medium text-2xl p-3 hover:bg-gray-50 focus:outline-none"
            >
            <div class="flex items-center gap-2">
                <ClipboardDocumentCheckIcon class="w-6 h-6 mr-2" />
                <p>Vaccination History</p>
            </div>
            <svg 
                :class="{'transform rotate-180': vaccinationOpen}" 
                class="w-6 h-6 transition-transform duration-200" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            </button>
            
            <div 
            v-show="vaccinationOpen" 
            class="mt-2 p-4 bg-white border border-gray-200 rounded shadow-sm transition-all duration-300"
            >
                <!-- <vacsHistory :baby-id="VaccinationHistory.babyId" :total-appointments="VaccinationHistory.total_appointments" :by-status="VaccinationHistory.by_status" /> -->
                <vacsHistoryCopy
                    :appointments="VaccinationHistory"
                    :total-appointments="VaccinationHistory.total_appointments" 
                />
            </div>
        </div>
        </div>
    </div>
</userLayout>
</template>