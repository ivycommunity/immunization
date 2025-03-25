<script setup>
import { Squares2X2Icon, ListBulletIcon } from '@heroicons/vue/24/outline';
import { ref, defineEmits } from 'vue';

const toList = ref(true);
const selectedOption = ref('Scheduled');

// Emit event to the parent when selectedOption changes
const emit = defineEmits(['updateStatus']);

const handleChange = () => {
    emit('updateStatus', selectedOption.value); // Send new status to parent
};
</script>

<template>
    <div class="mt-8 min-h-screen">
        <div class="rounded-tl-lg rounded-tr-lg w-full flex justify-between p-2">
            <select
                v-model="selectedOption"
                @change="handleChange"
                class="p-3 rounded-lg border border-gray-300 bg-white text-gray-700 shadow-sm outline-none focus:ring-2 focus:ring-purple-300 focus:border-purple-300 transition"
            >
                <option value="Scheduled">Scheduled</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Missed">Missed</option>
            </select>


            <button 
                type="button"
                @click="toList = !toList"
                class="text-secondary"
                aria-label="Toggle between list and grid view"
            >
                <ListBulletIcon v-if="toList" class="h-5 w-5 text-gray-500" />
                <Squares2X2Icon v-else class="h-5 w-5 text-gray-500" />
            </button>
        </div>
        <div :class="`rounded-lg shadow-md bg-[#EDECF4] w-full grid gap-4 p-4 ${toList ? 'grid-cols-1' : 'grid-cols-2'}`">
            <slot></slot>
        </div>
    </div>
</template>
