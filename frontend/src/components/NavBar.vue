<template>
  <nav :class="`fixed top-0 w-full bg-[#F8F8FF] z-50 shadow-md flex justify-between items-center px-6 py-4 transition-all duration-300 ${
      isVisible ? 'translate-y-0 opacity-100 shadow-lg' : '-translate-y-full opacity-0'
      }`">

    <router-link to="/" class="z-10">
      <img src="@/assets/images/logo.png" alt="IVY Logo" class="w-[80px]" />
    </router-link>

    <button class="md:hidden text-2xl bg-transparent border-none cursor-pointer text-[#F8F8FF]" @click="toggleMenu"
      aria-label="Toggle navigation">
      &#9776;
    </button>


    <div :class="`
          md:flex md:items-center md:static absolute top-full left-0 w-full bg-[#F8F8FF] md:w-auto md:shadow-none shadow-md
          ${isOpen ? 'flex flex-col' : 'hidden'}
        `">
      <router-link to="/"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
        exact-active-class="text-green-700 font-bold">
        Home
      </router-link>

      <router-link to="/about-us"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
        exact-active-class="text-green-700 font-bold">
        About Us
      </router-link>
      <router-link to="/contact-us"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
        exact-active-class="text-green-700 font-bold">
        Contact Us
      </router-link>
      <router-link to="/vaccinations"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
        exact-active-class="text-green-700 font-bold">
        Vaccinations
      </router-link>
      <router-link to="/clinics"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
        exact-active-class="text-green-700 font-bold">
        Clinics Near You
      </router-link>
      <router-link to="/questions"
        class="text-[#121212] hover:text-[#04A699] text-sm md:ml-6 md:my-0 py-2.5 px-5 border-b border-[#02343B] md:border-none"
        exact-active-class="text-green-700 font-bold">
        FAQ
      </router-link>
    </div>
  </nav>
</template>
  
  <script>
  export default {
    name: 'Navbar',
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
  
        if (currentScrollY > this.lastScrollY) {
          this.isVisible = false;
        } else {
          this.isVisible = true;
        }
  
        this.lastScrollY = currentScrollY;
      },
    },
    mounted() {
      window.addEventListener('scroll', this.handleScroll);
    },
    beforeUnmount() {
      window.removeEventListener('scroll', this.handleScroll);
    },
  };
  </script>