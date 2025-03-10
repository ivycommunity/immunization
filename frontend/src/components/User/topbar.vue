<template>
  <nav
    :class="`fixed top-0 w-full bg-[#F8F8FF] z-50 flex justify-between items-center px-6 py-4 transition-all duration-300 ${
      isVisible ? 'translate-y-0 opacity-100' : '-translate-y-full opacity-0'
    }`"
  >
    <div class="flex items-center gap-8">
      <!-- Back Arrow -->
      <router-link v-if="backTo" to="/user" class="z-10">
        <ArrowLeftIcon class="w-6 h-6 text-[#432C81]" />
      </router-link>

      <!-- Dynamic Title -->
      <h2 class="text-2xl font-bold text-[#432C81] md:text-3xl xl:text-4xl">{{ dynamicTitle }}</h2>
    </div>

    <!-- Avatar Section -->
    <div v-if="user" class="flex items-center gap-4">
      <span class="text-[#432C81] font-medium">{{ user.firstName }}</span>
      <img
        :src="user.avatar"
        alt="User Avatar"
        class="w-10 h-10 rounded-full border-2 border-[#432C81]"
      />
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
  },
  user: {
    type: Object,
    default: null, // Null if no user is logged in
  },
});

// Compute title dynamically
const dynamicTitle = computed(() => (props.user ? `👋🏻 Hi, ${props.user.firstName}` : props.title));

// Reactive state
const isVisible = ref(!props.move);

const handleScroll = () => {
  if (!props.move) return;
  const threshold = window.innerHeight * 0.15;
  isVisible.value = window.scrollY > threshold;
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
</script>
