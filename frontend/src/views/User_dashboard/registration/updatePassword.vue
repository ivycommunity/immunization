<script setup>
import { ref } from 'vue';
import { z } from 'zod';
import axios from 'axios';
import { useRouter } from 'vue-router';
import userRegistrationLayout from '@/components/User/userRegistrationLayout.vue';
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";

// Reactive state
const confirmPassword = ref('');
const password = ref('');
const errors = ref({
  password: null,
  confirmPassword: null,
});
const showPassword = ref(false);
const isLoading = ref(false);

const router = useRouter();

// Toggle password visibility
const togglePassword = () => {
  showPassword.value = !showPassword.value;
};


const handleSubmit = async () => {
  // Define the Zod schema
  const registrationSchema = z
    .object({
      password: z
        .string()
        .min(6, 'ID number must be at least 6 characters')
        .nonempty('Please enter your your Password'),
    })

  // Validate the data
  const result = registrationSchema.safeParse({
    password: password.value,
  });

  if (result.success) {
    errors.value = { confirmPassword: null, password: null };
    isLoading.value = true;

    try {
      console.log('Password:', password.value, 'Confirm Password:', confirmPassword.value);
      
      // API call
      
      // const response = await axios
      //   .create({
      //       baseURL:'/api',
      //       withCredentials: true,
      //   })
      //   .put('/register/updatePassword', {
      //       password: password.value,
      //   });
        
      console.log('API Response:', response.data); // recieve a password updated successfully message

      router.push({ name: 'userLogin' });
    } catch (error) {
      console.error('API Error:', error.response ? error.response.data : error.message);
      router.push(`/user/error/${error.response ? error.response.status : '500'}`);
    } finally {
      isLoading.value = false;
    }
  } else {
    
    // Set error messages
    errors.value = {
      password: result.error.errors.find((err) => err.path[0] === 'password')?.message || null,
      confirmPassword: result.error.errors.find((err) => err.path[0] === 'confirmPassword')?.message || null,
    };
    console.log('Validation errors:', errors.value);
  }
};
</script>

<template>
  <userRegistrationLayout topBartitle="Change Password">
    <div class="flex flex-wrap items-center justify-between box-border bg-white">
      <!-- Header Section -->
      <div class="w-full text-center mb-4">
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#432C81]">Change Password</h2>
      </div>
      
      <!-- Image Section -->
      <div class="w-full max-w-md mx-auto mb-8">
        <img 
          src="@/assets/userI/group1.png" 
          alt="People illustrations" 
          class="w-full h-auto object-contain"
        >
      </div>

      <!-- Form Section -->
      <div class="w-full max-w-md mx-auto">
        <form @submit.prevent="handleSubmit" class="flex flex-col gap-6">
          <!-- Password Field -->
          <div class="flex flex-col gap-1">
            <div class="relative w-full">
              <input 
                v-model="password" 
                :type="showPassword ? 'text' : 'password'"
                id="password" 
                placeholder="Create a passeword" 
                class="w-full px-4 py-3 rounded-lg border border-[#EDECF4] 
                    text-[#432C81] placeholder-[#82799D]
                    focus:outline-none focus:ring-2 focus:ring-[#432C81]"
              />
              <!-- Password Toggle Button -->
              <button 
                type="button" 
                @click="togglePassword"
                class="absolute right-4 top-1/3 transform -translate-y-1/2 text-secondary"
                aria-label="Toggle password visibility"
              >
                <EyeSlashIcon 
                  v-if="showPassword" 
                  class="h-5 w-5 text-gray-500"
                />
                <EyeIcon 
                  v-else 
                  class="h-5 w-5 text-gray-500"
                />
              </button>
              <span v-if="errors.password" class="text-[#EB5858] text-sm ml-2">{{ errors.password }}</span>
            </div>
          </div>

          <!-- Password Field -->
          <div class="flex flex-col gap-1">
            <div class="relative w-full">
              <input 
                v-model="confirmPassword" 
                :type="showPassword ? 'text' : 'password'"
                id="password" 
                placeholder="Confirm your password" 
                class="w-full px-4 py-3 rounded-lg border border-[#EDECF4] 
                    text-[#432C81] placeholder-[#82799D]
                    focus:outline-none focus:ring-2 focus:ring-[#432C81]"
              />
              <!-- Password Toggle Button -->
              <button 
                type="button" 
                @click="togglePassword"
                class="absolute right-4 top-1/3 transform text-secondary"
                aria-label="Toggle password visibility"
              >
                <EyeSlashIcon 
                  v-if="showPassword" 
                  class="h-5 w-5 text-gray-500"
                />
                <EyeIcon 
                  v-else 
                  class="h-5 w-5 text-gray-500"
                />
              </button>
              <span v-if="errors.password" class="text-[#EB5858] text-sm ml-2">{{ errors.password }}</span>
            </div>
          </div>
          
          <!-- Submit Button -->
          <button 
            type="submit" 
            :disabled="isLoading"
            class="bg-[#432C81] text-white py-3 px-6 rounded-lg font-medium hover:bg-opacity-90 transition-colors"
          >
            Save
          </button>
          
          <!-- Loading Indicator  later use a proper animation in the login button-->
          <div v-if="isLoading" class="text-center text-[#432C81]">Loading...</div> 
        </form>
      </div>
    </div>
  </userRegistrationLayout>
</template>

