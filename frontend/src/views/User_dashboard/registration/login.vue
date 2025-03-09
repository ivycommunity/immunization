<script setup>
import { ref } from 'vue';
import { z } from 'zod';
import axios from 'axios';
import { useRouter } from 'vue-router';
import userRegistrationLayout from '@/components/User/userRegistrationLayout.vue';
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";

// Reactive state
const identifier = ref('');
const email = ref('');
const phone_number = ref('');
const password = ref('');
const errors = ref({
  identifier: null,
  password: null,
});
const showPassword = ref(false);
const isLoading = ref(false);

const router = useRouter();

// Toggle password visibility
const togglePassword = () => {
  showPassword.value = !showPassword.value;
};

// Update email/phone_number based on input with validation
const updateField = () => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const phoneRegex = /^\+?\d{10,15}$/;

  if (emailRegex.test(identifier.value)) {
    email.value = identifier.value;
    phone_number.value = '';
    errors.value.identifier = null; // Clear error when valid
  } else if (phoneRegex.test(identifier.value)) {
    phone_number.value = identifier.value;
    email.value = '';
    errors.value.identifier = null; // Clear error when valid
  } else {
    email.value = '';
    phone_number.value = '';
    // Set a real-time validation error if there's input
    if (identifier.value) {
      errors.value.identifier = "Please enter a valid email or phone number";
    } else {
      errors.value.identifier = null; // Clear error on empty field
    }
  }
};

// Handle form submission
const handleSubmit = async () => {
  // First, validate the identifier format
  updateField();
  
  // If identifier is empty, set an error
  if (!identifier.value) {
    errors.value.identifier = "Please enter your email or phone number";
  }
  
  // If password is empty, set an error
  if (!password.value) {
    errors.value.password = "Please enter your Password";
  } else if (password.value.length < 6) {
    errors.value.password = "Password must be at least 6 characters";
  } else {
    errors.value.password = null;
  }

  // Only proceed if there are no errors
  if (!errors.value.identifier && !errors.value.password) {
    isLoading.value = true;

    try {
      console.log('Email:', email.value, 'Phone:', phone_number.value, 'Password:', password.value);
      // API call - commented out for now
      
      const response = await axios
        .create({
          baseURL:'/api',
          withCredentials: true,
        })
        .post('/login', {
          email: email.value || null,
          phone_number: phone_number.value || null,
          password: password.value,
        });
      
      console.log('API Response:', response.data); // later use pinia to store user data
      

      router.push({ name: 'userHomePage' });
    } catch (error) {
      console.error('API Error:', error.response ? error.response.data : error.message);
      router.push(`/user/error/${error.response ? error.response.status : '500'}`);
    } finally {
      isLoading.value = false;
    }
  } else {
    console.log('Validation errors:', errors.value);
  }
};
</script>

<template>
  <userRegistrationLayout topBartitle="Login">
    <div class="flex flex-wrap items-center justify-between box-border bg-white">
      <!-- Header Section -->
      <div class="w-full text-center mb-4">
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#432C81]">Login</h2>
      </div>
      
      <!-- Image Section -->
      <div class=" max-w-md mx-auto mb-8">
        <img 
          src="@/assets/userI/group1.png" 
          alt="People illustrations" 
          class="h-auto object-contain"
        >
      </div>

      <!-- Form Section -->
      <div class="w-full max-w-md mx-auto">
        <form @submit.prevent="handleSubmit" class="flex flex-col gap-6">
          <!-- Email Field -->
          <div class="flex flex-col gap-1">
            <input
              v-model="identifier"
              @input="updateField"
              type="text"
              id="identifier"
              placeholder="Email or phone number"
              class="w-full px-4 py-3 rounded-lg border border-[#EDECF4] 
                    text-[#432C81] placeholder-[#82799D] 
                    focus:outline-none focus:ring-2 focus:ring-[#432C81] 
                    focus:text-[#432C81]"
            />

            <!-- Hidden fields -->
            <input type="hidden" name="email" :value="email" />
            <input type="hidden" name="phone_number" :value="phone_number" />
            
            <span v-if="errors.identifier" class="text-[#EB5858] text-sm ml-2">{{ errors.identifier }}</span>
          </div>
          
          <!-- Password Field -->
          <div class="flex flex-col gap-1">
            <div class="relative w-full">
              <input 
                v-model="password" 
                :type="showPassword ? 'text' : 'password'"
                id="password" 
                placeholder="Password" 
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
            </div>
            <span v-if="errors.password" class="text-[#EB5858] text-sm ml-2">{{ errors.password }}</span>
            <!-- Label & Forgot Password Link -->
            <div class="flex justify-between items-center mt-2">
              <span></span>
              <router-link to="#" class="text-sm text-[#432C81]">Forgot Password?</router-link>
            </div>
          </div>
          
          <!-- Login Button -->
          <button 
            type="submit" 
            :disabled="isLoading"
            class="bg-[#432C81] text-white py-3 px-6 rounded-lg font-medium hover:bg-opacity-90 transition-colors"
          >
            Login
          </button>
          
          <!-- Loading Indicator -->
          <div v-if="isLoading" class="text-center text-[#432C81]">Loading...</div>
          
          <!-- Sign Up Link -->
          <div class="text-center text-[#82799D]">
            First time? <a href="/user/register" class="text-[#432C81] font-medium">Register</a>
          </div>
        </form>
      </div>
    </div>
  </userRegistrationLayout>
</template>