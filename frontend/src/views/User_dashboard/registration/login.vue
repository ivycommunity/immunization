<script setup>
  import { ref } from 'vue';
  import { z } from 'zod';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  import userRegistrationLayout from '@/components/userRegistrationLayout.vue';
  import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";

  // Reactive state
  const email = ref('');
  const password = ref('');
  const errors = ref({
    email: null,
    password: null,
  });
  const isLoading = ref(false);
  const showPassword = ref(false);

  const router = useRouter();

  // Toggle password visibility
  const togglePassword = () => {
    showPassword.value = !showPassword.value;
    const passwordInput = document.getElementById('password');
    passwordInput.type = showPassword.value ? 'text' : 'password';
  };

  // Handle form submission
  const handleSubmit = async () => {
    // Define the Zod schema for email and password
    const signInSchema = z.object({
      email: z
        .string()
        .email('Please enter your email address')
        .nonempty('Please enter your email address'),
      password: z
        .string()
        .min(6, 'Password must be at least 6 characters')
        .nonempty('Please enter your password'),
    });

    // Validate the data using Zod
    const result = signInSchema.safeParse({
      email: email.value,
      password: password.value,
    });

    if (result.success) {
      errors.value = { email: null, password: null };
      isLoading.value = true;

      try {
        console.log('Email:', email.value, 'Password:', password.value);
        // Example API call (commented out)
        // const response = await axios.post('https://your-api-url.com/signin', {
        //   email: email.value,
        //   password: password.value,
        // });
        // console.log('API Response:', response.data);

        router.push({ name: 'home' });
      } catch (error) {
        console.error('API Error:', error.response ? error.response.data : error.message);
        router.push({ name: 'registrationError' });
      } finally {
        isLoading.value = false;
      }
    } else {
      // If validation fails, set error messages
      errors.value = {
        email: result.error.errors.find((err) => err.path[0] === 'email')?.message || null,
        password: result.error.errors.find((err) => err.path[0] === 'password')?.message || null,
      };
      console.log('Validation errors:', errors.value);
    }
  };
</script>

<template>
  <userRegistrationLayout topBartitle="Login">
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
              v-model="email" 
              type="email" 
              id="email" 
              placeholder="Enter your email" 
              class="w-full px-4 py-3 rounded-lg border border-[#EDECF4] 
                    text-[#432C81] placeholder-[#82799D] 
                    focus:outline-none focus:ring-2 focus:ring-[#432C81] 
                    focus:text-[#432C81]"
            />
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
              <!-- Label & Forgot Password Link -->
              <div class="flex justify-between items-center mt-2">
                <span></span>
                <router-link to="#" class="text-sm text-[#432C81]">Forgot Password?</router-link>
              </div>
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
            Don't have an account? <router-link to="#" class="text-[#432C81] font-medium">Sign Up</router-link>
          </div>
        </form>
      </div>
    </div>
  </userRegistrationLayout>
</template>