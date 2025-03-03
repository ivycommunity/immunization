<script setup lang="ts">
import Sidebar from '@/components/Hospital/Sidebar.vue';
import { ref } from 'vue'
import { CalendarIcon } from 'lucide-vue-next'

const form = ref({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    gender: '',
    role: '',
    nationality: '',
    nationalId: '',
    dateOfBirth: '',
    address: '',
    maritalStatus: '',
    nextOfKin: '',
    nextOfKinContact: '',
    children: ''
})

const submitForm = () => {
    // Here you would typically send the form data to your backend
    console.log('Form submitted:', form.value)

    // You could add form validation here

    // Reset form after submission if needed
    // form.value = {
    //   firstName: '',
    //   lastName: '',
    //   ...
    // }
}

</script>

<template>
    <Sidebar title="Add Guardian">
        <div class="min-h-screen bg-blue-50 p-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form @submit.prevent="submitForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <div>
                                <label for="firstName" class="block text-sm text-gray-600 mb-1">First Name</label>
                                <input id="firstName" v-model="form.firstName" type="text"
                                    placeholder="Enter Parent's First Name"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>

                            <div>
                                <label for="lastName" class="block text-sm text-gray-600 mb-1">Last Name</label>
                                <input id="lastName" v-model="form.lastName" type="text"
                                    placeholder="Enter Parent's Last Name"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>

                            <div>
                                <label for="email" class="block text-sm text-gray-600 mb-1">Email Address</label>
                                <input id="email" v-model="form.email" type="email"
                                    placeholder="Enter Parent's Email Address"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>

                            <div>
                                <label for="phone" class="block text-sm text-gray-600 mb-1">Phone Number</label>
                                <input id="phone" v-model="form.phone" type="tel"
                                    placeholder="Enter Parent's Phone Number"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
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
                                <label for="role" class="block text-sm text-gray-600 mb-1">Role</label>
                                <select id="role" v-model="form.role" type="text"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option value="">Select Role</option>
                                    <option value="">Automatic</option>
                                </select>
                            </div>

                            <div>
                                <label for="nationality" class="block text-sm text-gray-600 mb-1">Nationality</label>
                                <input id="nationality" v-model="form.nationality" type="text"
                                    placeholder="Enter Parent's Nationality"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="space-y-4">
                            <div>
                                <label for="nationalId" class="block text-sm text-gray-600 mb-1">National ID</label>
                                <input id="nationalId" v-model="form.nationalId" type="text"
                                    placeholder="Enter Parent's national ID"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>

                            <div>
                                <label for="dateOfBirth" class="block text-sm text-gray-600 mb-1">Date of
                                    Birth</label>
                                <div class="relative">
                                    <input id="dateOfBirth" v-model="form.dateOfBirth" type="date"
                                        class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required />
                                </div>
                            </div>

                            <div>
                                <label for="address" class="block text-sm text-gray-600 mb-1">Address</label>
                                <input id="address" v-model="form.address" placeholder="Enter Parent's Address"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>

                            <div>
                                <label for="maritalStatus" class="block text-sm text-gray-600 mb-1">Marital
                                    Status</label>
                                <select id="maritalStatus" v-model="form.maritalStatus"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option value="">Select Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                            </div>

                            <div>
                                <label for="nextOfKin" class="block text-sm text-gray-600 mb-1">Next of Kin</label>
                                <input id="nextOfKin" v-model="form.nextOfKin" type="text"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>

                            <div>
                                <label for="nextOfKinContact" class="block text-sm text-gray-600 mb-1">Next of Kin
                                    Contact</label>
                                <input id="nextOfKinContact" v-model="form.nextOfKinContact" type="tel"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>

                            <div>
                                <label for="children" class="block text-sm text-gray-600 mb-1">Number of Children
                                    (Optional)</label>
                                <input id="children" v-model="form.children" type="number" min="0"
                                    class="w-full p-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
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