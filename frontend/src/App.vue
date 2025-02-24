<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useAuthStore } from './stores/auth';
import Navbar from './components/NavBar.vue';

const authStore = useAuthStore

// onMounted(() => { authStore.getUser() })
</script>

<template>
  <header>
    <nav class="flex gap-5">
      <!-- <p v-if="authStore.user"> {{ authStore.user.name }}</p> -->
      <!-- <RouterLink :to="{ name: 'home' }" class="nav-link">Home</RouterLink>
      <RouterLink :to="{ name: 'signin' }" class="nav-link">Sign in</RouterLink>
      <RouterLink :to="{ name: 'signup' }" class="nav-link">Sign up</RouterLink> -->
      <Navbar />
    </nav>
  </header>

  <RouterView />
</template>