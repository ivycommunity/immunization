<template>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-sm text-gray-600">{{ title }}</div>
        <div class="text-3xl font-bold text-center mt-2">{{ number }}</div>
    </div>
</template>

<script setup>
defineProps({
    title: String,
    number: Number
})
</script>