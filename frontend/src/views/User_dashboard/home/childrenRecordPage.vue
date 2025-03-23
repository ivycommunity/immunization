<script setup>
    import userLayout from '@/components/User/userLayout.vue';
    import babyCard from '@/components/User/babyCard.vue';
    import { useBabiesStore } from '@/stores/babyStore';
    import userStore from '@/stores/userStore';
    import { onMounted, ref } from 'vue';

    const babiesStore = useBabiesStore();
    const currentUserID = userStore().getUserID;
    const no_of_child = userStore().no_of_children;
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

    function childTitle (no_of_children){
        return no_of_children > 1 ? "Children" : "Child";
    }

</script>

<template>
    <userLayout
        :topBartitle="'My '.concat(childTitle(no_of_child).toString())"
        :topBarMove="false" 
        :with-bottom-bar="true"
    >
        <div v-for="baby in babies" :key="baby.id">
            <babyCard :baby="baby"/>
        </div>
    </userLayout>
</template>
