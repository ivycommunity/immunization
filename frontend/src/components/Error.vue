<template>
    <p class="text-red-400">{{ error }}</p>
</template>

<script setup>
defineProps({
    error: String
})
</script>