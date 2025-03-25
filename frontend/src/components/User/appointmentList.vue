<script setup>
import { ref, computed } from 'vue';
import gridContainer from './gridContainer.vue';
import appointmentRecord from './appointmentRecord.vue';
import spinner from './spinner.vue';

const props = defineProps({
    appointments: Array,
    dataLoading: Boolean,
    hasAppointment: Boolean
});

// Holds the selected status from the child
const status = ref('Scheduled');

// Computed property to filter appointments based on the selected status
const filteredAppointments = computed(() => {
    return props.appointments.filter(appointment => 
        appointment.status?.toLowerCase() === status.value.toLowerCase()
    );
});

// Method to update status when child emits an event
const updateStatus = (newStatus) => {
    status.value = newStatus;
};

</script>

<template>
    <div class="w-full mx-auto p-4">
        <div v-if="hasAppointment">
            <gridContainer @updateStatus="updateStatus">
                <!-- Show message if there are no appointments matching the filter -->
                <div v-if="filteredAppointments.length === 0" class="text-center py-4 text-gray-500">
                    No appointments found for "{{ status }}"
                </div>

                <div v-else v-for="item in filteredAppointments" :key="item.id">
                    <appointmentRecord
                        :appointment="item"
                    />
                </div>
            </gridContainer>
        </div>
        
        <!-- No appointment details available -->
        <div v-if="!hasAppointment && !dataLoading" class="p-4 text-center">
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

        <!-- Loading spinner -->
        <div v-if="dataLoading" class="flex justify-center items-center py-8">
            <spinner :is-loading="dataLoading" variant="secondary" />
        </div>
    </div>
</template>