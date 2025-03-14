<script setup>
    
    import settingsMenu from '@/components/User/settingsMenu.vue';
    import profileComponent from '@/components/User/profileComponent.vue';
    import userLayout from '@/components/User/userLayout.vue';

    import userStore from '@/stores/userStore';

    let { first_name, last_name, email, phone_number} = {first_name: "", last_name: "", email: "", phone_number: ""};
    
    const store = userStore();
    
    if (store.isAuthenticated){
        ({ first_name, last_name, email, phone_number} = JSON.parse(localStorage.getItem('user_data') || "{}"));
        
        console.log("the user in home page");
    }

    const userFullName = first_name.concat(" ").concat(last_name);
    const userEmail = email;
    const userPhone_number = phone_number;
</script>

<template>
    <userLayout
        topBartitle="Settings"
        topBarMove="false"
    >
        <profileComponent :user-full-name = "userFullName" :user-email = "userEmail" :user-phone="userPhone_number" />
        <settingsMenu/>
    </userLayout>
</template>
