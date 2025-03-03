<script setup>
import Sidebar from '@/components/Hospital/Sidebar.vue';
import { ref } from 'vue'
import { CalendarIcon } from 'lucide-vue-next'

const form = ref({
    firstName: '',
    lastName: '',
    guardian: '',
    gender: '',
    dateOfBirth: '',
    nationality: ''
})

const submitForm = () => {
    // Here you would typically send the form data to your backend
    console.log('Form submitted:', form.value)

    // You could add form validation here

    // Reset form after submission if needed
    // form.value = {
    //   firstName: '',
    //   lastName: '',
    //   guardian: '',
    //   gender: '',
    //   dateOfBirth: '',
    //   nationality: ''
    // }
}

</script>

<template>
    <Sidebar title="Add Baby">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form @submit.prevent="submitForm">
                    <div class="space-y-4">
                        <div>
                            <label for="firstName" class="block text-sm text-gray-600 mb-1">First Name</label>
                            <input id="firstName" v-model="form.firstName" type="text"
                                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter Baby's First Name" required />
                        </div>

                        <div>
                            <label for="lastName" class="block text-sm text-gray-600 mb-1">Last Name</label>
                            <input id="lastName" v-model="form.lastName" type="text"
                                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter Baby's Last Name" required />
                        </div>

                        <div>
                            <label for="guardian" class="block text-sm text-gray-600 mb-1">Guardian</label>
                            <select name="guardian"
                                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                v-model="form.guardian" id="guardian" required>
                                <option value="" class="hidden">Select Guardian</option>
                                <option value="">Guardian 1</option>
                            </select>

                        </div>

                        <div>
                            <label for="gender" class="block text-sm text-gray-600 mb-1">Gender</label>
                            <select id="gender" v-model="form.gender"
                                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="dateOfBirth" class="block text-sm text-gray-600 mb-1">Date of Birth</label>
                            <div class="relative">
                                <input id="dateOfBirth" v-model="form.dateOfBirth" type="date"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                                <CalendarIcon
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
                            </div>
                        </div>

                        <div>
                            <label for="nationality" class="block text-sm text-gray-600 mb-1">Nationality</label>
                            <select id="nationality" v-model="form.nationality" type="text"
                                class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="">Select Nationality</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center">
                        <button type="submit"
                            class="bg-blue-600 text-white px-8 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Sidebar>
</template>