<template>
    <Sidebar title="Patients">
      <!-- Stats Cards -->
      <div class="grid grid-cols-3 gap-4 p-4">
        <Card title="Number of Patients" :number="patients.length" />
        <Card title="Number of Appointments Today" :number="appointmentsToday" class="text-blue-500" />
        <Card title="Missed Appointments" :number="missedAppointments" class="text-red-500" />
      </div>
  
      <!-- Search and Filter -->
      <div class="px-4 py-2">
        <div class="flex items-center bg-white rounded-lg shadow p-2">
          <input v-model="searchQuery" type="text" placeholder="Search Patient" class="flex-1 px-4 py-2 outline-none" />
          <button class="p-2">
            <SearchIcon class="h-5 w-5 text-gray-500" />
          </button>
        </div>
      </div>
  
      <!-- Table -->
      <div class="flex-1 overflow-auto p-4">
        <table class="min-w-full bg-white rounded-lg shadow">
          <thead>
            <tr class="border-b">
              <th class="py-3 px-4 text-left">Guardian's Name</th>
              <th class="py-3 px-4 text-left">Baby's Name</th>
              <th class="py-3 px-4 text-left">Last Vaccine Received</th>
              <th class="py-3 px-4 text-left">Immunization Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(patient, index) in paginatedPatients" :key="index" class="border-b">
              <td class="py-3 px-4">{{ patient.guardian ? patient.guardian.first_name + ' ' + patient.guardian.last_name : 'N/A' }}</td>
              <td class="py-3 px-4">{{ patient.first_name + ' ' + patient.last_name }}</td>
              <td class="py-3 px-4">{{ patient.last_vaccine_received ? patient.last_vaccine_received : 'No Record' }}</td>
              <td class="py-3 px-4" :class="getStatusClass(patient.immunization_status)">
                {{ patient.immunization_status }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Pagination Controls -->
      <div class="p-4 flex justify-between items-center text-sm">
        <div>{{ startItem }}-{{ endItem }} of {{ filteredPatients.length }}</div>
        <div class="flex items-center space-x-2">
          <span>Rows per page:</span>
          <select v-model="itemsPerPage" class="border rounded px-2 py-1">
            <option>5</option>
            <option>10</option>
            <option>25</option>
          </select>
  
          <button @click="prevPage" :disabled="currentPage === 1" class="p-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
            Previous
          </button>
  
          <span>Page {{ currentPage }} of {{ totalPages }}</span>
  
          <button @click="nextPage" :disabled="currentPage >= totalPages" class="p-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
            Next
          </button>
        </div>
      </div>
    </Sidebar>
  </template>
  
  <script>
  import { ref, computed } from "vue";
  import { SearchIcon } from "lucide-vue-next";
  import Sidebar from "@/components/Hospital/Sidebar.vue";
  import Card from "@/components/Hospital/Card.vue";
  
  export default {
    name: "Patients",
    components: {
      Sidebar,
      Card,
    },
    data() {
      return {
        searchQuery: "",
        patients: [],
        appointmentsToday: 0,
        missedAppointments: 0,
        currentPage: 1,
        itemsPerPage: 5,
      };
    },
    computed: {
      filteredPatients() {
        return this.patients.filter((patient) =>
          (patient.first_name + " " + patient.last_name)
            .toLowerCase()
            .includes(this.searchQuery.toLowerCase())
        );
      },
      paginatedPatients() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        return this.filteredPatients.slice(start, start + this.itemsPerPage);
      },
      totalPages() {
        return Math.ceil(this.filteredPatients.length / this.itemsPerPage);
      },
      startItem() {
        return this.filteredPatients.length === 0 ? 0 : (this.currentPage - 1) * this.itemsPerPage + 1;
      },
      endItem() {
        return Math.min(this.currentPage * this.itemsPerPage, this.filteredPatients.length);
      }
    },
    mounted() {
      this.fetchPatients();
    },
    methods: {
      async fetchPatients() {
        try {
          const response = await fetch("http://127.0.0.1:8000/api/babies", {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          });
          const data = await response.json();
          this.patients = data.babies;
          this.appointmentsToday = data.appointmentsToday || 0;
          this.missedAppointments = data.missedAppointments || 0;
        } catch (error) {
          console.error("Error fetching patients:", error);
        }
      },
      prevPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
        }
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.currentPage++;
        }
      },
      getStatusClass(status) {
        return {
          "text-green-500": status === "Up to date",
          "text-yellow-500": status === "Pending",
          "text-red-500": status === "Overdue",
        };
      },
    },
  };
  </script>
  