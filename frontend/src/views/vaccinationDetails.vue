<template>
  <LandingsLayout>
    <div class="min-h-screen bg-[#F8F8FF] text-[#02343B] py-12 px-6">
      <section class="max-w-6xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-12">Vaccination List</h2>

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
                  v-for="(vaccine, index) in vaccines"
                  :key="index"
                  class="border-b border-[#02343B] hover:bg-[#EEEEF5] transition duration-300"
                >
                  <td class="p-4">{{ vaccine.vaccine_name }}</td>
                  <td class="p-4">{{ vaccine.recommended_age }}</td>
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

      <div
        v-if="selectedVaccine"
        class="fixed inset-0 bg-[#02343B]/80 flex items-center justify-center p-6"
      >
        <div class="bg-[#F8F8FF] rounded-lg p-8 max-w-2xl w-full relative">
          <button
            @click="selectedVaccine = null"
            class="absolute top-4 right-4 text-[#121212] hover:text-[#04A699]"
          >
            &times;
          </button>
          <h3 class="text-3xl font-bold mb-6">
            {{ selectedVaccine.vaccine_name }}
          </h3>
          <p class="text-lg mb-4">
            <strong>Age Recommendations:</strong>
            {{ selectedVaccine.recommended_age }}
          </p>
          <p class="text-lg mb-4">
            <strong>Description:</strong> {{ selectedVaccine.description }}
          </p>
          <p class="text-lg mb-4">
            <strong>Disease Prevented:</strong>
            {{ selectedVaccine.disease_prevented }}
          </p>
          <p class="text-lg mb-4">
            <strong>Dosage:</strong> {{ selectedVaccine.dosage }}
          </p>
          <p class="text-lg mb-4">
            <strong>Administration Method:</strong>
            {{ selectedVaccine.administration_method }}
          </p>

          <p class="text-lg mb-6">
            <strong>Learn More:</strong>
            <a
              :href="selectedVaccine.sourceLink"
              target="_blank"
              class="text-[#04A699] hover:underline"
            >
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

<script>
import LandingsLayout from "@/components/landingsLayout.vue";

export default {
  name: 'Vaccinations',
  components: {
    LandingsLayout,
  },
  data() {
    return {
      searchQuery: '',
      sortBy: 'name',
      selectedVaccine: null,
      vaccines: []
    };
  },
  mounted() {
    this.fetchVaccines();
  },
  methods: {
    async fetchVaccines() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/vaccines", {
          headers: {
            "Authorization": `Bearer ${localStorage.getItem('token')}`
          }
        });
        const data = await response.json();
        this.vaccines = data.vaccines;
      } catch (error) {
        console.error("Error fetching vaccines:", error);
      }
    },
    openDetails(vaccine) {
      this.selectedVaccine = vaccine;
    },
    addToCalendar(vaccine) {
      alert(`Added ${vaccine.vaccine_name} to your calendar.`);
    },
    downloadRecord(vaccine) {
      alert(`Downloading ${vaccine.vaccine_name} record as PDF.`);
    }
  }
};
</script>
