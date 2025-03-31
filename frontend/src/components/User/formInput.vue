<template>
  <div class="flex flex-col gap-1">
    <div v-if="type !== 'password'" class="w-full">
      <input 
        :placeholder="placeholder" 
        :class="className"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
      />
      <span v-if="errorMessage" class="text-[#EB5858] text-sm ml-2">{{ errorMessage }}</span>
    </div>
    
    <div v-else class = "w-full">
      <div class="relative w-full">
        <input 
          :type="showPassword ? 'text' : 'password'"
          :placeholder="placeholder" 
          :class="className"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
        />
        <button 
          type="button"
          @click="togglePassword"
          class="absolute right-4 top-1/3 transform text-secondary"
          aria-label="Toggle password visibility"
        >
          <EyeSlashIcon v-if="showPassword" class="h-5 w-5 text-gray-500" />
          <EyeIcon v-else class="h-5 w-5 text-gray-500" />
        </button>
      </div>
      <span v-if="errorMessage" class="text-[#EB5858] text-sm ml-2">{{ errorMessage }}</span>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
  type: {
    type: String,
    required: true
  },
  name: {
    type: String,
    required: true
  },
  id: {
    type: String,
    required: true
  },
  placeholder: {
    type: String,
    required: true
  },
  className: {
    type: String,
    default: 'w-full px-4 py-3 rounded-lg border border-[#EDECF4] text-[#432C81] placeholder-[#82799D] focus:outline-none focus:ring-2 focus:ring-[#432C81]'
  },
  modelValue: {
    type: String,
    default: ''
  },
  errorMessage: {
    type: String,
    default: ''
  }
});

defineEmits(['update:modelValue']);

const showPassword = ref(false);

const togglePassword = () => {
  showPassword.value = !showPassword.value;
};
</script>