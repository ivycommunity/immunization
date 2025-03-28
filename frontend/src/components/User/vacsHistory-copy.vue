<script setup>
import appointmentList from './appointmentList.vue';
import { ref, computed, onMounted } from 'vue';

const baby_appointments = ref([]);

// Define props for the component
const props = defineProps({
  appointments: {
    type: Array,
    required: true
  },
  totalAppointments: {
    type: Number,
    default: 0
  },
});

    const hasAppointments = computed(() => {
        return Array.isArray(baby_appointments.value) && baby_appointments.value.length > 0;
    });

    onMounted(() => {
        baby_appointments.value = props.appointments;
    });
    
</script>

<template>
    <div class="max-w-2xl mx-auto p-4 bg-white shadow rounded-lg">
      <h2 class="text-lg font-semibold text-gray-700 mb-2">Appointments Summary</h2>
      <p class="text-sm text-gray-600">
        Total Appointments: {{ baby_appointments.length }}
      </p>
      
      <appointmentList
        v-if="hasAppointments"
        :appointments="baby_appointments"
      />
      <div v-else class="text-gray-500 text-sm">
        No appointment data available.
      </div>
    </div>
</template>
  