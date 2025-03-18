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


// Fetch patients from the API
const fetchPatients = async () => {
  try {
    const token = localStorage.getItem("token")
    const response = await axios.get('/api/babies', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    patients.value = response.data
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
    parents.value = response.data
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
    vaccines.value = response.data
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
    fetchVaccines()
  ])
})

console.log(appointments)

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
    title: `${appointment.patientName} - ${appointment.doctorName}`,
    start: appointment.date,
    allDay: false,
    backgroundColor: getEventColor(appointment.status)
  })),
  eventClick: (info) => {
    alert(`Appointment: ${info.event.title}`)
    // Add detailed view or editing functionality as needed
  }
}))

// Modal logic for adding a new appointment
const isModalOpen = ref(false)
const newAppointment = ref({
  patientName: '',
  parentName: '',
  vaccine: '',
  appointmentDate: ''
})

const closeModal = () => {
  isModalOpen.value = false
  newAppointment.value = {
    patientName: '',
    parentName: '',
    vaccine: '',
    appointmentDate: ''
  }
}

const addAppointment = async () => {
  try {
    // Post new appointment data to the backend
    const response = await axios.post('/api/appointments', newAppointment.value)
    // Append the newly created appointment to the local array
    appointments.value.push(response.data)
    closeModal()
  } catch (error) {
    console.error('Error adding appointment:', error)
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
          <table class="min-w-full">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Patient Name
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Doctor's Name
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Date
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="appointment in appointments" :key="appointment.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ appointment.baby.full_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ appointment.doctor }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(appointment.appointment_details.date) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusClass(appointment.appointment_details.status)">
                    {{ appointment.appointment_details.status }}
                  </span>
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
                          <div>
                            <label for="patientName" class="block text-sm font-medium text-gray-700">Patient
                              Name</label>
                            <select id="patientName" v-model="newAppointment.patientName"
                              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                              required>
                              <option value="">Select Patient</option>
                              <option v-for="patient in patients" :key="patient.id" :value="patient.name">
                                {{ patient.name }}
                              </option>
                            </select>
                          </div>
                          <div>
                            <label for="parentName" class="block text-sm font-medium text-gray-700">Parent Name</label>
                            <select id="parentName" v-model="newAppointment.parentName"
                              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                              required>
                              <option value="">Select Parent</option>
                              <option v-for="parent in parents" :key="parent.id" :value="parent.name">
                                {{ parent.name }}
                              </option>
                            </select>
                          </div>
                          <div>
                            <label for="vaccine" class="block text-sm font-medium text-gray-700">Vaccine</label>
                            <select id="vaccine" v-model="newAppointment.vaccine"
                              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                              required>
                              <option value="">Select Vaccine</option>
                              <option v-for="vaccine in vaccines" :key="vaccine.id" :value="vaccine.name">
                                {{ vaccine.name }}
                              </option>
                            </select>
                          </div>
                          <div>
                            <label for="appointmentDate" class="block text-sm font-medium text-gray-700">Appointment
                              Date</label>
                            <input type="datetime-local" id="appointmentDate" v-model="newAppointment.appointmentDate"
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
      </div>
    </div>
  </Sidebar>
</template>
