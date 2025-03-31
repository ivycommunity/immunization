<template>
    <div>
        <h1>Test Component</h1>
        <button @click="handleClick">Run Function</button>
    </div>
</template>

<script setup>
    import AppointmentsService from '@/services/AppointmentService';
    
    const appointmentsService = new AppointmentsService();

    const handleClick = async () => {
        console.log('Button clicked!');
        console.log("----------all appointments----------");
        const resp = await appointmentsService.getAllAppointments();
        console.log(resp);
        console.log("----------all appointments by guardian----------");
        const rep = await appointmentsService.getAppointmentsByGuardian(2);
        console.log(rep);
    };
</script>

<style scoped>
button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>