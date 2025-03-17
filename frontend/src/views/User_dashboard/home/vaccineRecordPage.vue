<script setup>
    import gridContainer from '@/components/User/gridContainer.vue';
    import UserLayout from '@/components/User/userLayout.vue';
    import homeNavButton from '@/components/User/homeNavButton.vue';
    import illustration from '@/assets/userI/Electrocardiogram.png';
import { ref } from 'vue';


    const  TITLE = 'Vaccination Records';

    const appointments = [
        {
            date: "today",
            clinic: "Nairobi-west",
            doctor: "Daniel",
            vaccineType : "vaccin"
        },
        {
            date: "today",
            clinic: "Nairobi-west",
            doctor: "Daniel",
            vaccineType : "vaccin"
        },
    ];

</script>

<template>
    <UserLayout 
        bact-to="/user/home"
        :topBartitle="TITLE"
    >
        <homeNavButton :title="TITLE" :illustration-icon="illustration"/>
        
        <gridContainer>
            <div v-for="(item, index) in appointments" :key="index">
                <div class="p-4 rounded rounded-lg bg-white">
                <h3 class="text-[#432C81] text-lg">
                    {{ item.date }} - 
                    {{ item.clinic }} - 
                    {{ item.doctor }}
                </h3>
                <p class="text-[#432C81]/80">
                    Vaccine type : 
                    <span>{{ item.vaccineType }}</span>
                </p>
            </div>
            </div>
        </gridContainer>
    </UserLayout>
</template>