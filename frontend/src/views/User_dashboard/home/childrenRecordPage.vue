<script setup>
    import profileComponent from '@/components/User/profileComponent.vue';
    import userLayout from '@/components/User/userLayout.vue';
    import settingsMenu from '@/components/User/settingsMenu.vue';
    import { useBabiesStore } from '@/stores/babyStore';
    import userStore from '@/stores/userStore';
    import { onMounted, ref } from 'vue';

    const babiesStore = useBabiesStore();
    const currentUserID = userStore().getUserID;
    const isAuthenticated = userStore().isAuthenticated;
    const babies = ref([]);

    const getBabies = async () => {
        try{
            console.log("current user id is : ",currentUserID);
            const response = await babiesStore.fetchBabyByGuardian(currentUserID);
            console.log("babies are : ",response);
            babies.value = response;
        } catch (error) {
            console.error("Error fetching babies:", error);
        }
    }

    onMounted(() => {
        if(!isAuthenticated) {
            router.push({name: "userLogin"});
        } else {
            getBabies();
        }
    });

</script>

<template>
    <userLayout :topBarMove="false" :with-bottom-bar="true">
        <div v-for="baby in babies" :key="baby.id">
            <h1>{{ baby.first_name }}</h1>  
        </div>
    </userLayout>
</template>
