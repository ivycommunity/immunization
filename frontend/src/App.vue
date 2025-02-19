<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header>
      <nav>
        <RouterLink to="/" class="nav-link">Home</RouterLink>
      </nav>
  </header>

  <RouterView />
</template>