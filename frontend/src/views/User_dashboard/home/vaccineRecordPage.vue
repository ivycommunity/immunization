<script setup>
    import gridContainer from '@/components/User/gridContainer.vue';
    import UserLayout from '@/components/User/userLayout.vue';
    import homeNavButton from '@/components/User/homeNavButton.vue';
    import illustration from '@/assets/userI/Electrocardiogram.png';
    import { ref, onMounted } from 'vue';
    import userStore from '@/stores/userStore';
    import { useAppointmentsStore } from '@/stores/AppointmentStore';
    import appointmentList from '@/components/User/appointmentList.vue';
    import { useRouter } from 'vue-router';
    
    const router = useRouter();
    const isAuthenticated = userStore().isAuthenticated;
    const appointmentStore = useAppointmentsStore();

    const dataLoading = ref(false);
    const appointments = ref([]);

    const allAppointments = async () => {
        dataLoading.value = true;
        try {
            const response = await appointmentStore.fetchAllAppointments();
            console.log("Response type:", typeof response);
            console.log("Response data:", response);
            
            // Extract the actual array from the response.data property
            appointments.value = response.data || [];
            
        } catch (error) {
            console.log(error);
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
        
        <appointmentList :appointments="appointments" :data-loading="dataLoading"/>

    </UserLayout>
</template>