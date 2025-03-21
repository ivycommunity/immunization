<script setup>
// In vaccineRecord.vue
const props = defineProps({
    date: String,
    status: [String, Number],
    baby: [String, Number],
    vaccineType: [String, Number],
    doctor: [String, Number]
});

</script>

<template>
    <div class="p-4 rounded-lg bg-white w-full h-full">
        <!-- Header with baby name, dash, and vaccine type -->
        <h3 class="text-lg font-bold text-purple-900">
            <div class="grid grid-cols-5 items-center">
                <div class="col-span-2 truncate">{{ baby }}</div>
                <div class="col-span-1 flex justify-center">-</div>
                <div class="col-span-2 truncate">{{ vaccineType?.length < 30 ? vaccineType : vaccineType?.substring(0,30).concat('...') }}</div>
            </div>
        </h3>
        
        <!-- Footer with doctor and date -->
        <div class="flex justify-between items-center mt-1">
            <span class="text-purple-900/80">
                {{ doctor || 'No doctor specified' }}
            </span>
            <span class="text-purple-900/80">
                {{ date }}
            </span>
        </div>
    </div>
</template>