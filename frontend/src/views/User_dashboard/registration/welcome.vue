<template>
    <div class="flex flex-wrap items-center justify-between h-dvh p-6 box-border bg-white">
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

      <div class="w-full flex flex-col gap-6 max-w-md mx-auto">
        <a
            href="/user/signin" 
            class="bg-[#432C81] text-center text-white py-3 px-6 rounded-lg font-medium hover:bg-opacity-90 transition-colors"
        >
            Sign In
        </a>
        <a 
            href="/user/login"
            class="text-[#432C81] text-center border border-[#432C81] bg-white py-3 px-6 rounded-lg font-medium hover:bg-opacity-90 transition-colors"
        >
            LogIn
        </a>
      </div>
    </div>
</template>

<script>
  export default {
    name: 'userWelcome',
  }
</script>