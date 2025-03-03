<template>
  <LandingsLayout>
    <div class="min-h-screen bg-[#F8F8FF] text-[#02343B] py-12 px-6">
      <section class="max-w-6xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-12">Vaccination List</h2>

        <!-- Search and Sort Section -->
        <div class="flex justify-between items-center mb-8">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search vaccines..."
            class="bg-[#F8F8FF] text-[#121212]/80 outline outline-[#121212]/90 p-3 rounded-lg w-1/2 focus:outline-none focus:ring-2 focus:ring-[#04A699]"
          />
          <select
            v-model="sortBy"
            class="bg-[#F8F8FF] text-[#121212]/80 outline outline-[#121212]/90 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#04A699]"
          >
            <option value="name">Sort by Name</option>
            <option value="age">Sort by Age</option>
          </select>
        </div>

        <!-- Vaccination Table -->
        <div class="bg-[#F8F8FF] rounded-lg overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="bg-[#04A699] text-[#F8F8FF]">
                  <th class="p-4 text-left">Vaccine Name</th>
                  <th class="p-4 text-left">Age Recommendations</th>
                  <th class="p-4 text-left">Description</th>
                  <th class="p-4 text-left">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="vaccine in filteredVaccines"
                  :key="vaccine.id"
                  class="border-b border-[#02343B] hover:bg-[#EEEEF5] transition duration-300"
                >
                  <td class="p-4">{{ vaccine.name }}</td>
                  <td class="p-4">{{ vaccine.age }}</td>
                  <td class="p-4">{{ vaccine.description }}</td>
                  <td class="p-4">
                    <button
                      @click="openDetails(vaccine)"
                      class="bg-[#04A699] text-[#F8F8FF] px-4 py-2 rounded-lg hover:bg-[#038C7F] transition duration-300"
                    >
                      Details
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Vaccine Details Modal -->
      <div v-if="selectedVaccine" class="fixed inset-0 bg-[#02343B]/80 flex items-center justify-center p-6">
        <div class="bg-[#F8F8FF] rounded-lg p-8 max-w-2xl w-full relative">
          <button
            @click="selectedVaccine = null"
            class="absolute top-4 right-4 text-[#121212] hover:text-[#04A699]"
          >
            &times;
          </button>
          <h3 class="text-3xl font-bold mb-6">{{ selectedVaccine.name }}</h3>
          <p class="text-lg mb-4"><strong>Age Recommendations:</strong> {{ selectedVaccine.age }}</p>
          <p class="text-lg mb-4"><strong>Description:</strong> {{ selectedVaccine.fullDescription }}</p>
          <p class="text-lg mb-4"><strong>Schedule:</strong> {{ selectedVaccine.schedule }}</p>
          <p class="text-lg mb-4"><strong>Manufacturer:</strong> {{ selectedVaccine.manufacturer }}</p>
          <p class="text-lg mb-6">
            <strong>Learn More: </strong>
            <a :href="selectedVaccine.sourceLink" target="_blank" class="text-[#04A699] hover:underline">
              {{ selectedVaccine.source }}
            </a>
          </p>
          <div class="flex space-x-4 justify-center" hidden>
            <button
              @click="addToCalendar(selectedVaccine)"
              class="bg-[#04A699] text-[#F8F8FF] px-6 py-3 rounded-lg hover:bg-[#038C7F] transition duration-300"
            >
              Add to Calendar
            </button>
            <button
              @click="downloadRecord(selectedVaccine)"
              class="bg-[#04A699] text-[#F8F8FF] px-6 py-3 rounded-lg hover:bg-[#038C7F] transition duration-300"
            >
              Download Record
            </button>
          </div>
        </div>
      </div>
    </div>
  </LandingsLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import LandingsLayout from '@/components/landingsLayout.vue';

// Reactive state
const searchQuery = ref('');
const sortBy = ref('name');
const selectedVaccine = ref(null);

// Vaccine data
const vaccines = ref([
  {
    id: 1,
    name: 'Hepatitis B',
    age: 'At birth',
    description: 'Protects against Hepatitis B virus.',
    fullDescription: 'The Hepatitis B vaccine is given to prevent infection by the Hepatitis B virus, which can cause liver damage.',
    schedule: 'First dose at birth, second dose at 1-2 months, third dose at 6-18 months.',
    manufacturer: 'Various',
    source: 'CDC',
    sourceLink: 'https://www.cdc.gov/vaccines/hcp/vis/vis-statements/hep-b.html',
  },
  {
    id: 2,
    name: 'DTaP',
    age: '2, 4, 6 months',
    description: 'Protects against Diphtheria, Tetanus, and Pertussis.',
    fullDescription: 'The DTaP vaccine protects against three serious diseases: Diphtheria, Tetanus, and Pertussis (whooping cough).',
    schedule: 'Five doses: 2 months, 4 months, 6 months, 15-18 months, and 4-6 years.',
    manufacturer: 'Various',
    source: 'WHO',
    sourceLink: 'https://www.who.int/health-topics/diphtheria',
  },
  {
    id: 3,
    name: 'MMR',
    age: '12-15 months',
    description: 'Protects against Measles, Mumps, and Rubella.',
    fullDescription: 'The MMR vaccine protects against three viral diseases: Measles, Mumps, and Rubella.',
    schedule: 'First dose at 12-15 months, second dose at 4-6 years.',
    manufacturer: 'Various',
    source: 'CDC',
    sourceLink: 'https://www.cdc.gov/vaccines/hcp/vis/vis-statements/mmr.html',
  },
]);

// Computed property for filtered and sorted vaccines
const filteredVaccines = computed(() => {
  let filtered = vaccines.value.filter(vaccine =>
    vaccine.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );

  if (sortBy.value === 'name') {
    filtered.sort((a, b) => a.name.localeCompare(b.name));
  } else if (sortBy.value === 'age') {
    filtered.sort((a, b) => a.age.localeCompare(b.age));
  }

  return filtered;
});

// Methods
const openDetails = (vaccine) => {
  selectedVaccine.value = vaccine;
};

const addToCalendar = (vaccine) => {
  alert(`Added ${vaccine.name} to your calendar.`);
};

const downloadRecord = (vaccine) => {
  alert(`Downloading ${vaccine.name} record as PDF.`);
};
</script>