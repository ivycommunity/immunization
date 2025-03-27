<script setup>
    import userLayout from '@/components/User/userLayout.vue';
    import babyCard from '@/components/User/babyCard.vue';
    import { useBabiesStore } from '@/stores/babyStore';
    import userStore from '@/stores/userStore';
    import { computed, onMounted, ref } from 'vue';
    import spinner from '@/components/User/spinner.vue';

    const babiesStore = useBabiesStore();
    const currentUserID = userStore().getUserID;
    const useStore = userStore();
    const isAuthenticated = userStore().isAuthenticated;
    const babies = ref([]);
    const dataLoading = ref(false);

    const getBabies = async () => {
        dataLoading.value = true;
        try{
            console.log("current user id is : ",currentUserID);
            const response = await babiesStore.fetchBabyByGuardian(currentUserID);
            console.log("babies are : ",response);
            babies.value = response;
        } catch (error) {
            console.error("Error fetching babies:", error);
        } finally{
            dataLoading.value = false;
        }
    }

    onMounted(() => {
        if(!isAuthenticated) {
            router.push({name: "userLogin"});
        } else {
            getBabies();
        }
    });

    const childTitle = computed(() => {
        return useStore.no_of_children > 1 ? "Children" : "Child";
    });

    console.log("childtitle in records : ",childTitle);
</script>

<template>
    <userLayout
        :topBartitle="'My '.concat(childTitle)"
        :topBarMove="false" 
        :with-bottom-bar="true"
    >   
        <!-- Add a container for the spinner with proper positioning -->
        <div v-if="dataLoading" class="flex justify-center items-center py-8">
            <spinner :is-loading="dataLoading" variant="secondary" />
        </div>
        
        <div v-else v-for="baby in babies" :key="baby.id">
            <babyCard :baby="baby"/>
        </div>
    
    </userLayout>
</template>
