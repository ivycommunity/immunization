<template>
    <div class="signin-form">
      <form @submit.prevent="handleSubmit">
        <div>
          <label for="email">Email</label>
          <input v-model="email" type="email" id="email" placeholder="Enter your email" />
          <span v-if="errors.email" class = "text-[#EB5858]">{{ errors.email }}</span>
        </div>
        <div>
          <label for="password">Password</label>
          <input v-model="password" type="password" id="password" placeholder="Enter your password" />
          <span v-if="errors.password" class = "text-[#EB5858]">{{ errors.password }}</span>
        </div>
        <button type="submit">Sign In</button>
      </form>
    </div>
  </template>
  
  <script>
  import { z } from 'zod';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
        errors: {
          email: null,
          password: null,
        },
      };
    },
    methods: {
      // Handle the form submission
      handleSubmit() {
        // Define the Zod schema for email and password
        const signInSchema = z.object({
          email: z
            .string()
            .email('Invalid email address') // Validates email format
            .nonempty('Email is required'), // Ensures email is not empty
          password: z
            .string()
            .min(6, 'Password must be at least 6 characters') // Password length validation
            .nonempty('Password is required'), // Ensures password is not empty
        });
  
        // Validate the data using Zod
        const result = signInSchema.safeParse({
          email: this.email,
          password: this.password,
        });
  
        if (result.success) {
          this.errors = { email: null, password: null };
          // Form is valid, proceed with the sign-in process (e.g., call an API)
          console.log('Form data is valid:', result.data);
          // Proceed with login logic here...
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
  
  <style scoped>
  .error {
    color: red;
    font-size: 12px;
  }
  </style>
  


   <!-- <template>
    <div class="signin-form">
      <form @submit.prevent="handleSubmit">
        <div>
          <label for="email">Email</label>
          <input class = "outline outline-[#EDECF4]" v-model="email" type="email" id="email" placeholder="Enter your email" />
          <span v-if="errors.email" class = "text-[#EB5858]">{{ errors.email }}</span>
        </div>
        <div>
          <label for="password">Password</label>
          <input class = "outline outline-[]" v-model="password" type="password" id="password" placeholder="Enter your password" />
          <span v-if="errors.password" class = "text-[#EB5858]">{{ errors.password }}</span>
        </div>
        <button class = "text-[#7B6BA8]" type="submit" :disabled="isLoading">Sign In</button>
        <div v-if="isLoading">Loading...</div>
      </form>
    </div>
  </template>
  
  <script>
  // Import Zod and Axios
  import { z } from 'zod';
  import axios from 'axios';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
        errors: {
          email: null,
          password: null,
        },
        isLoading: false,  // To show a loading state while submitting
      };
    },
    methods: {
      // Handle form submission
        async handleSubmit() {
            // Define the Zod schema for email and password
            const signInSchema = z.object({
            email: z
                .string()
                .email('Invalid email address') // Validates email format
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
                const response = await axios.post('https://your-api-url.com/signin', {
                    email: this.email,
                    password: this.password,
                });
                
                // Handle successful API response (e.g., save the token, redirect the user, etc.)
                console.log('API Response:', response.data);
                // Example: Save token, redirect, or show success message
            } catch (error) {
                // Handle API error
                console.error('API Error:', error.response ? error.response.data : error.message);
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
  
  <style scoped>
  
  </style> -->
  