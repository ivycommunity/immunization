<script setup>

import { ref } from 'vue';

const props = defineProps({
    vaccine:{
        type: Object,
        required: true
    }
});


const selectedVaccine = ref(null);

const handleShowVaccineDetails = () => {
    selectedVaccine.value = props.vaccine;
};


</script>

<template>
    <div>
        <div class="p-4 rounded-lg bg-white w-full h-full">
            <!-- Header with baby name, dash, and vaccine type -->
            <h3 class="text-lg font-bold text-[#432C81]">
                <div class="grid grid-cols-5 items-center">
                    <div class="col-span-5 truncate">{{ props.vaccine.vaccine_name }}</div>
                </div>
            </h3>
            
            <div class="flex flex-wrap justify-between w-full items-center text-[#432C81]/80">
                <div>recommended Age: {{ props.vaccine.recommended_age }}</div>
                <div>
                    <button key="learn" 
                        class=" bg-purple-300/30 rounded-lg px-4 py-2"
                        @click="handleShowVaccineDetails">
                        Learn More
                    </button>
                </div>
            </div>
        </div>

        <div
            v-if="selectedVaccine"
            class="fixed inset-0 bg-[#432C81]/30 flex items-center justify-center p-6"
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

                <p class="text-lg mb-6" hidden>
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
</template>