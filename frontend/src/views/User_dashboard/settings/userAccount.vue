<script setup>
    import { useRouter } from 'vue-router';
    import userStore from '@/stores/userStore';
    import profileComponent from '@/components/User/profileComponent.vue';
    import userLayout from '@/components/User/userLayout.vue';
    import { ref, computed, onMounted } from "vue";
    import { default as aButton } from "@/components/User/Button.vue";

    const router = useRouter();
    const store = userStore();

    const USER = ref({
        first_name: "",
        last_name: "",
        email: "",
        phone_number: "",
        date_of_birth: "",
        address: "",
        marital_status: "",
        next_of_kin: "",
        next_of_kin_contact: "",
        no_of_children: "",
    });
    const isLoading = ref(false);
    const canEdit = ref(false);

    onMounted(() => {
        if (!store.isAuthenticated) {
            router.push({ name: "userLogin" });
        } else {
            USER.value = JSON.parse(localStorage.getItem("user_data") || '{}');
        }
    });

    const userFullName = computed(() => USER.value.first_name + " " + USER.value.last_name);

    const setEdit = () => {
        canEdit.value = !canEdit.value;
    }

     // Function to filter out specific fields
     const filteredUserData = computed(() => {
        const filtered = {};
        for (const [key, value] of Object.entries(USER.value)) {
            if (!['id', 'national_id', 'role', 'no_of_children'].includes(key)) {
                filtered[key] = value;
            }
        }
        return filtered;
    });

    const handleUpdate = async () => {
        isLoading.value = true;
        try {
            await store.update({
                first_name: USER.value.first_name,
                last_name: USER.value.last_name,
                email: USER.value.email,
                phone_number: USER.value.phone_number,
                date_of_birth: USER.value.date_of_birth,
                address: USER.value.address,
                marital_status: USER.value.marital_status,
                next_of_kin: USER.value.next_of_kin,
                next_of_kin_contact: USER.value.next_of_kin_contact,
                no_of_children: USER.value.no_of_children
            });
        } catch (error) {
            router.push(`/user/error/${'416'}`);
        } finally {
            isLoading.value = false;
            setEdit();
        }
    };
</script>

<template>
    <userLayout 
        back-to="/user/profile" 
        :topBartitle="'Account'"
        :with-bottom-bar ="true"
    >
        <profileComponent :user-full-name="userFullName" :user-email="USER.email" :user-phone="USER.phone_number" :profile-edit="canEdit" />
        
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
                            :class="`${canEdit? 'text-[#432C81] focus:outline-none focus:ring-2 focus:ring-[#432C81] focus:border-[#432C81] bg-gray-100': 'text-[#432C81]/80'}`"
                        ></textarea>
                    </template>
                    <template v-else>
                        <input 
                            :type="key === 'email' ? 'email' : key === 'date_of_birth' ? 'date' : key === 'no_of_children' ? 'number' : 'text'" 
                            :id="key" 
                            v-model="USER[key]" 
                            :readonly="!canEdit"
                            class="w-full p-2 border rounded border-none outline-none"
                            :class="`${canEdit? 'text-[#432C81] focus:outline-none focus:ring-2 focus:ring-[#432C81] focus:border-[#432C81] bg-gray-100': 'text-[#432C81]/80'}`"
                        />
                    </template>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <div v-if="canEdit" class="w-full flex flex-col-reverse gap-4">
                    <aButton 
                        @click="handleUpdate"  
                        text="Save" 
                        :is-loading="isLoading" 
                    />
                    <aButton 
                        @click="setEdit"  
                        text="Cancel"
                        variant="secondary"
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