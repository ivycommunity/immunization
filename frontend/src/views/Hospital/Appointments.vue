<script setup>
import Sidebar from '@/components/Hospital/Sidebar.vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

const activeTab = ref('list')

// Reactive data for backend-fetched content
const appointments = ref([])
const patients = ref([])
const parents = ref([])
const vaccines = ref([])
const doctors = ref([])

// Reactive state for edit modal
const isEditModalOpen = ref(false)
const editAppointment = ref({
  id: null,
  appointment_date: "",
  next_appointment_date: "",
  vaccine_id: null,
  doctor_id: null,
  status: ""
})

// Fetch appointments from the API
const fetchAppointments = async () => {
  try {
    const token = localStorage.getItem("token")
    const response = await axios.get('/api/appointments', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    appointments.value = response.data.data
  } catch (error) {
    console.error('Error fetching appointments:', error)
  }
}

// Fetch doctors from the API
const fetchDoctors = async () => {
  try {
    const token = localStorage.getItem("token")
    const response = await axios.get('/api/doctors', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    doctors.value = response.data.data || []
  } catch (error) {
    console.error('Error fetching doctors:', error)
  }
}

// Fetch patients from the API
const fetchPatients = async () => {
  try {
    const token = localStorage.getItem("token")
    const response = await axios.get('/api/babies', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    patients.value = response.data.babies || []
  } catch (error) {
    console.error('Error fetching patients:', error)
  }
}

// Fetch parents from the API
const fetchParents = async () => {
  try {
    const token = localStorage.getItem("token")
    const response = await axios.get('/api/guardians', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    parents.value = response.data.guardians || []
  } catch (error) {
    console.error('Error fetching parents:', error)
  }
}

// Fetch vaccines from the API
const fetchVaccines = async () => {
  try {
    const token = localStorage.getItem("token")
    const response = await axios.get('/api/vaccines', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    vaccines.value = response.data.vaccines || []
  } catch (error) {
    console.error('Error fetching vaccines:', error)
  }
}

// Load all required data on component mount
onMounted(async () => {
  await Promise.all([
    fetchAppointments(),
    fetchPatients(),
    fetchParents(),
    fetchDoctors(),
    fetchVaccines()
  ])
})

console.log("APP", appointments)
console.log("patients", patients)
console.log("parents", parents)
console.log("vaccines", vaccines)
console.log("doctors", doctors)

// Format a date string into a human-readable format
const formatDate = (dateString) => {
  const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  }
  return new Date(dateString).toLocaleString(undefined, options)
}

// Determine status classes for styling list view
const getStatusClass = (status) => {
  switch (status.toLowerCase()) {
    case 'scheduled':
      return 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800'
    case 'completed':
      return 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800'
    case 'cancelled':
      return 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800'
    default:
      return 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800'
  }
}

// Get event background colors for the calendar
const getEventColor = (status) => {
  switch (status.toLowerCase()) {
    case 'scheduled':
      return '#10B981' // green
    case 'completed':
      return '#3B82F6' // blue
    case 'cancelled':
      return '#EF4444' // red
    default:
      return '#6B7280' // gray
  }
}

// Setup calendar options using appointments data
const calendarOptions = computed(() => ({
  plugins: [dayGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',
  events: appointments.value.map(appointment => ({
    title: `${appointment.baby.first_name} with nurse ${appointment.nurse.first_name} ${appointment.nurse.last_name}`,
    start: appointment.appointment_date,
    allDay: false,
    backgroundColor: getEventColor(appointment.status)
  })),
  eventClick: (info) => {
    alert(`Appointment: ${info.event.title} on ${info.event.start}`)
    // Add detailed view or editing functionality as needed
  }
}))

// Modal logic for adding a new appointment
const isModalOpen = ref(false)
const newAppointment = ref({
  baby_id: "",        // Should be an ID, not a name
  guardian_id: "",    // Should be an ID, not a name
  vaccine_id: "",     // Should be an ID, not a name
  doctor_id: null,    // Ensure it's null, not "null"
  appointment_date: "",
  status: "Scheduled",
  reminder_sent: 0,
  notes: "Empty",
});

// Close edit modal
const closeEditModal = () => {
  isEditModalOpen.value = false
  editAppointment.value = {
    id: null,
    appointment_date: "",
    doctor_id: null,
    status: ""
  }
}

const addAppointment = async () => {
  try {
    const token = localStorage.getItem("token")

    if (!token) {
      alert("Authentication failed. Please log in again.");
      return;
    }

    const response = await axios.post(
      "/api/appointments",
      newAppointment.value,
      {
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
        }
      }
    )
    window.location.reload()
    closeModal()
    alert("Appointment added successfully!")
  } catch (error) {
    console.error("Error adding appointment:", error)
    if (error.response) {
      if (error.response.status === 401) {
        alert("Unauthorized: Your session might have expired. Please log in again.")
      } else if (error.response.status === 422) {
        alert("Validation error: " + JSON.stringify(error.response.data.errors))
      }
    } else {
      alert("An error occurred. Check the console for details.")
    }
  }
}

const closeModal = () => {
  isModalOpen.value = false
  // Reset new appointment form if needed
  newAppointment.value = {
    baby_id: "",
    guardian_id: "",
    vaccine_id: "",
    doctor_id: null,
    appointment_date: "",
    status: "Scheduled",
    reminder_sent: 0,
    notes: "Empty",
  }
}


// Open the edit modal and populate the editAppointment ref with the selected appointment's data
const openEditModal = (appointment) => {
  editAppointment.value = {
    id: appointment.id,
    appointment_date: appointment.appointment_date,
    next_appointment_date: appointment.next_appointment_date,
    doctor_id: appointment.doctor ? appointment.doctor.id : null,
    status: appointment.status
  }
  isEditModalOpen.value = true
}

const saveEditAppointment = async () => {
  try {
    const token = localStorage.getItem("token");
    if (!token) {
      alert("Authentication failed: No token found. Please log in again.");
      return;
    }

    // Get the current appointment to access its baby_id and vaccine info
    const currentAppointment = appointments.value.find(a => a.id === editAppointment.value.id);
    if (!currentAppointment) {
      alert("Appointment not found.");
      return;
    }

    // Update appointment
    const response = await axios.put(
      `/api/appointments/${editAppointment.value.id}`,
      {
        appointment_date: editAppointment.value.appointment_date,
        doctor_id: editAppointment.value.doctor_id,
        status: editAppointment.value.status
      },
      {
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
        }
      }
    );

    // Update the appointment in the local array with proper merging
    const index = appointments.value.findIndex(a => a.id === editAppointment.value.id);
    if (index !== -1) {
      appointments.value[index] = {
        ...appointments.value[index],
        ...response.data.appointment
      };
    }

    // Check if the appointment is completed before updating the baby record
    if (editAppointment.value.status === "Completed") {
      const babyId = currentAppointment.baby?.id;
      const guardianId = currentAppointment.guardian?.id;

      if (!babyId) {
        alert("Baby ID not found. Unable to update baby record.");
        return;
      }

      // Get the vaccine information
      const vaccineInfo = currentAppointment.vaccine?.vaccine_name;

      // Update the baby record
      await axios.put(
        `/api/babies/${babyId}`,
        {
          doctor_id: editAppointment.value.doctor_id,
          last_vaccine_received: vaccineInfo,
          next_appointment_date: editAppointment.value.next_appointment_date,
          immunization_status: 'Up to date'
        },
        {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          }
        }
      );

      // Create a new appointment for the next vaccination
      if (editAppointment.value.next_appointment_date) {
        const newAppointmentData = {
          baby_id: babyId,
          guardian_id: guardianId,
          vaccine_id: editAppointment.value.vaccine_id,
          doctor_id: editAppointment.value.doctor_id,
          appointment_date: editAppointment.value.next_appointment_date,
          status: "Scheduled",
          reminder_sent: 0,
          notes: "Empty",
        };

        console.log("Creating new appointment:", newAppointmentData); // Fixed console.log call

        // Create the new appointment
        const newAppointmentResponse = await axios.post(
          "/api/appointments",
          newAppointmentData,
          {
            headers: {
              Authorization: `Bearer ${token}`,
              "Content-Type": "application/json",
            }
          }
        );

        // Add the new appointment to the local array
        if (newAppointmentResponse.data.appointment) {
          appointments.value.push(newAppointmentResponse.data.appointment);
        }
      }
    }

    // Close the modal
    closeEditModal();

    // Fetch fresh data instead of just modifying local state
    await fetchAppointments();

    alert("Appointment updated successfully!");
  } catch (error) {
    console.error("Error updating appointment or baby record:", error);
    if (error.response) {
      if (error.response.status === 401) {
        alert("Unauthorized: Your session might have expired. Please log in again.");
      } else if (error.response.status === 422) {
        alert("Validation error: " + JSON.stringify(error.response.data.errors));
      } else {
        alert(`API Error (${error.response.status}): ${error.response.data.message || "Unknown error"}`);
      }
    } else {
      alert("An error occurred. Check the console for details.");
    }
  }
};


// Delete an appointment
const deleteAppointment = async (appointmentId) => {
  try {
    const token = localStorage.getItem("token")
    if (!token) {
      alert("Authentication failed: No token found. Please log in again.")
      return
    }
    await axios.delete(`/api/appointments/${appointmentId}`, {
      headers: { Authorization: `Bearer ${token}` }
    })
    // Remove appointment from local array
    appointments.value = appointments.value.filter(a => a.id !== appointmentId)
    alert("Appointment deleted successfully!")
  } catch (error) {
    console.error("Error deleting appointment:", error)
    alert("Failed to delete the appointment. Please try again.")
  }
}
</script>

<template>
  <Sidebar title="Appointments">
    <div class="min-h-screen bg-blue-50 p-6">
      <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
          <!-- Tabs -->
          <div>
            <button @click="activeTab = 'list'"
              :class="['px-4 py-2 rounded-t-lg', activeTab === 'list' ? 'bg-white text-blue-600' : 'cursor-pointer bg-gray-200 text-gray-600']">
              List View
            </button>
            <button @click="activeTab = 'calendar'"
              :class="['px-4 py-2 rounded-t-lg', activeTab === 'calendar' ? 'bg-white text-blue-600' : 'cursor-pointer bg-gray-200 text-gray-600']">
              Calendar View
            </button>
          </div>
          <div>
            <button @click="isModalOpen = true"
              class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              Add Appointment
            </button>
          </div>
        </div>

        <!-- List View -->
        <div v-if="activeTab === 'list'" class="bg-white rounded-lg shadow-sm p-6">
          <table class="min-w-full text-xs">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Parent Name
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Patient Name
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Nurse on Duty
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Vaccine
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Date
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="appointment in appointments" :key="appointment.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ appointment.guardian?.first_name }} {{ appointment.guardian?.last_name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ appointment.baby?.first_name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ appointment.nurse ? appointment.nurse?.first_name + ' ' + appointment.nurse?.last_name : 'No nurse assigned' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ appointment.vaccine?.vaccine_name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ formatDate(appointment?.appointment_date) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusClass(appointment.status)">
                    {{ appointment?.status }}
                  </span>
                </td>
                <!-- Actions: Edit and Delete -->
                <td class="px-6 py-4 whitespace-nowrap text-center">
                  <button @click="openEditModal(appointment)"
                    class="cursor-pointer text-blue-600 hover:text-blue-900 mr-2">
                    Edit
                  </button>
                  <!-- <button @click="deleteAppointment(appointment.id)"
                    class="cursor-pointer text-red-600 hover:text-red-900">
                    Delete
                  </button> -->
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Calendar View -->
        <div v-if="activeTab === 'calendar'" class="bg-white rounded-lg shadow-sm p-6">
          <FullCalendar :options="calendarOptions" />
        </div>

        <!-- Add Appointment Modal -->
        <Teleport to="body">
          <TransitionRoot appear :show="isModalOpen" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
              <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 backdrop-blur-xs" />
              </TransitionChild>

              <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                  <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95">
                    <DialogPanel
                      class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                      <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                        Add New Appointment
                      </DialogTitle>
                      <div class="mt-2">
                        <form @submit.prevent="addAppointment" class="space-y-4">
                          <!-- Fields for new appointment (same as before) -->
                          <div>
                            <label for="patientName" class="block text-sm font-medium text-gray-700">Patient
                              Name</label>
                            <select id="patientName" v-model="newAppointment.baby_id"
                              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                              required>
                              <option value="">Select Patient</option>
                              <option v-for="patient in patients" :key="patient.id" :value="patient.id">
                                {{ patient.first_name }} {{ patient.last_name }}
                              </option>
                            </select>
                          </div>
                          <div>
                            <label for="parentName" class="block text-sm font-medium text-gray-700">Parent Name</label>
                            <select id="parentName" v-model="newAppointment.guardian_id"
                              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                              required>
                              <option value="">Select Parent</option>
                              <option v-for="parent in parents" :key="parent.id" :value="parent.id">
                                {{ parent.first_name }} {{ parent.last_name }}
                              </option>
                            </select>
                          </div>
                          <div>
                            <label for="vaccine" class="block text-sm font-medium text-gray-700">Vaccine</label>
                            <select id="vaccine" v-model="newAppointment.vaccine_id"
                              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                              required>
                              <option value="">Select Vaccine</option>
                              <option v-for="vaccine in vaccines" :key="vaccine.id" :value="vaccine.id">
                                {{ vaccine.vaccine_name }}
                              </option>
                            </select>
                          </div>
                          <div>
                            <label for="appointmentDate" class="block text-sm font-medium text-gray-700">Appointment
                              Date</label>
                            <input type="datetime-local" id="appointmentDate" v-model="newAppointment.appointment_date"
                              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                              required>
                          </div>
                          <div class="mt-4 flex justify-end space-x-2">
                            <button type="button"
                              class="inline-flex justify-center rounded-md border border-transparent bg-gray-100 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                              @click="closeModal">
                              Cancel
                            </button>
                            <button type="submit"
                              class="inline-flex cursor-pointer justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                              Add Appointment
                            </button>
                          </div>
                        </form>
                      </div>
                    </DialogPanel>
                  </TransitionChild>
                </div>
              </div>
            </Dialog>
          </TransitionRoot>
        </Teleport>

        <!-- Edit Appointment Modal -->
        <Teleport to="body">
          <TransitionRoot appear :show="isEditModalOpen" as="template">
            <Dialog as="div" @close="closeEditModal" class="relative z-10">
              <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 backdrop-blur-xs" />
              </TransitionChild>
              <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                  <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95">
                    <DialogPanel
                      class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                      <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                        Edit Appointment
                      </DialogTitle>
                      <div class="mt-2">
                        <form @submit.prevent="saveEditAppointment" class="space-y-4">
                          <!-- Appointment Date -->
                          <div>
                            <label for="editAppointmentDate" class="block text-sm font-medium text-gray-700">
                              Appointment Date
                            </label>
                            <input type="datetime-local" id="editAppointmentDate"
                              v-model="editAppointment.appointment_date"
                              class="mt-1 block w-full pl-3 pr-10 py-2 border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                              required>
                          </div>
                          <!-- Doctor -->
                          <div>
                            <label for="editDoctor" class="block text-sm font-medium text-gray-700">
                              Doctor on duty
                            </label>
                            <select id="editDoctor" v-model="editAppointment.doctor_id"
                              class="mt-1 block w-full pl-3 pr-10 py-2 border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                              required>
                              <option value="">Select Doctor</option>
                              <!-- Assuming you have a list of doctors; if not, adjust accordingly -->
                              <option v-for="doctor in doctors" :key="doctor.user_id" :value="doctor.user_id">
                                {{ doctor.user.first_name }} {{ doctor.user.last_name }}
                              </option>
                            </select>
                          </div>
                          <!-- Status -->
                          <div>
                            <label for="editStatus" class="block text-sm font-medium text-gray-700">
                              Status
                            </label>
                            <select id="editStatus" v-model="editAppointment.status"
                              class="mt-1 block w-full pl-3 pr-10 py-2 border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                              required>
                              <option value="Scheduled">Scheduled</option>
                              <option value="Completed">Completed</option>
                              <option value="Cancelled">Cancelled</option>
                            </select>
                          </div>
                          <!-- Appointment Date -->
                          <div v-show="editAppointment.status === 'Completed'">
                            <label for="editNextAppointmentDate" class="block text-sm font-medium text-gray-700">
                              Next Appointment Date
                            </label>
                            <input type="datetime-local" id="editNextAppointmentDate"
                              v-model="editAppointment.next_appointment_date"
                              class="mt-1 block w-full pl-3 pr-10 py-2 border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                              :required="editAppointment.status === 'Completed'">
                          </div>
                          <!-- Vaccine -->
                          <div v-show="editAppointment.status === 'Completed'">
                            <label for="vaccine" class="block text-sm font-medium text-gray-700">Vaccine</label>
                            <select id="vaccine" v-model="editAppointment.vaccine_id"
                              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                              :required="editAppointment.status === 'Completed'">
                              <option value="">Select Vaccine</option>
                              <option v-for="vaccine in vaccines" :key="vaccine.id" :value="vaccine.id">
                                {{ vaccine.vaccine_name }}
                              </option>
                            </select>
                          </div>
                          <!-- Buttons -->
                          <div class="mt-4 flex justify-end space-x-2">
                            <button type="button"
                              class="inline-flex justify-center rounded-md border border-transparent bg-gray-100 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                              @click="closeEditModal">
                              Cancel
                            </button>
                            <button type="submit"
                              class="inline-flex cursor-pointer justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                              Save Changes
                            </button>
                          </div>
                        </form>
                      </div>
                    </DialogPanel>
                  </TransitionChild>
                </div>
              </div>
            </Dialog>
          </TransitionRoot>
        </Teleport>

      </div>
    </div>
  </Sidebar>
</template>
