<script setup>
  import { useRouter } from 'vue-router';
  
  // Get router instance
  const router = useRouter();
  
  // Define props
  const props = defineProps({
    baby: {
      type: Object,
      required: true
    }
  });
  
  // Navigation function
  const navigateToChildRecord = () => {
    router.push(`/user/records/babies/${props.baby.id}`); // /user/records/babies
  };
</script>

<template>
    <div 
      class="w-full mx-auto bg-white rounded-2xl shadow-md p-5 my-4 cursor-pointer hover:shadow-lg transition-shadow duration-200"
      @click="navigateToChildRecord"
    >
        <div class="flex items-center">
            <!-- Avatar circle -->
            <div class="relative w-14 h-14 rounded-full flex-shrink-0 flex items-center justify-center" 
                :class="baby.gender === 'male' ? 'bg-blue-200' : 'bg-pink-200'"
            >
                <span class="text-xl font-medium" 
                        :class="baby.gender === 'male' ? 'text-blue-700' : 'text-pink-700'">
                    {{ baby.first_name.charAt(0).toUpperCase() }}
                </span>
            </div>
            
            <!-- Child name -->
            <div class="ml-4">
                <h2 class="text-purple-800 text-xl font-medium">{{ baby.first_name }}</h2>
            </div>
        </div>
        
        <!-- Vaccination info -->
        <div class="flex justify-between items-center gap-4 mt-4 text-gray-600">
            <div>
                <p>Last Vaccine received: {{ baby.last_vaccine_received }}</p>
            </div>
            <div>
                <p>Next Vaccines: {{ baby.next_appointment_date }}</p>
            </div>
        </div>
    </div>
</template>