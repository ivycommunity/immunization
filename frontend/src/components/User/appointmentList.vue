<script setup>
    import gridContainer from './gridContainer.vue';
    import vaccineRecord from './vaccineRecord.vue';
    import spinner from './spinner.vue';
    
    const props = defineProps({
        appointments : Array,
        dataLoading : Boolean,
        hasAppointment : Boolean
    });

</script>

<template>
    <div>
        <spinner :is-loading="dataLoading" />

        <div v-if="hasAppointment">
            <gridContainer>
                <div v-for="item in props.appointments" :key="item.id">
                    <vaccineRecord
                        :date="item.appointment_date"
                        :status="item.status"
                        :baby="item.baby.first_name"
                        :vaccine-type="item.vaccine.vaccine_name" 
                        :doctor="item.doctor.first_name"
                    />
                </div>
            </gridContainer>
        </div>
        <div v-else class="p-4 text-center">
            <p>No appointment details available.</p>
            <p class="mt-2">
                For any enquiry on this matter, please contact 
                <a 
                    href="#" 
                    @click.prevent="navigator.clipboard.writeText('+1234567890')"
                    class="text-blue-500 hover:underline"
                >
                    +1234567890
                </a>
            </p>
        </div>
    </div>
</template>