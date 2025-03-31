<script setup>
import Sidebar from "@/components/Hospital/Sidebar.vue";
import { ref, onMounted } from "vue";

const guardianSearchTerm = ref('');
const filteredGuardians = ref([]);
const showGuardianResults = ref(false);

const searchGuardians = () => {
  if (guardianSearchTerm.value.trim() === '') {
    filteredGuardians.value = [];
    return;
  }

  const searchTermLower = guardianSearchTerm.value.toLowerCase();
  filteredGuardians.value = guardians.value.filter(guardian => {
    const fullName = `${guardian.first_name} ${guardian.last_name}`.toLowerCase();
    return fullName.includes(searchTermLower);
  });
};

const selectGuardian = (guardian) => {
  form.value.guardian = guardian.id;
  guardianSearchTerm.value = `${guardian.first_name} ${guardian.last_name}`;
  showGuardianResults.value = false;
};

const form = ref({
  fullName: "",
  guardian: "",
  gender: "",
  dateOfBirth: "",
  nationality: "",
});

const guardians = ref([]); // List of guardians
const doctors = ref([]);
const nationalities = ref([
  "Nigeria",
  "Kenya",
  "Ghana",
  "South Africa",
  "Uganda",
  "Ethiopia",
  "Tanzania",
  "United States",
  "United Kingdom",
  "Canada",
  "India",
  "China",
  "Germany",
  "France",
]);

const showModal = ref(false);
const modalMessage = ref('');

// Fetch guardians from API
const fetchGuardians = async () => {
  try {
    const response = await fetch("http://127.0.0.1:8000/api/guardians", {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    const data = await response.json();
    guardians.value = data.guardians;
  } catch (error) {
    console.error("Error fetching guardians:", error);
  }
};

// Fetch doctors from API
const fetchDoctors = async () => {
  try {
    const response = await fetch("http://127.0.0.1:8000/api/doctors", {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    const data = await response.json();

    doctors.value = data.doctors;
  } catch (error) {
    console.error("Error fetching Doctors:", error);
  }
};
console.log("DOCTORS: " + doctors)

onMounted(fetchGuardians);
onMounted(fetchDoctors);

const submitForm = async () => {
    try {
        const response = await fetch("http://127.0.0.1:8000/api/babies", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify({
                first_name: form.value.fullName,
                guardian_id: form.value.guardian,
                gender: form.value.gender,
                date_of_birth: form.value.dateOfBirth,
                nationality: form.value.nationality,
                immunization_status: "Pending" 
            })
        });

        if (!response.ok) {
            throw new Error("Failed to submit form");
        }

        const result = await response.json();
        console.log("Baby Added:", result);

        modalMessage.value = "Baby added successfully!";
        showModal.value = true;
        form.value = {
          fullName: "",
          guardian: "",
          gender: "",
          dateOfBirth: "",
          nationality: "",
        };

    } catch (error) {
        console.error("Error submitting form:", error);
    }
};

const closeModal = () => {
  showModal.value = false;
};
</script>

<template>
  <Sidebar title="Add Baby">
    <div class="max-w-3xl mx-auto">
      <div class="bg-white rounded-lg shadow-sm p-6">
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <!-- Full Name -->
            <div>
              <label for="fullName" class="block text-sm text-gray-600 mb-1">Full Name</label>
              <input id="fullName" v-model="form.fullName" type="text"
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter Baby's Full Name" required />
            </div>

            <!-- Guardian Search -->
            <div class="relative">
              <label for="guardianSearch" class="block text-sm text-gray-600 mb-1">Guardian</label>
              <input id="guardianSearch" v-model="guardianSearchTerm" type="text"
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Search for guardian..." @input="searchGuardians" @focus="showGuardianResults = true"
                @blur="setTimeout(() => { showGuardianResults = false }, 200)" required />
              <input type="hidden" v-model="form.guardian" required />

              <!-- Search Results -->
              <div v-if="showGuardianResults && filteredGuardians.length > 0"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto">
                <div v-for="guardian in filteredGuardians" :key="guardian.id" @mousedown="selectGuardian(guardian)"
                  class="p-2 hover:bg-gray-100 cursor-pointer">
                  {{ guardian.first_name }} {{ guardian.last_name }}
                </div>
              </div>

              <!-- No Results Message -->
              <div v-if="showGuardianResults && guardianSearchTerm && filteredGuardians.length === 0"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg p-2 text-gray-500">
                No matching guardians found
              </div>
            </div>

            <!-- Gender Selection -->
            <div>
              <label for="gender" class="block text-sm text-gray-600 mb-1">Gender</label>
              <select id="gender" v-model="form.gender" required
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <!-- Date of Birth -->
            <div>
              <label for="dateOfBirth" class="block text-sm text-gray-600 mb-1">Date of Birth</label>
              <input id="dateOfBirth" v-model="form.dateOfBirth" type="date" required
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Nationality Selection -->
            <div>
              <label for="nationality" class="block text-sm text-gray-600 mb-1">Nationality</label>
              <select id="nationality" v-model="form.nationality" required
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="" class="hidden">Select Nationality</option>
                <option v-for="country in nationalities" :key="country" :value="country">
                  {{ country }}
                </option>
              </select>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="mt-8 flex justify-center">
            <button type="submit"
              class="cursor-pointer bg-blue-600 text-white px-8 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              Save
            </button>
          </div>
        </form>
      </div>
    </div>
    <div v-if="showModal" class="fixed inset-0 backdrop-blur-xs flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
        <div class="flex flex-col items-center">
          <div class="mb-4 text-green-600">
            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-4">Success!</h3>
          <p class="text-gray-600 text-center mb-6">{{ modalMessage }}</p>
          <button @click="closeModal"
            class="cursor-pointer bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Close
          </button>
        </div>
      </div>
    </div>
  </Sidebar>
</template>

