<script setup>
    import {ref, onMounted, computed } from 'vue';
    import Layout from '@/components/User/userLayout.vue';
    import homeNavButton from '@/components/User/homeNavButton.vue';
    import gridContainer from '@/components/User/gridContainer.vue';
    import { useVaccineStore } from '@/stores/vaccineStore';
    import userStore from '@/stores/userStore';
    import illustration from '@/assets/userI/vaccination.png';
    import spinner from '@/components/User/spinner.vue';
    import vaccineCard from '@/components/User/vaccineCard.vue';

    const TITLE = 'Vaccination Chart';
    const dataLoading = ref(false);
    
    const vaccineStore = useVaccineStore();
    const vaccines = ref([]);
    const hasVaccines = computed(() => {
        return Array.isArray(vaccines.value) && vaccines.value.length > 0;
    });

    onMounted(async () => {
        dataLoading.value = true;
        try {
            if(!userStore().isAuthenticated) {
                router.push({name: "userLogin"});
            }
            else{
                const response = await vaccineStore.fetchAllVaccines();
                console.log("The vaccines: ", response);
                vaccines.value = response.vaccines;
            }
        } catch (error) {
            console.error("Error fetching vaccines:", error);
            vaccines.value = [];

        } finally {
            dataLoading.value = false;
        }
    });

</script>

<template>
    <Layout
        back-to="/user/home"
        :topBartitle="TITLE"
    >
        <homeNavButton :title="TITLE" :illustration-icon="illustration"/>
        
        <!-- Add a container for the spinner with proper positioning -->
        <div v-if="dataLoading" class="flex justify-center items-center py-8">
            <spinner :is-loading="dataLoading" variant="secondary" />
        </div>

        <div v-else-if="hasVaccines">
            <gridContainer>
                <div v-for="vaccine in vaccines" :key="vaccine.id">
                    <vaccineCard
                        :vaccine="vaccine"
                    />
                </div>
            </gridContainer>
        </div>

        <div v-else>
            <p class="text-center p-4">No vaccine details available.</p>
        </div>
    </Layout>
</template>