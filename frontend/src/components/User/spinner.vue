<template>
    <span v-if="isLoading" :class="`loader rounded-full ${ loaderClass }`"></span>
</template>
  
  <script setup>
  import { computed } from "vue";
  
  // Props
  const props = defineProps({
    isLoading: {
      type: Boolean,
      default: false,
    },
    variant: {
      type: String,
      default: "primary",
    },
    class: {
      type: String,
      default: "border-2",
    },
  });
  
  // Computed property for dynamic button classes
  const loaderClass = computed(() => {
    const variantClass =
      props.variant === "secondary"
        ? "border-[#432C81]"
        : "border-white";

    return `${variantClass} ${props.class}`;
  });
  </script>
  
  <style scoped>
  /* Simple CSS spinner */
  .loader {
    width: 16px;
    height: 16px;
    animation: spin 0.7s linear infinite;
  }
  
  @keyframes spin {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }
  </style>
  