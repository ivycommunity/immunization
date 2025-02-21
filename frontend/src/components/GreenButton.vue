<template>
    <button
        class="bg-teal-500 w-40 mt-5 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline cursor-pointer"
        type="submit">
        {{ name }}
    </button>
</template>

<script setup>
defineProps({
    name: String,
})
</script>