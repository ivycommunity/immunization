<template>
    <nav
      :class="`fixed top-0 w-full bg-[#F8F8FF] z-50 shadow-md flex justify-between items-center px-6 py-4 transition-all duration-300 ${
        isVisible ? 'translate-y-0 opacity-100 shadow-lg' : '-translate-y-full opacity-0'
      }`"
    >
      <div class="flex gap-8 w-full">
        <router-link to="/user" class="z-10">
          <ArrowLeftIcon class="w-6 h-6 text-[#432C81]" />
        </router-link>
  
        <div class="w-full">
          <h2 class="text-2xl font-bold text-[#432C81]">{{ title }}</h2>
        </div>
      </div>
    </nav>
  </template>
  
  <script>
  import { ArrowLeftIcon } from "@heroicons/vue/24/solid"; // or "@heroicons/vue/24/outline"
  
  export default {
    name: "Topbar",
    components: {
      ArrowLeftIcon,
    },
    props: {
      title: {
        type: String,
        required: true,
      },
    },
    data() {
      return {
        isOpen: false,
        isVisible: true,
        lastScrollY: 0,
      };
    },
    methods: {
      toggleMenu() {
        this.isOpen = !this.isOpen;
      },
      handleScroll() {
        const currentScrollY = window.scrollY;
  
        const threshold = window.innerHeight * 0.1;
        this.isVisible = currentScrollY > threshold;
  
        this.lastScrollY = currentScrollY;
      },
    },
    mounted() {
      window.addEventListener("scroll", this.handleScroll);
    },
    beforeUnmount() {
      window.removeEventListener("scroll", this.handleScroll);
    },
  };
  </script>
  