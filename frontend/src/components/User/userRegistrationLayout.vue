<script setup>
import { defineProps, computed } from 'vue';
import Topbar from './topbar.vue';

// Props
const props = defineProps({
  topBartitle: {
    type: String,
    default: 'IVY Immunization',
  },
  topBarMove: {
    type: [Boolean, String], // Accept both Boolean and String (from parent)
    default: true,
  },
  topBarWithBackArrow: {
    type: [Boolean, String], // Accept both Boolean and String (from parent)
    default: true,
  },
});

// Ensure boolean conversion (if parent passes as string)
const move = computed(() => props.topBarMove === true || props.topBarMove === 'true');
const withBackArrow = computed(() => props.topBarWithBackArrow === true || props.topBarWithBackArrow === 'true');
</script>

<template>
  <div class="default-layout">
    <Topbar :title="topBartitle" :move="move" :with-back-arrow="withBackArrow" />
    <main class="w-full 
          mt-16 sm:mt-20 md:mt-24
          mx-auto 
          px-4
          sm:max-w-[475px]
          sm:px-6
          md:max-w-2xl 
          lg:max-w-4xl 
          xl:max-w-6xl 
          2xl:max-w-7xl">
      <slot></slot>
    </main>
  </div>
</template>
