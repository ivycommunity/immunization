<script setup>
import { PlusIcon } from  "@heroicons/vue/24/solid";
defineProps({

    addSomething: {
        type: Function,
        // required: true // should be required
    }

});

</script>

<template>
    <button 
        class="absolute bottom-8 right-4 z-50 p-4 rounded-full transition-colors bg-[#FEC62F] text-center hover bg-opacity-90"
        type="button"
        @click="addSomething"    
    >
        <PlusIcon class="h-5 w-5 text-[#432C81]" />
    </button>
</template>