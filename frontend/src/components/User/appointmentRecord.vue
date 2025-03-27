<script setup>
import { ref, onMounted } from 'vue';
import {default as cancleButton} from "@/components/User/Button.vue";
import { useAppointmentsStore } from '@/stores/AppointmentStore';

const props = defineProps({
    appointment:{
        type: Object,
        required: true
    }
});

const formattedDate = ref('');

const appointment = ref(props.appointment);

onMounted(() => {
    if (props.appointment.appointment_date) {
        formattedDate.value = formatDate(props.appointment.appointment_date);
    } else {
        formattedDate.value = 'No date provided';
    }
});

const selectedAppointment = ref(null);

const handleShowAppointmentDetails = () => {
    selectedAppointment.value = props.appointment;
};

// Format date as "Month Day, Year" (e.g., "June 15, 2025")
const formatDate = (dateString) => {
  if (!dateString) return '-';
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
};

// Organized sections for looping
const sections = ref([
  {
    title: 'Appointment Details',
    fields: [
      { label: 'Date', value: appointment.value.appointment_date, format: formatDate },
      { label: 'Status', value: appointment.value.status },
    ],
  },
  {
    title: 'Baby Details',
    fields: [
      { label: 'Name', value: appointment.value.baby.first_name },
      { label: 'Gender', value: appointment.value.baby.gender },
      { label: 'Date of Birth', value: appointment.value.baby.date_of_birth, format: formatDate },
      { label: 'Immunization Status', value: appointment.value.baby.immunization_status },
      { label: 'Last Vaccine Received', value: appointment.value.baby.last_vaccine_received },
    ],
  },
  {
    title: 'Doctor',
    fields: [
      { label: 'Name', value: `Dr. ${appointment.value.doctor.first_name} ${appointment.value.doctor.last_name}` },
      { label: 'Phone', value: appointment.value.doctor.phone_number },
      { label: 'Email', value: appointment.value.doctor.email },
      { label: 'Address', value: appointment.value.doctor.address },
    ],
  },
  {
    title: 'Nurse',
    fields: [
      { label: 'Name', value: `${appointment.value.nurse.first_name} ${appointment.value.nurse.last_name}` },
      { label: 'Phone', value: appointment.value.nurse.phone_number },
      { label: 'Email', value: appointment.value.nurse.email },
      { label: 'Address', value: appointment.value.nurse.address },
    ],
  },
  {
    title: 'Vaccine Information',
    fields: [
      { label: 'Vaccine Name', value: appointment.value.vaccine.vaccine_name },
      { label: 'Description', value: appointment.value.vaccine.description },
      { label: 'Disease Prevented', value: appointment.value.vaccine.disease_prevented },
      { label: 'Dosage', value: appointment.value.vaccine.dosage },
      { label: 'Method', value: appointment.value.vaccine.administration_method },
      { label: 'Recommended Age', value: appointment.value.vaccine.recommended_age },
    ],
  },
  {
    title: 'Next Appointment',
    fields: [
      { label: 'Date', value: appointment.value.next_appointment_date, format: formatDate },
      { label: 'Notes', value: appointment.value.notes },
    ],
  },
]);

const isLoading = ref(false);

const handleCancelAppointment = async () => {
    isLoading.value = true;
    try {
        await useAppointmentsStore().cancelAppointment(appointment.value.id);
        console.log(`Appointment ${appointment.value.id} cancelled successfully`);
        appointment.value.status = 'Cancelled';
        selectedAppointment.value = null;
    } catch (error) {
        console.error('Error cancelling appointment:', error);
    }
    finally {
        isLoading.value = false;
    }
};

</script>

<template>
    <div>
        <div 
            class="p-4 rounded-lg bg-white w-full h-full"
            @click="handleShowAppointmentDetails"    
        >
            <!-- Header with baby name, dash, and vaccine type -->
            <div class="text-lg font-bold text-[#432C81]">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="col-span-2 truncate">{{ props.appointment.baby.first_name }}</div>
                    <div class="col-span-1 flex justify-center">-</div>
                    <div class="col-span-2 truncate">
                        {{ props.appointment.vaccine.vaccine_name?.length < 30 ? props.appointment.vaccine.vaccine_name :props.appointment.vaccine.vaccine_name?.substring(0,30).concat('...') }}
                    </div>
                </div>
            </div>
            
            <!-- Footer with doctor and date -->
            <div class="flex justify-between flex-wrap items-center mt-1 text-[#432C81]/80">
                <span>{{ `Doctor: ${props.appointment.doctor.first_name.concat(` ${props.appointment.doctor.last_name}`)}` || 'No doctor specified' }}</span>
                <span>{{ formattedDate }}</span>
            </div>
        </div>

        <div
            v-if="selectedAppointment"
            class="fixed inset-0 bg-[#432C81]/30 flex items-center justify-center p-6"
        >
            <div class="bg-[#F8F8FF] rounded-lg p-8 max-w-2xl w-full relative">
                <button
                    @click="selectedAppointment = null"
                    class="absolute top-4 right-4 text-[#121212] hover:text-[#04A699]"
                >
                    &times;
                </button>

                <div className="max-w-2xl mx-auto p-6 bg-white rounded-lg max-h-96 overflow-y-auto">
                    <div class="p-4 max-w-3xl mx-auto">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Appointment Summary</h2>

                        <!-- Loop through sections -->
                        <div v-for="(section, index) in sections" :key="index" class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">
                            {{ section.title }}
                        </h3>

                        <!-- Loop through fields in each section -->
                        <div 
                            v-for="(field, fieldIndex) in section.fields" 
                            :key="fieldIndex"
                            class="grid grid-cols-12 gap-2 mb-4 items-center"
                        >
                            <div class="col-span-5 text-left">
                                <label class="block text-[#432C81] font-medium">
                                    {{ field.label }}
                                </label>
                            </div>
                            <div class="col-span-1 text-center font-medium">:</div>
                            <div class="col-span-6 text-left">
                                <p>
                                    <!-- Apply formatting if specified (e.g., for dates) -->
                                    {{ field.format ? field.format(field.value) : field.value || '-' }}
                                </p>
                            </div>
                            <div v-if="field.label === 'Status' && field.value==='Scheduled'" class="col-span-12">
                                <cancleButton 
                                    variant="cancel" 
                                    text="Cancel Appointment"
                                    @click="handleCancelAppointment"
                                    :is-loading="isLoading"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
