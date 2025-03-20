<template>
  <userLayout>
  <div class="flex flex-wrap items-center justify-between p-6 box-border bg-white">
    <!-- Header Section -->
    <div class="w-full text-center mb-4">
      <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#432C81]">
        Welcome to
      </h2>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#432C81]">
        IVY Immunization
      </h2>
    </div>
    
    <!-- Image Section -->
    <div class="w-full max-w-md mx-auto mb-8">
      <img 
        src="@/assets/userI/group1.png" 
        alt="People illustrations" 
        class="w-full h-auto object-contain"
      >
    </div>
    
    <!-- Buttons Section -->
    <div class="w-full flex flex-col gap-6 max-w-md mx-auto">
      <router-link
        :href="{name: 'signin'}"
        class="bg-[#432C81] text-center text-white py-3 px-6 rounded-lg font-medium hover:bg-opacity-90 transition-colors"
      >
        Get Started
      </router-link>
      <!-- Sign Up Link -->
      <div class="text-center text-[#82799D]">
        First time? <a href="/user/register" class="text-[#432C81] font-medium">Register</a>
      </div>
    </div>
  </div>
</userLayout>
</template>

<script setup>
import userLayout from '@/components/User/userLayout.vue';
</script>