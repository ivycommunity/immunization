<script setup>
    
    import settingsMenu from '@/components/User/settingsMenu.vue';
    import profileComponent from '@/components/User/profileComponent.vue';
    import userLayout from '@/components/User/userLayout.vue';
    import {default as LogoutButton} from '@/components/User/Button.vue';

    import userStore from '@/stores/userStore';
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';

    let { first_name, last_name, email, phone_number} = {first_name: "", last_name: "", email: "", phone_number: ""};
    
    const store = userStore();
    const router = useRouter();
    
    if (store.isAuthenticated){
        ({ first_name, last_name, email, phone_number} = JSON.parse(localStorage.getItem('user_data') || "{}"));
        
        console.log("the user in home page");
    }

    const userFullName = first_name.concat(" ").concat(last_name);
    const userEmail = email;
    const userPhone_number = phone_number;

    const isLoading = ref(false);

    const handleLogout = async () => {
        try{
            isLoading.value = true;
            await store.logout();
            router.push({name : "userWelcome",});
        }
        catch(error){
            isLoading.value = false;
            router.push(`/user/error/${error.response ? error.response.status : '500'}`);
        }
        finally{
            isLoading.value = false;
        }

    }
</script>

<template>
    <userLayout
        topBartitle="Settings"
        topBarMove="false"
        :with-bottom-bar ="true"
    >
        <profileComponent :user-full-name = "userFullName" :user-email = "userEmail" :user-phone="userPhone_number" />
        <settingsMenu/>
        <LogoutButton @click="handleLogout" text="Logout" variant="secondary" class="hover:bg-[#F8F4F8]"/>
    </userLayout>
</template>
