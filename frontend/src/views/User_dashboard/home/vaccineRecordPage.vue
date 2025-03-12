<script setup>
    import gridContainer from '@/components/User/gridContainer.vue';
    import vaccineRecord from '@/components/User/vaccineRecord.vue';
    import UserLayout from '@/components/User/userLayout.vue';
    import homeNavButton from '@/components/User/homeNavButton.vue';
    import illustration from '@/assets/userI/Electrocardiogram.png';


    const  TITLE = 'Vaccination Records';
</script>

<template>
    <UserLayout 
        back-to="/home"
        :top-bartitle="TITLE"
        top-bar-move="true"
    >
        <homeNavButton :title="TITLE" :illustration-icon = "illustration"/>
        
        <gridContainer>
            <vaccineRecord 
                date="Today"
                doctor = "Mr Docta"
                clinic = "Nairobi-West"
                vaccine-type = "Tetanoce"
            />
            <vaccineRecord 
                date="Today"
                doctor = "Mr Docta"
                clinic = "Nairobi-West"
                vaccine-type = "Tetanoce"
            />
            <vaccineRecord 
                date="Today"
                doctor = "Mr Docta"
                clinic = "Nairobi-West"
                vaccine-type = "Tetanoce"
            />
            <vaccineRecord 
                date="Today"
                doctor = "Mr Docta"
                clinic = "Nairobi-West"
                vaccine-type = "Tetanoce"
            />
            <vaccineRecord 
                date="Today"
                doctor = "Mr Docta"
                clinic = "Nairobi-West"
                vaccine-type = "Tetanoce"
            />
            <vaccineRecord 
                date="Today"
                doctor = "Mr Docta"
                clinic = "Nairobi-West"
                vaccine-type = "Tetanoce"
            />
        </gridContainer>
    </UserLayout>
    
</template>