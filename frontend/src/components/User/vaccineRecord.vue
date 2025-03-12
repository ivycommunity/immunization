<script setup>
const props = defineProps({
    date:{
        type : String,
        required: true
    },
    doctor:{
        type: String,
        required: true
    },
    clinic : {
        type : String,
        required: true
    },
    vaccineType : {
        type : String,
        required: true
    }
})
</script>

<template>
    <div class="p-4 rounded rounded-lg bg-white">
        <h3 class="text-[#432C81] text-lg">
            {{ date }} - 
            {{ clinic }} - 
            {{ doctor }}
        </h3>
        <p class="text-[#432C81]/80">
            Vaccine type : 
            <span>{{ vaccineType }}</span>
        </p>
    </div>
</template>