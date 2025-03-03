<template>
  <LandingsLayout>
    <div class="min-h-screen bg-[#F8F8FF] text-[#121212] py-12 px-6">
      <section class="max-w-6xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-12">Find Nearby Clinics</h2>

        <!-- Search and Filter Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 space-y-4 md:space-y-0">
          <input
            v-model="searchQuery"
            type="search"
            placeholder="Search clinics by name or location..."
            class="bg-[#F8F8FF] text-[#121212] p-3 outline outline-[#121212] rounded-lg w-full md:w-1/2 focus:outline-none focus:ring-2 focus:ring-[#04A699] pl-10"
          />
          <select
            v-model="filterType"
            class="bg-[#F8F8FF] text-[#121212] outline outline-[#121212] p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#04A699]"
          >
            <option value="all">All Types</option>
            <option value="pediatrician">Pediatricians</option>
            <option value="hospital">Hospitals</option>
            <option value="vaccination-center">Vaccination Centers</option>
          </select>
        </div>

        <!-- Map Section -->
        <div class="bg-[#121212] rounded-lg overflow-hidden h-[500px] relative">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.8354345093747!2d144.9537353153166!3d-37.816279742021665!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d2d2b2a3f6c1!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sus!4v1625070000000!5m2!1sen!2sus"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
          ></iframe>
          <div
            v-if="selectedClinic"
            class="absolute top-4 right-4 bg-[#F8F8FF] p-6 rounded-lg max-w-sm w-full"
          >
            <button
              @click="selectedClinic = null"
              class="absolute top-2 right-2 text-[#121212] hover:text-[#04A699]"
            >
              &times;
            </button>
            <h3 class="text-2xl font-bold mb-4">{{ selectedClinic.name }}</h3>
            <p class="text-lg mb-2"><strong>Address:</strong> {{ selectedClinic.address }}</p>
            <p class="text-lg mb-2"><strong>Phone:</strong> {{ selectedClinic.phone }}</p>
            <p class="text-lg mb-2"><strong>Email:</strong> {{ selectedClinic.email }}</p>
            <p class="text-lg mb-2"><strong>Hours:</strong> {{ selectedClinic.hours }}</p>
            <p class="text-lg mb-2">
              <strong>Website:</strong>
              <a :href="selectedClinic.website" target="_blank" class="text-[#04A699] hover:underline">
                {{ selectedClinic.website }}
              </a>
            </p>
            <p class="text-lg mb-2"><strong>Notes:</strong> {{ selectedClinic.notes }}</p>
          </div>
        </div>

        <!-- Clinics List Section -->
        <div class="mt-8">
          <h3 class="text-2xl font-bold mb-6">Clinics Near You</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
              v-for="clinic in filteredClinics"
              :key="clinic.id"
              class="bg-[#038C7F] p-6 rounded-lg hover:bg-[#038275] transition duration-300 cursor-pointer"
              @click="selectedClinic = clinic"
            >
              <h4 class="text-[#F8F8FF] text-xl font-semibold mb-2">{{ clinic.name }}</h4>
              <p class="text-[#F8F8FF]">{{ clinic.address }}</p>
              <p class="text-[#F8F8FF]">{{ clinic.phone }}</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </LandingsLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import LandingsLayout from '@/components/landing/landingsLayout.vue';

// Reactive state
const searchQuery = ref('');
const filterType = ref('all');
const selectedClinic = ref(null);

// Clinic data
const clinics = ref([
  {
    id: 1,
    name: 'City Pediatrics',
    address: '123 Health Lane, Tech City, TX 12345',
    phone: '+1 (234) 567-8901',
    email: 'info@citypediatrics.com',
    hours: 'Mon-Fri: 8 AM - 6 PM',
    website: 'https://citypediatrics.com',
    notes: 'Accepts walk-ins. Offers all childhood vaccines.',
    type: 'pediatrician',
  },
  {
    id: 2,
    name: 'Tech City General Hospital',
    address: '456 Wellness Blvd, Tech City, TX 12345',
    phone: '+1 (234) 567-8902',
    email: 'info@techcityhospital.com',
    hours: '24/7',
    website: 'https://techcityhospital.com',
    notes: 'Pediatric vaccination services available.',
    type: 'hospital',
  },
  {
    id: 3,
    name: 'Vaccination Central',
    address: '789 Immunization St, Tech City, TX 12345',
    phone: '+1 (234) 567-8903',
    email: 'info@vaccinationcentral.com',
    hours: 'Mon-Sat: 9 AM - 5 PM',
    website: 'https://vaccinationcentral.com',
    notes: 'Specializes in vaccinations. Walk-ins welcome.',
    type: 'vaccination-center',
  },
]);

// Computed property for filtered clinics
const filteredClinics = computed(() => {
  return clinics.value.filter(clinic => {
    const matchesSearch = clinic.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      clinic.address.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchesType = filterType.value === 'all' || clinic.type === filterType.value;
    return matchesSearch && matchesType;
  });
});
</script>