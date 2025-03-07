<template>
  <nav
    :class="`fixed top-0 w-full bg-[#F8F8FF] z-50 shadow-md flex justify-between items-center px-6 py-4 transition-all duration-300 ${
      isVisible ? 'translate-y-0 opacity-100 shadow-lg' : '-translate-y-full opacity-0'
    }`"
  >
    <div class="flex gap-8">
      <router-link to="/user" class="z-10">
        <ArrowLeftIcon class="w-6 h-6 text-[#432C81]" />
      </router-link>

      <div class="w-full">
        <h2 class="text-2xl font-bold text-[#432C81]">{{ title }}</h2>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { ArrowLeftIcon } from '@heroicons/vue/24/solid'; // or "@heroicons/vue/24/outline"

// Props
const props = defineProps({
  title: {
    type: String,
    required: false,
  },
  move:{
    type: Boolean,
    required: false,
    default: true
  },
  withBackArrow: {
    type: Boolean,
    required: false,
    default: true,
  },
});

// Reactive state
const isVisible = ref(false);
const lastScrollY = ref(0);

// Handle scroll event
const handleScroll = () => {
  const currentScrollY = window.scrollY;
  if (props.move){
    const threshold = window.innerHeight * 0.15;
    isVisible.value = currentScrollY > threshold;
  }else{
    isVisible.value = true;
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