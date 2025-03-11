<script setup>
import Navbar from './NavBar.vue';
import Footer from './Footer.vue';
</script>

<template>
  <div class="landing-layout">
    <Navbar />
    
    <main class="mt-20">
      <slot></slot>
    </main>
    
    <Footer />
  </div>
</template>