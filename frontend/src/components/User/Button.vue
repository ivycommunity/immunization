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
  },
  class: {
    type: String,
    default: "",
  },
});

// Computed property for dynamic button classes
const buttonClass = computed(() => {
  const variantClass =
    props.variant === "secondary"
      ? "text-[#432C81] text-center border border-[#432C81] bg-white"
      : "bg-[#432C81] text-center text-white";
  return `${variantClass} ${props.class}`;
});
</script>