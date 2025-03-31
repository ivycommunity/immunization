<template>
  <span v-if="isLoading" :class="`loader ${loaderClass}`"></span>
</template>

<script setup>
  import { computed } from "vue";
    
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
      default: "",
    },
  });

  // Computed property for dynamic loader classes
  const loaderClass = computed(() => {
    const variantClass =
      props.variant === "secondary"
        ? "border-t-[#432C81]"
        : "border-t-white";

    return `border-2 border-solid border-transparent rounded-full ${variantClass} ${props.class}`;
  });
</script>

<style scoped>
  /* Simple CSS spinner */
  .loader {
    width: 16px;
    height: 16px;
    border-width: 2px;
    border-style: solid;
    border-radius: 50%;
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
