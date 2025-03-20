<script setup>
    import gridContainer from './gridContainer.vue';
    import vaccineRecord from './vaccineRecord.vue';
    import spinner from './spinner.vue';
    
    const props = defineProps({
        appointments: Array, // Changed from Object to Array
        dataLoading: Boolean,
    });

    console.log("in LIST ", props.appointments);
</script>

<template>
    <div>
        <spinner :is-loading="dataLoading" />
        <gridContainer v-if="!dataLoading">
            <div v-if="props.appointments && props.appointments.length > 0">
                <div v-for="item in props.appointments" :key="item.id">
                    <vaccineRecord 
                        v-if="item.appointment_details && item.baby?.full_name"
                        :date="item.appointment_details.date"
                        :status="item.appointment_details.status"
                        :baby="item.baby.full_name"
                        :vaccine-type="item.vaccine?.name" 
                        :doctor="item.doctor?.contact_number"
                    />
                    <div v-else class="p-4 rounded rounded-lg bg-white">
                        <h3 class="text-[#432C81] text-lg flex justify-between">
                            <span>{{ item.baby?.full_name || 'Unknown Baby' }}</span>
                            <span>-</span>
                            <span>No appointment details available</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div v-else class="p-4 rounded rounded-lg bg-white">
                <h3 class="text-[#432C81] text-lg text-center">No vaccination records found</h3>
            </div>
        </gridContainer>
    </div>
</template>