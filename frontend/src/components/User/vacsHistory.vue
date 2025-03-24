<template>
    <div class="max-w-2xl mx-auto p-4 bg-white shadow rounded-lg">
      <h2 class="text-lg font-semibold text-gray-700 mb-2">Appointments Summary</h2>
      <p v-if="totalAppointments !== undefined" class="text-sm text-gray-600">
        Total Appointments: {{ totalAppointments }}
      </p>
  
      <div v-if="processedStatuses.length > 0">
        <div v-for="status in processedStatuses" :key="status.name" class="mt-4 border rounded-lg">
          <button
            @click="toggleDropdown(status.name)"
            class="w-full text-left px-4 py-2 flex justify-between items-center bg-gray-100 hover:bg-gray-200 rounded-t-lg"
          >
            <span class="font-medium">{{ status.name }} ({{ status.count }})</span>
            <svg
              :class="{'rotate-180': openStatus === status.name}"
              class="w-5 h-5 transform transition-transform"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
  
          <div v-if="openStatus === status.name" class="p-4 bg-white border-t">
            <p v-if="status.appointments.length === 0" class="text-gray-500 text-sm">
              No appointments for this status.
            </p>
  
            <ul v-else class="space-y-2">
              <li
                v-for="appointment in status.appointments"
                :key="appointment.id"
                class="p-2 bg-gray-50 border rounded"
              >
                <div class="flex justify-between items-center mb-1">
                  <p class="text-sm font-medium">
                    {{ formatAppointmentDate(appointment.appointment_date) }}
                  </p>
                  <span class="text-xs px-2 py-1 rounded" 
                        :class="getStatusColor(status.name)">
                    {{ status.name }}
                  </span>
                </div>
                <div class="text-xs text-gray-500 space-y-1">
                  <p>
                    <span class="font-semibold">Doctor:</span> 
                    Doctor ID: {{ appointment.doctor_id }}
                  </p>
                  <p>
                    <span class="font-semibold">Nurse:</span> 
                    Nurse ID: {{ appointment.nurse_id }}
                  </p>
                  <p>
                    <span class="font-semibold">Vaccine:</span> 
                    Vaccine ID: {{ appointment.vaccine_id }}
                  </p>
                  <p v-if="appointment.notes" class="italic">
                    Notes: {{ appointment.notes }}
                  </p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div v-else class="text-gray-500 text-sm">
        No appointment data available.
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  // Define props for the component
  const props = defineProps({
    babyId: {
      type: Number,
      default: null
    },
    totalAppointments: {
      type: Number,
      default: 0
    },
    byStatus: {
      type: Object,
      default: () => ({})
    }
  });
  
  // Order of statuses
  const STATUSES = ['Scheduled', 'Completed', 'Missed', 'Cancelled'];
  
  // Reactive state to track open dropdowns
  const openStatus = ref(null);
  
  // Computed property to process statuses
  const processedStatuses = computed(() => {
    return STATUSES.map(status => ({
      name: status,
      count: props.byStatus?.[status]?.count || 0,
      appointments: props.byStatus?.[status]?.appointments || []
    })).filter(statusGroup => statusGroup.count > 0);
  });
  
  // Function to toggle dropdown
  const toggleDropdown = (status) => {
    openStatus.value = openStatus.value === status ? null : status;
  };
  
  // Format appointment date
  const formatAppointmentDate = (dateString) => {
    if (!dateString) return 'Unknown Date';
    try {
      const date = new Date(dateString);
      return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    } catch (error) {
      return 'Invalid Date';
    }
  };
  
  // Get status-specific color
  const getStatusColor = (status) => {
    const statusColors = {
      'Scheduled': 'bg-blue-100 text-blue-800',
      'Completed': 'bg-green-100 text-green-800',
      'Missed': 'bg-yellow-100 text-yellow-800',
      'Cancelled': 'bg-red-100 text-red-800'
    };
    return statusColors[status] || 'bg-gray-100 text-gray-800';
  };
  </script>