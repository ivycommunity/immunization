<script setup>
    import Layout from '@/components/User/userLayout.vue';
    import homeNavButton from '@/components/User/homeNavButton.vue';
    import clinicDetailsIocn from "@/assets/userI/clinic-details.png";
    import clinicRecordsIcon from "@/assets/userI/clinic-records.png";
    import vaccinationIcon from "@/assets/userI/vaccination.png";
    
    import userStore from '@/stores/userStore';
    import { onMounted, ref } from "vue";
    import { useRouter } from 'vue-router';
    
    const store = userStore();
    const f_name = ref("");
    const router = useRouter();

    onMounted(()=>{
        if(!store.isAuthenticated) router.push({name: "userLogin"})
        else{
            let { first_name } = JSON.parse(localStorage.getItem("user_data")) || "{}";
            f_name.value = first_name;
        }
    });
        

</script>

<template>
    <Layout :user-data="{ first_name: f_name, avatar: null }" :topBarMove="false" :with-bottom-bar ="true" >
        <div class="mb-4 flex flex-col gap-4 w-full items-center justify-center">
            <homeNavButton
                title="Child Details"
                link="#"
                :illustration-icon= "clinicDetailsIocn"
            />
            <homeNavButton
                title="Vaccination Records"
                link="/user/reccords/vaccination"
                :illustration-icon= "clinicRecordsIcon"
            />
            <homeNavButton
                title="Vaccination Chart"
                link="#"
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