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

// Update email/phone_number based on input
const updateField = () => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const phoneRegex = /^\+?\d{10,15}$/;

  if (emailRegex.test(identifier.value)) {
    email.value = identifier.value;
    phone_number.value = '';
  } else if (phoneRegex.test(identifier.value)) {
    phone_number.value = identifier.value;
    email.value = '';
  } else {
    email.value = '';
    phone_number.value = '';
  }
};

// Handle form submission
const handleSubmit = async () => {
  // Define the Zod schema
  const registrationSchema = z
    .object({
      email: z.string().email('Please enter a valid email address').optional(),
      phone_number: z
        .string()
        .regex(/^\+?\d{10,15}$/, 'Invalid phone number')
        .optional(),
      password: z
        .string()
        .min(6, 'Password must be at least 6 characters')
        .nonempty('Please enter your password'),
    })
    .refine((data) => data.email || data.phone_number, {
      message: 'Either email or phone number is required',
      path: ['identifier'],
    });

  // Validate the data
  const result = registrationSchema.safeParse({
    email: email.value,
    phone_number: phone_number.value,
    password: password.value,
  });

  if (result.success) {
    errors.value = { identifier: null, password: null };
    isLoading.value = true;

    try {
      console.log('Email:', email.value, 'Phone:', phone_number.value, 'Password:', password.value);
      // API call
      const response = await axios.post('/api/login', {
        email: email.value || null,
        phone_number: phone_number.value || null,
        password: password.value,
      });
      console.log('API Response:', response.data);

      router.push({ name: 'userhomePage' });
    } catch (error) {
      console.error('API Error:', error.response ? error.response.data : error.message);
      router.push(`/user/error/${error.response ? error.response.status : '500'}`);
    } finally {
      isLoading.value = false;
    }
  } else {
    // Set error messages
    errors.value = {
      identifier: result.error.errors.find((err) => err.path[0] === 'identifier')?.message || null,
      password: result.error.errors.find((err) => err.path[0] === 'password')?.message || null,
    };
    console.log('Validation errors:', errors.value);
  }
};
</script>

<template>
  <userRegistrationLayout topBartitle="register">
    <div class="flex flex-wrap items-center justify-between h-dvh p-6 box-border bg-white">
      <!-- Header Section -->
      <div class="w-full text-center mb-4">
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#432C81]">Login</h2>
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
          <!-- Email Field -->
          <div class="flex flex-col gap-1">
            <input
            v-model="identifier"
            @input="updateField"
            type="text"
            id="identifier"
            placeholder="Enter your email or phone number"
            class="w-full px-4 py-3 rounded-lg border border-[#EDECF4] 
                  text-[#432C81] placeholder-[#82799D] 
                  focus:outline-none focus:ring-2 focus:ring-[#432C81] 
                  focus:text-[#432C81]"
          />

          <!-- Hidden fields -->
          <input type="hidden" name="email" :value="email" />
          <input type="hidden" name="phone_number" :value="phone_number" />
            <span v-if="errors.email" class="text-[#EB5858] text-sm ml-2">{{ errors.email }}</span>
          </div>
          <!-- Password Field -->
          <div class="flex flex-col gap-1">
            <div class="relative w-full">
              <input 
                v-model="password" 
                :type="showPassword ? 'text' : 'password'"
                id="password" 
                placeholder="Enter your password" 
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
                <img 
                  v-if="showPassword"
                  src="@/assets/userI/icons/eye-crossed1.svg"
                  alt="Hide password"
                  class="h-5 w-5"
                  style="filter: invert(50%) sepia(20%) saturate(500%) hue-rotate(200deg) brightness(90%) contrast(90%);"
                >
                <img 
                  v-else
                  src="@/assets/userI/icons/eye1.svg"
                  alt="Show password"
                  class="h-5 w-5"
                  style="filter: invert(50%) sepia(20%) saturate(500%) hue-rotate(200deg) brightness(90%) contrast(90%);"
                >
              </button>
              <span v-if="errors.password" class="text-[#EB5858] text-sm ml-2">{{ errors.password }}</span>
              <!-- Label & Forgot Password Link -->
              <div class="flex justify-between items-center mt-2">
                <span></span>
                <a href="#" class="text-sm text-[#432C81]">Forgot Password?</a>
              </div>
            </div>
          </div>
          
          <!-- Login Button -->
          <button 
            type="submit" 
            :disabled="isLoading"
            class="bg-[#432C81] text-white py-3 px-6 rounded-full font-medium hover:bg-opacity-90 transition-colors"
          >
            Login
          </button>
          
          <!-- Loading Indicator -->
          <div v-if="isLoading" class="text-center text-[#432C81]">Loading...</div>
          
          <!-- Sign Up Link -->
          <div class="text-center text-[#82799D]">
            Don't have an account? <a href="#" class="text-[#432C81] font-medium">Sign Up</a>
          </div>
        </form>
      </div>
    </div>
  </userRegistrationLayout>
</template>

