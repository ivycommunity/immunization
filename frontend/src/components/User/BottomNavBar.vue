<script setup>
    import { 
        HomeIcon,
        Cog6ToothIcon,
        BellAlertIcon,
        BellIcon
    } from '@heroicons/vue/24/outline';
    import { 
        HomeIcon as HomeIconSolid,
        Cog6ToothIcon as Cog6ToothIconSolid,
        BellIcon as BellIconSolid
    } from '@heroicons/vue/24/solid';
    import { useRoute } from 'vue-router';

    const route = useRoute();

    const navItems = [
        {
            default_icon : HomeIcon,
            active_icon: HomeIconSolid,
            to : "/user/home",
        },
        {
            default_icon : BellIcon,
            active_icon: BellIconSolid,
            secondary_icon: BellAlertIcon,
            to : "#",
        },
        {
            default_icon : Cog6ToothIcon,
            active_icon: Cog6ToothIconSolid,
            to : "/user/profile",
        },
    ]

    const isActive = (path) => {
        return route.path === path;
    }
</script>

<template>
    <div class="w-full flex items-center justify-center fixed bottom-0 left-0 bg-white" style="box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);">
        <div class="w-full md:max-w-[50%] py-4 flex items-center justify-around">
            <div v-for="(item, index) in navItems" :key="index">
                <router-link
                    :to="item.to"
                    class="flex items-center justify-center"
                >
                    <component 
                        :is="isActive(item.to) ? item.active_icon : item.default_icon" 
                        class="h-6 w-6" 
                        :class="isActive(item.to) ? 'text-[#56428F]' : 'text-[#56428F]/50'" 
                        aria-hidden="true" 
                    />
                </router-link>
            </div>
        </div>
    </div>
</template>