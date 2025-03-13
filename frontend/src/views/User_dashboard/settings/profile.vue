<script setup>
    
    import settingsMenu from '@/components/User/settingsMenu.vue';
    import profileComponent from '@/components/User/profileComponent.vue';
    import userLayout from '@/components/User/userLayout.vue';

    const userFullName = "Julia Mario"
    const userEmail = "M.julia@example.com"
</script>

<template>
    <userLayout>
        <profileComponent :user-full-name = "userFullName" :user-email = "userEmail"/>
        <settingsMenu/>
    </userLayout>
</template>
