<template>
  <nav
    :class="`fixed top-0 w-full bg-[#F8F8FF] z-50 shadow-md flex justify-between items-center px-6 py-4 transition-all duration-300 ${
      isVisible ? 'translate-y-0 opacity-100 shadow-lg' : '-translate-y-full opacity-0'
    }`"
  >
    <!-- Logo -->
    <router-link to="/" class="z-10">
      <img
        src="@/assets/images/logo.png"
        alt="IVY Logo"
        class="w-12 sm:w-16 md:w-18 lg:w-20"
      />
    </router-link>

    <!-- Mobile Menu Toggle Button -->
    <button
      class="md:hidden text-2xl bg-transparent border-none cursor-pointer text-[#121212]"
      @click="toggleMenu"
      aria-label="Toggle navigation"
    >
      &#9776;
    </button>

    <!-- Navigation Links -->
    <div
      :class="`
        md:flex md:items-center md:static absolute top-full left-0 w-full bg-[#F8F8FF] md:w-auto md:shadow-none shadow-md
        ${isOpen ? 'flex flex-col' : 'hidden'}
      `"
    >
      <router-link
        to="/"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
      >
        Home
      </router-link>
      <router-link
        to="/about-us"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
      >
        About Us
      </router-link>
      <router-link
        to="/contact-us"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
      >
        Contact Us
      </router-link>
      <router-link
        to="/vaccinations"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
      >
        Vaccinations
      </router-link>
      <router-link
        to="/clinics"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
      >
        Clinics Near You
      </router-link>
      <router-link
        to="/questions"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
      >
        FAQ
      </router-link>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

// Reactive state
const isOpen = ref(false);
const isVisible = ref(true);
const lastScrollY = ref(0);

// Toggle mobile menu
const toggleMenu = () => {
  isOpen.value = !isOpen.value;
};

// Handle scroll event
const handleScroll = () => {
  const currentScrollY = window.scrollY;

  if (currentScrollY > lastScrollY.value) {
    isVisible.value = false; // Hide navbar when scrolling down
  } else {
    isVisible.value = true; // Show navbar when scrolling up
  }

  lastScrollY.value = currentScrollY;
};

// Add and remove scroll event listener
onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>