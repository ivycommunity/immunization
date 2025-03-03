<script setup>
import Sidebar from '@/components/Hospital/Sidebar.vue';
import { ref, computed } from 'vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

const activeTab = ref('list')

// Sample appointments data
const appointments = ref([
    { id: 1, patientName: 'John Doe', doctorName: 'Dr. Smith', date: '2025-03-01T10:00:00', status: 'Scheduled' },
    { id: 2, patientName: 'Jane Smith', doctorName: 'Dr. Johnson', date: '2025-03-10T14:30:00', status: 'Completed' },
    { id: 3, patientName: 'Bob Brown', doctorName: 'Dr. Lee', date: '2025-04-03T11:15:00', status: 'Cancelled' },
    // Add more appointments as needed
])

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' }
    return new Date(dateString).toLocaleDateString(undefined, options)
}

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
        // You can add more detailed view or edit functionality here
    }
}))

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

const isModalOpen = ref(false)
const newAppointment = ref({
    patientName: '',
    parentName: '',
    vaccine: '',
    appointmentDate: ''
})

// Sample data for dropdowns (replace with your actual data)
const patients = ref([
    { id: 1, name: 'John Doe' },
    { id: 2, name: 'Jane Smith' },
    // Add more patients...
])

const parents = ref([
    { id: 1, name: 'Mr. Doe' },
    { id: 2, name: 'Mrs. Smith' },
    // Add more parents...
])

const vaccines = ref([
    { id: 1, name: 'MMR' },
    { id: 2, name: 'DPT' },
    { id: 3, name: 'Polio' },
    // Add more vaccines...
])

const closeModal = () => {
    isModalOpen.value = false
    newAppointment.value = {
        patientName: '',
        parentName: '',
        vaccine: '',
        appointmentDate: ''
    }
}

const addAppointment = () => {
    // Here you would typically send the new appointment data to your backend
    console.log('New Appointment:', newAppointment.value)

    // For this example, we'll just add it to the local appointments array
    appointments.value.push({
        id: appointments.value.length + 1,
        patientName: newAppointment.value.patientName,
        doctorName: 'Dr. Assigned', // You might want to add doctor selection to the form
        date: newAppointment.value.appointmentDate,
        status: 'Scheduled'
    })

    // Close the modal and reset the form
    closeModal()
}

</script>

<template>
    <Sidebar title="Appointments">
        <div class="min-h-screen bg-blue-50 p-6">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Appointments</h1>
                    <button @click="isModalOpen = true"
                        class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Add Appointment
                    </button>
                </div>

                <!-- Tabs -->
                <div class="mb-6">
                    <button @click="activeTab = 'list'"
                        :class="['px-4 py-2 rounded-t-lg', activeTab === 'list' ? 'bg-white text-blue-600' : 'bg-gray-200 text-gray-600']">
                        List View
                    </button>
                    <button @click="activeTab = 'calendar'"
                        :class="['px-4 py-2 rounded-t-lg', activeTab === 'calendar' ? 'bg-white text-blue-600' : 'bg-gray-200 text-gray-600']">
                        Calendar View
                    </button>
                </div>

                <!-- List View -->
                <div v-if="activeTab === 'list'" class="bg-white rounded-lg shadow-sm p-6">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Patient Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Doctor's Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="appointment in appointments" :key="appointment.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ appointment.patientName }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ appointment.doctorName }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(appointment.date) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="getStatusClass(appointment.status)">
                                        {{ appointment.status }}
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
                            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
                                enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100"
                                leave-to="opacity-0">
                                <div class="fixed inset-0 backdrop-blur-xs" />
                            </TransitionChild>

                            <div class="fixed inset-0 overflow-y-auto">
                                <div class="flex min-h-full items-center justify-center p-4 text-center">
                                    <TransitionChild as="template" enter="duration-300 ease-out"
                                        enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100"
                                        leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                                        leave-to="opacity-0 scale-95">
                                        <DialogPanel
                                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                                Add New Appointment
                                            </DialogTitle>
                                            <div class="mt-2">
                                                <form @submit.prevent="addAppointment" class="space-y-4">
                                                    <div>
                                                        <label for="patientName"
                                                            class="block text-sm font-medium text-gray-700">Patient
                                                            Name</label>
                                                        <select id="patientName" v-model="newAppointment.patientName"
                                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                                            required>
                                                            <option value="">Select Patient</option>
                                                            <option v-for="patient in patients" :key="patient.id"
                                                                :value="patient.name">
                                                                {{ patient.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="parentName"
                                                            class="block text-sm font-medium text-gray-700">Parent
                                                            Name</label>
                                                        <select id="parentName" v-model="newAppointment.parentName"
                                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                                            required>
                                                            <option value="">Select Parent</option>
                                                            <option v-for="parent in parents" :key="parent.id"
                                                                :value="parent.name">
                                                                {{ parent.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="vaccine"
                                                            class="block text-sm font-medium text-gray-700">Vaccine</label>
                                                        <select id="vaccine" v-model="newAppointment.vaccine"
                                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                                            required>
                                                            <option value="">Select Vaccine</option>
                                                            <option v-for="vaccine in vaccines" :key="vaccine.id"
                                                                :value="vaccine.name">
                                                                {{ vaccine.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="appointmentDate"
                                                            class="block text-sm font-medium text-gray-700">Appointment
                                                            Date</label>
                                                        <input type="datetime-local" id="appointmentDate"
                                                            v-model="newAppointment.appointmentDate"
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