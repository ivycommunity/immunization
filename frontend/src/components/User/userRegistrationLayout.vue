<template>
    <div class="default-layout">
      <Topbar :title="topBartitle" />
      <main>
        <slot></slot>
      </main>
    </div>
  </template>
  
  <script setup>
  import Topbar from '@/components/User/topbar.vue';
  
  // Props
  const props = defineProps({
    topBartitle: {
      type: String,
      default: 'IVY Immunization',
    },
  });
  </script>