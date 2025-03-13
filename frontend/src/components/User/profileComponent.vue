<script setup>
import { PencilIcon } from '@heroicons/vue/24/solid'
import { ref } from "vue";

const img = ref("");

const props = defineProps({
  imgPath: {
    type: String,
    default: ""
  },
  userFullName: {
    type: String,
    required: true
  },
  userEmail: {
    type: String,
    required: true
  },
})

const handlePictureChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      img.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
}
</script>

<template>
  <div class="max-w-md mx-auto p-4 flex flex-col items-center">
    <!-- Profile image with edit button -->
    <div class="relative">
      <!-- Profile image container with purple background -->
      <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center">
        <div class="w-28 h-28 rounded-full bg-purple-700 flex items-center justify-center overflow-hidden">
          <!-- User avatar image -->
          <div v-if="img || imgPath">
            <div class="w-28 h-28 rounded-full bg-purple-700 flex items-center justify-center overflow-hidden">
              <!-- Using an actual image tag -->
              <img 
                :src="img || imgPath"
                :alt="userFullName + ' profile picture'"
                class="w-full h-full object-cover"
              />
            </div>
          </div>
          <div v-else class="flex flex-col items-center justify-end h-full w-full pt-2">
            <!-- Simplified avatar illustration -->
            <div class="w-16 h-16 bg-orange-300 rounded-full relative mb-2">
              <!-- Simple face -->
              <div class="absolute right-3 bottom-2 w-2 h-2 border-b-2 border-black rounded-full transform rotate-12"></div>
            </div>
            <!-- Shirt/clothing -->
            <div class="w-20 h-10 bg-blue-200 border-t border-blue-300"></div>
          </div>
        </div>
      </div>
      
      <!-- Edit button -->
      <label for="fileInput" class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-md cursor-pointer">
        <PencilIcon class="h-5 w-5 text-purple-800" />
        <input 
          id="fileInput" 
          type="file" 
          accept="image/*" 
          class="hidden" 
          @change="handlePictureChange"
        />
      </label>
    </div>
    
    <!-- User name -->
    <h1 class="mt-6 text-2xl font-bold text-purple-900">{{ userFullName }}</h1>
    
    <!-- User email -->
    <p class="mt-2 text-gray-500">{{ userEmail }}</p>
  </div>
</template>