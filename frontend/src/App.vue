<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useAuthStore } from './stores/auth';


const authStore = useAuthStore()

// onMounted(() => { authStore.getUser() })
</script>

<template>
  <div>
      <RouterView />
  </div>
</template>