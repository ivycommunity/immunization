<script setup>
    import { 
        HomeModernIcon, 
        HomeIcon,
        Cog6ToothIcon,
        BellAlertIcon,
        BellIcon
    } from '@heroicons/vue/24/outline';

    const navItems = [
        {
            default_icon : HomeIcon,
            to : "/user/home",
        },
        {
            default_icon : BellIcon,
            secondary_icon: BellAlertIcon,
            to : "/user/notification",
        },
        {
            default_icon : Cog6ToothIcon,
            to : "/user/profile",
        },
    ]
</script>

<template>

<div class="w-full flex items-center justify-center fixed bottom-0 left-0 bg-white" style="box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);">
        <div class="w-full md:max-w-[50%] py-4 flex items-center justify-around">
            <div v-for="(item, index) in navItems" :key="index" >
                <router-link
                    class=""
                    :to="item.to"
                >
                    <component :is="item.default_icon" class="h-6 w-6 text-[#56428F]/100 mr-3" aria-hidden="true" />
                </router-link>
            </div>
        </div>
    </div>

</template>