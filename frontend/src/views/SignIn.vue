<script setup>
import Input from '@/components/Input.vue'
import GreenButton from '@/components/GreenButton.vue'
import { onMounted, reactive } from 'vue'
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/stores/auth';
import Error from '@/components/Error.vue';
import { errorMessages } from 'vue/compiler-sfc';

const { errors } = storeToRefs(useAuthStore())
const { authenticate } = useAuthStore()

const formData = reactive({
    email: "",
    password: "",
})

onMounted(() => (errors.value = {}))

</script>

<template>
    <main>
        <div class="flex h-screen justify-center items-center">
            <div class="flex mx-12 flex-col gap-5 border border-slate-200 rounded-sm p-5 md:flex-row">
                <div class="w-70 md:w-100">
                    <img src="@/assets/images/logo.png" alt="">
                </div>
                <div class="flex flex-col justify-center">
                    <div class="mb-2 flex justify-center bg-black-100 text-xl font-bold md:text-4xl md:mb-5">Sign in
                    </div>
                    <form @submit.prevent="authenticate('login', formData)">
                        <Input v-model="formData.email" type="email" label="Email or Phone Number" name="email"
                            placeholder="Enter your email" />
                        <Error v-if="errors.email_or_phone_number" :error="errors.email_or_phone_number[0]" />
                        <Input v-model="formData.password" type="password" label="Password" name="password"
                            placeholder="Enter your password" />
                        <Error v-if="errors.password" :error=" errors.password[0]" />
                        <div class="flex justify-center">
                            <GreenButton name="Sign in" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</template>
