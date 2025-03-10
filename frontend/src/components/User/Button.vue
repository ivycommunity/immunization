<template>
  <button
    :type="type"
    :disabled="isLoading"
    :class="buttonClass"
    class="py-3 px-6 rounded-lg font-medium transition-colors flex items-center justify-center gap-2"
  >
    <span v-if="isLoading" class="loader"></span>
    <span v-if="!isLoading">{{ text }}</span>
  </button>
</template>

<script setup>
import { computed } from "vue";

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

<style scoped>
/* Simple CSS spinner */
.loader {
  width: 20px;
  height: 20px;
  border: 3px solid #fff;
  border-top: 3px solid transparent;
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
=======
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
