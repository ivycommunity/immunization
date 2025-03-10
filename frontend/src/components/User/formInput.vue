<template>
    <div class="flex flex-col gap-1">
        <input 
            :type="type" 
            :name="name" 
            :id="id" 
            :placeholder="placeholder" 
            :class="inputClass"
            v-model="inputValue"
        />
        <span v-if="errorMessage" class="text-[#EB5858] text-sm ml-2">{{ errorMessage }}</span>
    </div>
</template>

<script setup>

const props = defineProps({
    type: {
        type: String,
        required: true
    },
    name: {
        type: String,
        required: true
    },
    id: {
        type: String,
        required: true
    },
    placeholder: {
        type: String,
        required: true
    },
    inputClass: {
        type: String,
        default: ''
    },
    errorMessage: {
        type: String,
        default: ''
    }
});
</script>

<style scoped>
/* Add any additional styles if needed */
</style>