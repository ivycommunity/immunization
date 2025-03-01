<template>
    <Sidebar title="Patiens">
        <!-- Stats Cards -->
        <div class="grid grid-cols-3 gap-4 p-4">
            <Card title="Number of Patients" number="2000" />
            <Card title="Number of Appointments Today" number="20" class="text-blue-500" />
            <Card title="Missed Appointments" number="1" class="text-red-500" />
        </div>

        <!-- Search and Filter -->
        <div class="px-4 py-2">
            <div class="flex items-center bg-white rounded-lg shadow p-2">
                <input type="text" placeholder="Search Patient" class="flex-1 px-4 py-2 outline-none" />
                <button class="p-2">
                    <SearchIcon class="h-5 w-5 text-gray-500" />
                </button>
                <div class="border-l pl-2 flex items-center">
                    <button class="px-3 py-1 text-gray-700 flex items-center">
                        Filter
                        <ChevronDownIcon class="h-4 w-4 ml-1" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Date Navigation -->
        <div class="flex justify-between items-center px-4 py-3">
            <button class="bg-green-500 text-white px-4 py-1 rounded-md">
                TODAY
            </button>
            <div class="flex items-center space-x-2">
                <button>
                    <ChevronLeftIcon class="h-5 w-5" />
                </button>
                <span>16 May, 2024</span>
                <button>
                    <ChevronRightIcon class="h-5 w-5" />
                </button>
            </div>
            <button class="bg-green-500 text-white px-4 py-1 rounded-md">
                EXPORT
            </button>
        </div>

        <!-- Table -->
        <div class="flex-1 overflow-auto p-4">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead>
                    <tr class="border-b">
                        <th class="py-3 px-4 text-left">#</th>
                        <th class="py-3 px-4 text-left">Patient Name</th>
                        <th class="py-3 px-4 text-left">Last Visit Date</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="i in 5" :key="i" class="border-b">
                        <td class="py-3 px-4">{{ i }}</td>
                        <td class="py-3 px-4"></td>
                        <td class="py-3 px-4"></td>
                        <td class="py-3 px-4"></td>
                        <td class="py-3 px-4"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 flex justify-between items-center text-sm">
            <div>1-5 of 25</div>
            <div class="flex items-center space-x-2">
                <span>Rows per page:</span>
                <select class="border rounded px-2 py-1">
                    <option>5</option>
                    <option>10</option>
                    <option>25</option>
                </select>
                <button class="p-1">
                    <ChevronLeftIcon class="h-5 w-5" />
                </button>
                <button class="p-1">
                    <ChevronRightIcon class="h-5 w-5" />
                </button>
            </div>
        </div>
    </Sidebar>
</template>

<script setup>
import { ref } from 'vue'
import { SearchIcon, ChevronDownIcon, ChevronLeftIcon, ChevronRightIcon } from 'lucide-vue-next'
import Sidebar from '@/components/Hospital/Sidebar.vue';
import Card from '@/components/Hospital/Card.vue';

// You can add reactive data here
const patients = ref([
    // Your patient data would go here
])
</script>