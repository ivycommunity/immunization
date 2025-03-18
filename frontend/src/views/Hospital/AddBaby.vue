<script setup>
import Sidebar from "@/components/Hospital/Sidebar.vue";
import { ref, onMounted } from "vue";

const form = ref({
  firstName: "",
  lastName: "",
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
                first_name: form.value.firstName,
                last_name: form.value.lastName,
                guardian_id: form.value.guardian,
                gender: form.value.gender,
                date_of_birth: form.value.dateOfBirth,
                nationality: form.value.nationality,
                immunization_status: "Pending" // Default status for a new baby
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
          firstName: "",
          lastName: "",
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
            <!-- First Name -->
            <div>
              <label for="firstName" class="block text-sm text-gray-600 mb-1"
                >First Name</label
              >
              <input
                id="firstName"
                v-model="form.firstName"
                type="text"
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter Baby's First Name"
                required
              />
            </div>

            <!-- Last Name -->
            <div>
              <label for="lastName" class="block text-sm text-gray-600 mb-1"
                >Last Name</label
              >
              <input
                id="lastName"
                v-model="form.lastName"
                type="text"
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter Baby's Last Name"
                required
              />
            </div>

            <!-- Guardian Selection -->
            <div>
              <label for="guardian" class="block text-sm text-gray-600 mb-1"
                >Guardian</label
              >
              <select
                v-model="form.guardian"
                id="guardian"
                required
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="" class="hidden">Select Guardian</option>
                <option
                  v-for="guardian in guardians"
                  :key="guardian.id"
                  :value="guardian.id"
                >
                  {{ guardian.first_name }} {{ guardian.last_name }}
                </option>
              </select>
            </div>

            <!-- Gender Selection -->
            <div>
              <label for="gender" class="block text-sm text-gray-600 mb-1"
                >Gender</label
              >
              <select
                id="gender"
                v-model="form.gender"
                required
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <!-- Date of Birth -->
            <div>
              <label for="dateOfBirth" class="block text-sm text-gray-600 mb-1"
                >Date of Birth</label
              >
              <input
                id="dateOfBirth"
                v-model="form.dateOfBirth"
                type="date"
                required
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>

            <!-- Nationality Selection -->
            <div>
              <label for="nationality" class="block text-sm text-gray-600 mb-1"
                >Nationality</label
              >
              <select
                id="nationality"
                v-model="form.nationality"
                required
                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="" class="hidden">Select Nationality</option>
                <option
                  v-for="country in nationalities"
                  :key="country"
                  :value="country"
                >
                  {{ country }}
                </option>
              </select>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="mt-8 flex justify-center">
            <button
              type="submit"
              class="bg-blue-600 text-white px-8 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
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

