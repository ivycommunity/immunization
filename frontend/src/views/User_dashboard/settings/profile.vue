<script setup>
    
    import settingsMenu from '@/components/User/settingsMenu.vue';
    import profileComponent from '@/components/User/profileComponent.vue';
    import userLayout from '@/components/User/userLayout.vue';
    import {default as LogoutButton} from '@/components/User/Button.vue';

    import userStore from '@/stores/userStore';
    import { useRouter } from 'vue-router';
    import { ref, computed } from 'vue';
    
    const store = userStore();
    const router = useRouter()

    const userData = ref({ first_name: "", last_name: "", email: "", phone_number: "" });

    if (store.isAuthenticated) {
        userData.value = JSON.parse(localStorage.getItem('user_data') || "{}");
    }

    const userFullName = computed(() => userData.value.first_name + " " + userData.value.last_name);
    const userEmail = computed(() => userData.value.email);
    const userPhone_number = computed(() => userData.value.phone_number);
    
    const isLoading = ref(false);

    const handleLogout = async () => {
        isLoading.value = true;
        console.log("is loading is on -> value : ", isLoading.value);
        try {
            await new Promise(resolve => setTimeout(resolve, 5000));
            await store.logout();
            router.push({ name: "userWelcome" });
        } catch (error) {
            router.push(`/user/error/${error.response ? error.response.status : '415'}`);
        } finally {
            isLoading.value = false;
            console.log("is loading is off -> value : ", isLoading);
        }
    };
</script>

<template>
    <userLayout
        topBartitle="Settings"
        topBarMove="false"
        :with-bottom-bar ="true"
    >
        <profileComponent :user-full-name = "userFullName" :user-email = "userEmail" :user-phone="userPhone_number" />
        <settingsMenu/>
        <LogoutButton @click="handleLogout"  text="Logout" :is-loading="isLoading" variant="secondary" class="hover:bg-[#F8F4F8]"/>
    </userLayout>
</template>
