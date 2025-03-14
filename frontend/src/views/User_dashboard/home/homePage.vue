<script setup>
    import Layout from '@/components/User/userLayout.vue';
    import homeNavButton from '@/components/User/homeNavButton.vue';
    import clinicDetailsIocn from "@/assets/userI/clinic-details.png";
    import clinicRecordsIcon from "@/assets/userI/clinic-records.png";
    import vaccinationIcon from "@/assets/userI/vaccination.png";
    
    import userStore from '@/stores/userStore';

    let { first_name, } = {first_name: "", };
    
    const store = userStore();
    
    if (store.isAuthenticated){
        ({ first_name, } = JSON.parse(localStorage.getItem('user_data') || "{}"));
        console.log("the user in home page", first_name);
    }
        

</script>

<template>
    <Layout :user-data="{ first_name: first_name, avatar: null }" topBarMove="false">
        <div class="mb-4 flex flex-col gap-4 w-full items-center justify-center">
            <homeNavButton
                title="Child Details"
                link="/user/add-record"
                :illustration-icon= "clinicDetailsIocn"
            />
            <homeNavButton
                title="Vaccination Records"
                link="/user/view-records"
                :illustration-icon= "clinicRecordsIcon"
            />
            <homeNavButton
                title="Vaccination Chart"
                link="/user/view-records"
                :illustration-icon= "vaccinationIcon"
            />
        </div>

        <div class="flex gap-4 flex-grow flex-wrap md:flex-nowrap">
            <homeNavButton
                title="Why the OPV vaccine is important for your child"
                link="/user/view-records"
                className = "aspect-square max-h-[100px] text-xs sm:text-sm md:text-base"
            />
            <homeNavButton
                title="Tetanus Prevention measures"
                link="/user/view-records"
                className = "aspect-square max-h-[100px] text-xs sm:text-sm md:text-base "
            />
        </div>
        
    </Layout>
</template>