<script>
  import { z } from 'zod';
  import axios from 'axios';
  
  export default {
    name: 'userSignInForm',
    data() {
      return {
        email: '',
        password: '',
        errors: {
          email: null,
          password: null,
        },
        isLoading: false,  // To show a loading state while submitting
        showPassword: false, // To toggle password visibility
      };
    },
    methods: {
        // Toggle password visibility
        togglePassword() {
            this.showPassword = !this.showPassword;
            const passwordInput = document.getElementById('password');
            if (this.showPassword) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        },
      // Handle form submission
        async handleSubmit() {
            // Define the Zod schema for email and password
            const signInSchema = z.object({
            email: z
                .string()
                .email('Please enter your email address') // Validates email format
                .nonempty('Please enter your email address'), // Ensures email is not empty
            password: z
                .string()
                .min(6, 'Password must be at least 6 characters') // Password length validation
                .nonempty('Please enter your password'), // Ensures password is not empty
            });
    
            // Validate the data using Zod
            const result = signInSchema.safeParse({
            email: this.email,
            password: this.password,
            });
    
            if (result.success) {
            this.errors = { email: null, password: null };
            this.isLoading = true; // Show loading indicator while submitting
    
            // If validation passes, send data to API using Axios
            try {
              console.log(
                'Email:', this.email,
                'Password', this.password
              );
                // const response = await axios.post('https://your-api-url.com/signin', {
                //     email: this.email,
                //     password: this.password,
                // });
                
                // // Handle successful API response (e.g., save the token, redirect the user, etc.)
                // console.log('API Response:', response.data);
                // // Example: Save token, redirect, or show success message
                
                this.$router.push({ name: 'home' });

            } catch (error) {
                // Handle API error
                
                console.error('API Error:', error.response ? error.response.data : error.message);

                this.$router.push({ name: 'registrationError' }); 
                // You can set specific error messages here if needed
            } finally {
                this.isLoading = false; // Hide loading indicator once the request is complete
            }
            } else {
            // If validation fails, set error messages
            this.errors = {
                email: result.error.errors.find((err) => err.path[0] === 'email')?.message || null,
                password: result.error.errors.find((err) => err.path[0] === 'password')?.message || null,
            };
            console.log('Validation errors:', this.errors);
            }
        },
    },
  };
</script>

<template>
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
                    focus:outline-none focus:ring-2 focus:ring-[#432C81]"
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
</template>

