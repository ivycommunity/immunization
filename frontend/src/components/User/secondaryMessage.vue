<template>
    <div v-if="message" class="text-center text-[#82799D]">
      {{ message }}
      <a 
        v-if="action && to" 
        :href="to" 
        class="text-[#432C81] font-medium"
      >
        {{ action.charAt(0).toUpperCase() + action.slice(1) }}
      </a>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    message: {
      type: String,
      default: '',
    },
    action: {
      type: String,
      default: '',
    },
    to: {
      type: String,
      default: '',
    },
  });
  </script>