<script setup>
    import Layout from '@/components/User/userLayout.vue';
    import homeNavButton from '@/components/User/homeNavButton.vue';
    import clinicDetailsIocn from "@/assets/userI/clinic-details.png";
    import clinicRecordsIcon from "@/assets/userI/clinic-records.png";
    import vaccinationIcon from "@/assets/userI/vaccination.png";
    
    import userStore from '@/stores/userStore';
    import {computed, onMounted, ref } from "vue";
    import { useRouter } from 'vue-router';
    
    const store = userStore();
    const f_name = ref("");
    const no_of_child = ref(0);
    const router = useRouter();

    onMounted(()=>{
        if(!store.isLoggedIn) router.push({name: "userLogin"})
        else{
            let { first_name, no_of_children } = JSON.parse(localStorage.getItem("user_data")) || "{}";
            f_name.value = first_name;
            no_of_child.value = no_of_children;

        }
    });
        
    const childTitle = computed(() => {
        return store.no_of_children > 1 ? "Children" : "Child";
    });

    console.log("childtitle in home : ",childTitle);

</script>

<template>
    <Layout :user-data="{ first_name: f_name, avatar: null }" :topBarMove="false" :with-bottom-bar ="true" >
        <div class="mb-4 flex flex-col gap-4 w-full items-center justify-center">
            <homeNavButton
                :title="childTitle.concat(' Records')"
                link="/user/records/babies"
                :illustration-icon= "clinicDetailsIocn"
            />
            <homeNavButton
                title="Vaccination Appointments"
                link="/user/records/vaccination"
                :illustration-icon= "clinicRecordsIcon"
            />
            <homeNavButton
                title="Vaccination Chart"
                link="/user/records/vaccination-chart"
                :illustration-icon= "vaccinationIcon"
            />
        </div>

        <div class="flex gap-4 flex-grow flex-wrap md:flex-nowrap">
            <homeNavButton
                title="Why the OPV vaccine is important for your child"
                link="#"
                className = "aspect-square max-h-[100px] text-xs sm:text-sm md:text-base"
            />
            <homeNavButton
                title="Tetanus Prevention measures"
                link="#"
                className = "aspect-square max-h-[100px] text-xs sm:text-sm md:text-base "
            />
        </div>
        
    </Layout>
</template>