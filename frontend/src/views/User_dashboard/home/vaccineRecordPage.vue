<script setup>
    import UserLayout from '@/components/User/userLayout.vue';
    import homeNavButton from '@/components/User/homeNavButton.vue';
    import illustration from '@/assets/userI/Electrocardiogram.png';
    import { ref, onMounted, computed} from 'vue';
    import userStore from '@/stores/userStore';
    import { useAppointmentsStore } from '@/stores/AppointmentStore';
    import { useRouter } from 'vue-router';
    import appointmentList from '@/components/User/appointmentList.vue';
    
    const router = useRouter();
    const isAuthenticated = userStore().isAuthenticated;
    const appointmentStore = useAppointmentsStore();

    const dataLoading = ref(true);
    const appointments = ref([]);

    const hasAppointments = computed(() => {
        return Array.isArray(appointments.value) && appointments.value.length > 0;
    });

    const allAppointments = async () => {
        dataLoading.value = true;
        try {
            const currentUserID = userStore().getUserID;
            const response = await appointmentStore.fetchAllAppointments();
            const appointments_for_current_user = response.data.filter(appointment => appointment.guardian_id === currentUserID);
            //filter this data to get only the appointments of the current user

            appointments.value = appointments_for_current_user.data;
            
        } catch (error) {
            console.error("Error fetching appointments:", error);
            appointments.value = [];
        } finally {
            dataLoading.value = false;
        }
    }

    onMounted(() => {
        if(!isAuthenticated) {
            router.push({name: "userLogin"});
        } else {
            allAppointments();
        }
    });

    const TITLE = 'Vaccination Records';
</script>

<template>
    <UserLayout 
        back-to="/user/home"
        :topBartitle="TITLE"
    >
        <homeNavButton :title="TITLE" :illustration-icon="illustration"/>
        <appointmentList 
            :appointments="appointments" 
            :data-loading="dataLoading" 
            :has-appointment="hasAppointments"
        />
        
    </UserLayout>
</template>