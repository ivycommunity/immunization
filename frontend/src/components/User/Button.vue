<template>
  <button
    :type="type"
    :disabled="isLoading"
    :class="buttonClass"
    class="w-full flex items-center hover:cursor-pointer py-3 px-6 rounded-lg font-medium transition-colors flex items-center justify-center gap-2"
  >
    <spinner :is-loading="isLoading" :variant="props.variant || 'primary'"/>
    <span>{{ text }}</span>
  </button>
</template>

<script setup>
import { computed } from "vue";
import spinner from "./spinner.vue";

// Props
const props = defineProps({
  type: {
    type: String,
    default: "button",
  },
  isLoading: {
    type: Boolean,
    default: false,
  },
  text: {
    type: String,
    required: true,
  },
  variant: {
    type: String,
    default: "primary",
    validator: (value) => ["primary", "secondary", "cancel"].includes(value),
  },
  class: {
    type: String,
    default: "",
  },
});

// Computed property for dynamic button classes
const buttonClass = computed(() => {
  const variantClasses = {
    primary: "bg-[#038C7F] text-center text-white",
    secondary: "text-[#038C7F] text-center border border-[#038C7F] bg-white",
    cancel: "bg-[#D7331D] text-center text-white hover:bg-red-700",
  };
  
  return `${variantClasses[props.variant]} ${props.class}`;
});
</script>