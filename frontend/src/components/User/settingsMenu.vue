<script setup>
  import { 
    UserCircleIcon, 
    BellIcon, 
    EyeIcon, 
    ShieldCheckIcon, 
    SpeakerWaveIcon, 
    LanguageIcon,
    ChevronRightIcon 
  } from '@heroicons/vue/24/outline'
  
  const menuItems = [
    {
      label: 'Account',
      to: `/user/profile/`,
      icon: UserCircleIcon
    },
    {
      label: 'Notification',
      to: `/user/profile/`,
      icon: BellIcon
    },
    {
      label: 'Appearance',
      to: `/user/profile/`,
      icon: EyeIcon
    },
    {
      label: 'Privacy & Security',
      to: `/user/profile/`,
      icon: ShieldCheckIcon
    },
    {
      label: 'Sound',
      to: `/user/profile/`,
      icon: SpeakerWaveIcon
    },
    {
      label: 'Language',
      to: `/user/profile/`,
      icon: LanguageIcon
    }
  ]
</script>

<template>
    <div class="w-full mx-auto">
      <nav class="py-2">
        <ul class="space-y-1">
          <li v-for="(item, index) in menuItems" :key="index">
            <router-link 
              :to="item.to.concat(item.label.toLowerCase())"
              class="flex items-center px-4 py-3 text-[#56428F] hover:bg-[#F8F4F8] transition-colors duration-200"
            >
              <component :is="item.icon" class="h-5 w-5 text-[#56428F]/60 mr-3" aria-hidden="true" />
              <span class="font-medium">{{ item.label }}</span>
              <ChevronRightIcon class="h-5 w-5 text-gray-400 ml-auto" aria-hidden="true" />
            </router-link>
          </li>
        </ul>
      </nav>
    </div>
</template>