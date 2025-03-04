<template>
    <button
      :type="type"
      :disabled="isLoading"
      :class="buttonClass"
      class="py-3 px-6 rounded-lg font-medium transition-colors"
    >
      {{ text }}
    </button>
</template>
  
<script setup>
  import { computed } from 'vue';
  
  // Props
  const props = defineProps({
    type: {
      type: String,
      default: 'button',
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
      default: 'primary',
    },
    class: {
      type: String,
      default: '',
    },
  });
  
  // Computed property for dynamic button classes
  const buttonClass = computed(() => {
    const variantClass =
      props.variant === 'secondary'
        ? 'text-[#432C81] text-center border border-[#432C81] bg-white'
        : 'bg-[#432C81] text-center text-white';
    return `${variantClass} ${props.class}`;
  });
</script>