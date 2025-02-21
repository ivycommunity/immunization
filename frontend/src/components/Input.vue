<template>
    <div class="mb-4">
        <label :for="name" class="block text-gray-700 text-sm font-bold mb-2">
            {{ label }}
        </label>
        <input :type="type" :id="name" :name="name" :placeholder="placeholder" v-model="modelValue"
            class="shadow appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight border-blue-500 focus:outline-blue-500 focus:shadow-outline md:w-100">
    </div>
</template>

<script setup>
defineProps({
    modelValue: String,
    label: String,
    name: String,
    placeholder: String,
    type: String,
})

const modelValue = defineModel()

</script>