<script setup>
import { ref } from 'vue';
import { z } from 'zod';
import { useRouter } from 'vue-router';
import registrationForm from '@/components/User/registrationForm.vue';
import formInput from '@/components/User/formInput.vue';
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";
import userStore from '@/stores/userStore';

const store = userStore();

// Reactive state
const confirm_password = ref('');
const password = ref('');
const errors = ref({
  password: null,
  confirm_password: null,
});

const isLoading = ref(false);

const router = useRouter();

const handleSubmit = async () => {
  // Define the Zod schema
  const registrationSchema = z
    .object({
      password: z
        .string()
        .min(6, 'Password must be at least 6 characters')
        .nonempty('Please enter your your Password'),
      confirm_password: z
      .string()
      . nonempty('Please confirm your password')
    })
    .refine((data)=> data.password === data.confirm_password,{
      message: 'passwords do not match',
      path: ['confirm_password'],
    })

  // Validate the data
  const result = registrationSchema.safeParse({
    password: password.value,
    confirm_password: confirm_password.value,
  });

  if (result.success) {
    errors.value = { confirm_password: null, password: null };
    isLoading.value = true;

    try {
      console.log('Password:', password.value, 'Confirm Password:', confirm_password.value);
      
      // API call
      
      // const response = await axios
      //   .create({
      //       baseURL:'/api',
      //       withCredentials: true,
      //   })
      //   .put('/register/updatePassword', {
      //       password: password.value,
      //   });
        
      // console.log('API Response:', response.data); // recieve a password updated successfully message

      router.push({ name: 'userLogin' });
    } catch (error) {
      console.error('API Error:', error.response ? error.response.data : error.message);
      router.push(`/user/error/${error.response ? error.response.status : '500'}`);
    } finally {
      isLoading.value = false;
    }
  } else {
    
    // Set error messages
    errors.value = {
      password: result.error.errors.find((err) => err.path[0] === 'password')?.message || null,
      confirm_password: result.error.errors.find((err) => err.path[0] === 'confirm_password')?.message || null,
    };
    console.log('Validation errors:', errors.value);
  }
};
</script>

<template>
  <registrationForm :handle-submit="handleSubmit" title="Change Password" submit-button-text="Save" :is-loading="isLoading">
    <formInput 
      type="password"
      name="password"
      id="password"
      placeholder="Password"
      :model-value="password"
      @update:model-value="password = $event"
      :error-message="errors.password"
    />
    <formInput 
      type="password"
      name="confirm_password"
      id="confirm_password"
      placeholder="Confirm Password"
      :model-value="confirm_password"
      @update:model-value="confirm_password = $event"
      :error-message="errors.confirm_password"
    />
  </registrationForm>
</template>