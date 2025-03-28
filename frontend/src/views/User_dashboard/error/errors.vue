<script setup>
import { useRoute, useRouter } from 'vue-router';
// import addButton from '@/components/User/addButton.vue'; // Import the addButton component
// import defaultErrorImage from '@/assets/userI/Goodies-Error1.png';
import ErrorImage from '@/assets/userI/Error2.png';
import topbar from '@/components/User/topbar.vue';

const route = useRoute();
const router = useRouter();
const errorCode = route.params.errorCode || "500";

const goBack = ()=>{
    router.back();
}

const errorMessage =  {
    title: 'Opps! Something went wrong.',
    image: ErrorImage,
    action_text: 'Tap the screen to try again.',
};

</script>

<template>
    <div>
        <topbar :move="false" :title="errorMessage.topBarTitle ? errorMessage.topBarTitle : null " :back-to="errorMessage.Link ? errorMessage.Link : ''" />
        <div
            @click="goBack"
            :to="errorMessage.Link"
            class="flex flex-wrap items-center justify-between h-svh p-6 box-border bg-white"   
        >
            <div class="w-full max-w-md mx-auto mb-8">
                <img 
                    :src="errorMessage.image"
                    alt="error image"
                    class="w-full h-auto object-contain"
                />
                <div class="flex flex-col items-center justify-center text-center">
                    <h3 class="text-[#432C81] text-lg font-semibold">{{ errorMessage.title }}</h3>
                    <p class="text-[#82799D] text-sm">{{ errorMessage.action_text }}</p>
                </div>
            </div>
        </div>
        <!-- <addButton v-if="errorMessage.Link == ''" :addSomething="() => console.log('Add something')" /> -->
    </div>
</template>