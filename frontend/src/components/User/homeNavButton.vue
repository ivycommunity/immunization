<script setup>
    import { defineProps } from 'vue';
    
    defineProps({
        title:{
                type: String,
                required: true
        },
        link:{
            type: String,
            required: true
        },
        illustration_Icon:{
            type: String,
            required: false
        },
        className:{
            type: String,
            required: false
        }
    });
    
</script>

<template>
    <router-link :to="link"  class="w-full">
        <div 
            :class="` px-8 flex w-full gap-4 items-center justify-between p-4 bg-[#EDECF4] rounded-lg shadow-md ${className}`"
        >            
            <div>
                <h3 class="text-[#432C81] text-xl sm:text-2xl text-left font-semibold">{{ title }}</h3>
            </div>
            
            <div v-if="illustration_Icon" class="bg-transparent flex justify-center">
                <img 
                    :src="illustration_Icon"
                    alt="icon"
                    class="w-30 h-30 object-contain"
                />
            </div>
        </div>
    </router-link>
</template>