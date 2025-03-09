<template>
    <div class="flex h-screen bg-blue-50">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-200 flex flex-col">
            <!-- Logo -->
            <div class="p-4 flex items-center space-x-2">
                <img class="w-12" src="@/assets/images/logo.png" alt="">
                <span class="text-blue-900 font-medium">Medical Center</span>
            </div>

            <!-- Navigation -->
            <div class="flex-1 px-3 py-4 space-y-2">
                <router-link v-for="link in links" :key="link.name" :to="{ name: link.name }"
                    class="w-full hover:bg-blue-600 block py-2 px-4 rounded-md text-left"
                    :class="{ 'bg-blue-700 text-white': route.name === link.name, 'bg-blue-500 text-white': route.name !== link.name }">
                    {{ link.label }}
                </router-link>
            </div>

            <!-- Bottom button -->
            <div class="p-3 mt-auto">
                <form @submit.prevent="authStore.logout">
                    <button type="submit" class="cursor-pointer w-full bg-blue-800 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                        LOGOUT
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold">{{ title }}</h1>
                <Menu as="div" class="relative inline-block text-left">
                    <div>
                        <MenuButton v-if="authStore.user"
                            class="h-10 cursor-pointer w-10 rounded-full bg-yellow-500 flex items-center justify-center text-white font-bold hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-yellow-500">
                            {{ authStore.user.first_name[0] }} {{ authStore.user.last_name[0] }}
                        </MenuButton>
                    </div>

                    <!-- <transition enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95">
                        <MenuItems
                            class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="px-1 py-1">
                                <MenuItem v-slot="{ active }">
                                <button :class="[
                                    active ? 'bg-yellow-500 text-white' : 'text-gray-900',
                                    'group flex w-full items-center rounded-md cursor-pointer px-2 py-2 text-sm'
                                ]" @click="goToProfile">
                                    Profile
                                </button>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                <button :class="[
                                    active ? 'bg-yellow-500 text-white' : 'text-gray-900',
                                    'group flex w-full cursor-pointer items-center rounded-md px-2 py-2 text-sm'
                                ]" @click="logout">
                                    Logout
                                </button>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition> -->
                </Menu>
            </header>
            <div class="p-2">
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRoute } from 'vue-router';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { useAuthStore } from '@/stores/auth';
import { onMounted } from 'vue';

const authStore = useAuthStore();

// onMounted(() => {
//     authStore.getUser();
// })

defineProps({
    title: {
        type: String,
        required: true
    }
})

const goToProfile = () => {
    // Implement profile navigation logic
    console.log('Navigate to profile')
}

const logout = () => {
    // Implement logout logic
    console.log('Logout user')
}

const route = useRoute();
const links = [
    { name: 'hospital.patients', label: 'VIEW PATIENTS' },
    { name: 'hospital.appointments', label: 'VIEW APPOINTMENTS' },
    { name: 'hospital.add-parent', label: 'REGISTER PARENT' },
    { name: 'hospital.add-baby', label: 'REGISTER BABY' }
];
</script>
