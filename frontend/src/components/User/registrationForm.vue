<script setup>
import { default as SubmitButton } from "@/components/User/Button.vue";
import userRegistrationLayout from "./userLayout.vue";
import secondaryMessage from "./secondaryMessage.vue";

const props = defineProps({
  handleSubmit: {
    type: Function,
    required: true
  },
  header: {
    type: String,
  },
  title: {
    type: String,
  },
  isLoading: {
    type: Boolean,
    default: false
  },
  submitButtonText: {
    type: String,
  },

  secondaryMessage_Message :{
    type : String
  },
  secondaryMessage_Action :{
    type : String
  },
  topBarBackTo:{
    type : String,
    default: '/user',
  }
});
</script>

<template>
  <userRegistrationLayout :topBartitle="title" :bact-to="topBarBackTo">
    <div class="flex flex-wrap items-center justify-between box-border bg-white">
      <div class="w-full text-center mb-4">
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#432C81]">{{ header? header : title }}</h2>
      </div>
      
      <div class="w-full max-w-md mx-auto mb-8">
        <img 
          src="@/assets/userI/group1.png" 
          alt="People illustrations" 
          class="w-full h-auto object-contain"
        >
      </div>

      <div class="w-full max-w-md mx-auto">
        <form @submit.prevent="handleSubmit" class="flex flex-col gap-6">
          <slot></slot>
          <SubmitButton type="submit" :is-loading="isLoading" :text="submitButtonText? submitButtonText : title"></SubmitButton>
          <!-- Secondary Message -->
      <secondaryMessage :message="secondaryMessage_Message" :to="`${secondaryMessage_Action}`" :action="secondaryMessage_Action"/>
        </form>
      </div>
    </div>
  </userRegistrationLayout>
</template>