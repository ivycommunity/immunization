<script setup>
import { computed } from 'vue';
import Topbar from './topbar.vue';

// Props
const props = defineProps({
  topBartitle: {
    type: String,
    default: 'IVY Immunization',
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
  }
});

console.log('Layout received user:', props.userData);

// Ensure boolean conversion (if parent passes as string)
const move = computed(() => props.topBarMove === true || props.topBarMove === 'true');
</script>

<template>
  <div class="default-layout">
    <Topbar :title="topBartitle" :user="userData" :move="move" :back-to="bactTo" />
    <main :class="`
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
          2xl:max-w-7xl ${className}`">
      <slot></slot>
    </main>
  </div>
</template>
