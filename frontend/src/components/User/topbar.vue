<template>
  <nav
    :class="`fixed top-0 w-full bg-white shadow-md z-50 flex justify-between items-center px-6 py-4 transition-all duration-300 ${
      isVisible ? 'translate-y-0 opacity-100' : '-translate-y-full opacity-0'
    }`"
  >
    <div class="flex items-center gap-8">
      <!-- Back Arrow -->
      <router-link v-if="backTo && backTo.trim() !== ''" :to="backTo" class="z-10">
        <ArrowLeftIcon class="w-6 h-6 text-[#432C81]" />
      </router-link>

      <!-- Dynamic Title -->
      <h2 v-if="!!title" class="text-2xl font-bold text-[#432C81] md:text-3xl xl:text-4xl">{{ title }}</h2>
      <h2 v-else class="text-2xl font-bold text-[#432C81] md:text-3xl xl:text-4xl">{{ `👋🏻 Hi, ${props.user.first_name}` }}</h2>
    </div>

    <!-- Avatar Section -->
    <div v-if="user && !title" 
      class="flex rounded-full items-center gap-4"
      @click="$router.push('/user/profile')"
    >
      <div v-if="user.avatar" class="w-10 h-10">
        <img
          :src="user.avatar"
          alt="User Avatar"
          class="w-full h-full rounded-full border-2 border-[#432C81]"
        />
      </div>
      <div
        v-else
        class="w-10 h-10 flex items-center justify-center rounded-full text-white font-bold border-2 border-[#432C81]"
        :style="{ backgroundColor: randomDarkColor }"
      >
        {{ user.first_name.charAt(0).toUpperCase() }}
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue';
import { ArrowLeftIcon } from '@heroicons/vue/24/solid';

// Props
const props = defineProps({
  title: String,
  move: {
    type: Boolean,
    default: true,
  },
  backTo: {
    type: String,
    default: "",
  },
  user: {
    type: Object,
    default: null,
  },
});

// Compute title dynamically
// const dynamicTitle = computed(() => (props.user ? `👋🏻 Hi, ${props.user.first_name}` : props.title));


// // Reactive state
// const isVisible = ref(!props.move);

// const handleScroll = () => {
//   if (!props.move) return;
//   const threshold = window.innerHeight * 0.15;
//   isVisible.value = window.scrollY > threshold;
// };

const isVisible = ref(!props.move);
let lastScrollY = 0;

const handleScroll = () => {
  if (!props.move) return;
  
  const currentScrollY = window.scrollY;
  const threshold = window.innerHeight * 0.15;
  // Show navbar when scrolling up or at the top
  if (currentScrollY <= 0 || currentScrollY < lastScrollY) {
    isVisible.value = false;
  } 
  // Hide navbar only when scrolling down and past threshold
  else if (currentScrollY > lastScrollY && currentScrollY > threshold) {
    isVisible.value = true;
  }
  
  lastScrollY = currentScrollY;
};

// Add and remove scroll event listener
onMounted(() => {
  if (props.move) {
    window.addEventListener('scroll', handleScroll);
  } else {
    isVisible.value = true;
  }
});

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
});

const randomDarkColor = computed(() => {
  const colors = ["#1D1B31", "#2C2A4A", "#3D3B60", "#25233D", "#282846"]; // Add more dark colors
  return colors[Math.floor(Math.random() * colors.length)];
});

</script>
