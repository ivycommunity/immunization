<script setup>
import { useRouter } from 'vue-router';
import userStore from '@/stores/userStore';
import profileComponent from '@/components/User/profileComponent.vue';
import userLayout from '@/components/User/userLayout.vue';
import { ref, computed, onMounted } from "vue";
import { default as aButton } from "@/components/User/Button.vue";

const router = useRouter();
const store = userStore();

const USER = ref({});
const isLoading = ref(false);
const canEdit = ref(false);
const errors = ref({});

onMounted(() => {
    if (!store.isAuthenticated) {
        router.push({ name: "userLogin" });
    } else {
        // Initialize with store data
        USER.value = { ...store.user };
    }
});

const userFullName = computed(() => `${USER.value.first_name || ''} ${USER.value.last_name || ''}`.trim());

const setEdit = () => {
    canEdit.value = !canEdit.value;
    // Reset errors when toggling edit mode
    errors.value = {};
}

const filteredUserData = computed(() => {
    const filtered = {};
    const excludedFields = ['id', 'national_id', 'role', 'created_at', 'updated_at'];
    
    for (const [key, value] of Object.entries(USER.value)) {
        if (!excludedFields.includes(key)) {
            // Clone the value to avoid modifying the original
            filtered[key] = value;
            
            // Format date for display only
            if (key === 'date_of_birth' && value) {
                const date = new Date(value);
                if (!isNaN(date)) {
                    filtered[key] = date.toISOString().split('T')[0]; // YYYY-MM-DD format for input[type="date"]
                }
            }
        }
    }
    return filtered;
});

const handleUpdate = async () => {
    isLoading.value = true;
    errors.value = {};
    
    try {
        // // Prepare the update payload with only changed fields
        // const payload = {
        //     first_name: USER.value.first_name,
        //     last_name: USER.value.last_name,
        //     email: USER.value.email,
        //     phone_number: USER.value.phone_number,
        //     date_of_birth: USER.value.date_of_birth, // Already in correct format
        //     address: USER.value.address,
        //     marital_status: USER.value.marital_status,
        //     next_of_kin: USER.value.next_of_kin,
        //     next_of_kin_contact: USER.value.next_of_kin_contact,
        //     no_of_children: parseInt(USER.value.no_of_children) || 0
        // };

        // await store.update(payload);
        
        // // Exit edit mode on success
        // canEdit.value = false;
    // Prepare payload with proper data types
    const payload = {
      first_name: USER.value.first_name,
      last_name: USER.value.last_name,
      email: USER.value.email,
      phone_number: USER.value.phone_number,
      date_of_birth: USER.value.date_of_birth, // Ensure this is in YYYY-MM-DD format
      address: USER.value.address,
      marital_status: USER.value.marital_status,
      next_of_kin: USER.value.next_of_kin,
      next_of_kin_contact: USER.value.next_of_kin_contact,
      no_of_children: Number(USER.value.no_of_children) || 0
    };

    const result = await store.update(payload);
    
    // Success feedback
    console.log(result.message);
    canEdit.value = false;
        
    } catch (error) {
        if (error.response?.status === 422) {
            // Handle validation errors
            errors.value = error.response.data.errors || {};
        } else {
            // Show error message but don't redirect
            console.error("Update failed:", error);
            // Optionally show a toast/notification
        }
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <userLayout 
        back-to="/user/profile" 
        :topBartitle="'Account'"
        :with-bottom-bar="true"
    >
        <profileComponent 
            :user-full-name="userFullName" 
            :user-email="USER.email" 
            :user-phone="USER.phone_number" 
            :profile-edit="canEdit" 
        />
        
        <div class="max-w-3xl mx-auto p-4">
            <div v-for="(value, key) in filteredUserData" :key="key" class="grid grid-cols-12 gap-2 mb-4 items-center">
                <div class="col-span-5 text-left">
                    <label :for="key" class="block text-[#432C81] font-medium">
                        {{ key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                    </label>
                </div>
                <div class="col-span-1 text-center font-medium">:</div>
                <div class="col-span-6 text-right">
                    <template v-if="key === 'address'">
                        <textarea 
                            :id="key" 
                            v-model="USER[key]" 
                            :readonly="!canEdit" 
                            class="w-full p-2 border rounded resize-none border-none outline-none"
                            :class="{
                                'text-[#432C81] focus:ring-2 focus:ring-[#432C81] bg-gray-100': canEdit,
                                'text-[#432C81]/80': !canEdit,
                                'border-red-500': errors[key]
                            }"
                        ></textarea>
                    </template>
                    <template v-else>
                        <input 
                            :type="key === 'email' ? 'email' : 
                                   key === 'date_of_birth' ? 'date' : 
                                   key === 'no_of_children' ? 'number' : 'text'" 
                            :id="key" 
                            v-model="USER[key]" 
                            :readonly="!canEdit"
                            class="w-full p-2 border rounded border-none outline-none"
                            :class="{
                                'text-[#432C81] focus:ring-2 focus:ring-[#432C81] bg-gray-100': canEdit,
                                'text-[#432C81]/80': !canEdit,
                                'border-red-500': errors[key]
                            }"
                        />
                    </template>
                    <span v-if="errors[key]" class="text-red-500 text-xs">{{ errors[key][0] }}</span>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <div v-if="canEdit" class="w-full flex flex-col-reverse gap-4">
                    <aButton 
                        @click="handleUpdate"  
                        text="Save" 
                        :is-loading="isLoading" 
                        :disabled="isLoading"
                    />
                    <aButton 
                        @click="setEdit"  
                        text="Cancel"
                        variant="cancel"
                        :disabled="isLoading"
                    />
                </div>
                <aButton 
                    v-else
                    @click="setEdit"  
                    text="Edit"
                    variant="secondary"
                />
            </div>
        </div>
    </userLayout>
</template>