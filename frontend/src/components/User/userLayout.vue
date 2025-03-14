<script setup>
import { computed } from 'vue';
import Topbar from './topbar.vue';
import bottomBar from '@/components/User/BottomNavBar.vue';

// Props
const props = defineProps({
  topBartitle: {
    type: String,
  },
  userData: {
    type: Object,
    default: () => ({ first_name: '', avatar: null })
  },
  topBarMove: {
    type: [Boolean, String], // Accept both Boolean and String (from parent)
    default: true,
  },
  bactTo: {
    type:  String, // Accept both Boolean and String (from parent)
  },
  className: {
    type: String,
    default: ""
  },
  withBottomBar: {
    type: Boolean,
    default: false,
  },
});

console.log('Layout received user:', props.userData);

// Ensure boolean conversion (if parent passes as string)
const move = computed(() => props.topBarMove === true || props.topBarMove === 'true');
</script>

<template>
  <div class="default-layout relative h-screen flex flex-col">
    <Topbar :title="topBartitle" :user="userData" :move="move" :back-to="bactTo" class="fixed top-0 left-0 w-full z-10" />
    <main 
      :class="`
          w-full 
          mx-auto
          mt-[44px]
          pt-[8%]
          px-4
          sm:max-w-[475px]
          sm:px-6
          md:max-w-2xl 
          lg:max-w-4xl 
          xl:max-w-6xl 
          2xl:max-w-7xl 
          flex-1
          overflow-y-auto
          scrollbar-hide
          ${props.withBottomBar ? 'pb-16' : ''}
          ${className}`"
      >
      <slot></slot>
    </main>
    <bottomBar v-if="!!withBottomBar" class="fixed bottom-0 left-0 w-full z-10" />
  </div>
</template>

<style scoped>
.default-layout {
  display: flex;
  flex-direction: column;
  height: 100vh;
  overflow: hidden;
}

.scrollbar-hide {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;     /* Firefox */
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;             /* Chrome, Safari and Opera */
}
</style>