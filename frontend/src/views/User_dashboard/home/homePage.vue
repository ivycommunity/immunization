<script setup>
    import userRegistrationLayout from '@/components/User/userLayout.vue';
    import homeNavButton from '@/components/User/homeNavButton.vue';
    import clinicDetailsIocn from "@/assets/userI/clinic-details.png";
    import clinicRecordsIcon from "@/assets/userI/clinic-records.png";
    import vaccinationIcon from "@/assets/userI/vaccination.png";
</script>

<template>
    <userRegistrationLayout topBartitle="👋🏻 Hi Julia!" topBarMove="false" topBarWithBackArrow="false">
        <div class="mb-4 flex flex-col gap-4 w-full items-center justify-center">
            <homeNavButton
                title="Child Details"
                link="/user/add-record"
                :illustration_Icon= "clinicDetailsIocn"
            />
            <homeNavButton
                title="Vaccination Records"
                link="/user/view-records"
                :illustration_Icon= "clinicRecordsIcon"
            />
            <homeNavButton
                title="Vaccination Chart"
                link="/user/view-records"
                :illustration_Icon= "vaccinationIcon"
            />
        </div>

        <div class="flex gap-4 flex-grow">
            <homeNavButton
                title="Why the OPV vaccine is important for your child"
                link="/user/view-records"
                className = "aspect-square lg:max-h-[100px] text-xs sm:text-sm md:text-base"
            />
            <homeNavButton
                title="Tetanus Prevention measures"
                link="/user/view-records"
                className = "aspect-square lg:max-h-[100px] text-xs sm:text-sm md:text-base"
            />
        </div>
        
    </userRegistrationLayout>
</template>