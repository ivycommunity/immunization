<script setup>
import { Squares2X2Icon, ListBulletIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

const toList = ref(false);

const showList = () => {
    toList.value = !toList.value;
}
</script>

<template>
    <div class="mt-8 min-h-screen">
        <div class="rounded-tl-lg rounded-tr-lg w-full flex justify-end p-2">
            <button 
                type="button"
                @click="showList"
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
