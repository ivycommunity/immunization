<template>
  <NavBar />
  <div class="mt-28 min-h-screen bg-[#F8F8FF] text-[#121212]/80 py-12 px-6">
    <section class="max-w-6xl mx-auto">
      <h2 class="text-4xl font-bold text-center mb-12">Frequently Asked Questions</h2>
      <div class="space-y-6">
        <div v-for="(faq, index) in faqs" :key="faq.id"
          class="bg-[#F8F8FF] rounded-lg overflow-hidden border border-[#004A69]">
          <button @click="toggleFAQ(index)"
            class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
            <h3 class="text-xl font-semibold">{{ faq.question }}</h3>
            <span class="text-[#04A699] text-2xl">
              {{ activeIndex === index ? '−' : '+' }}
            </span>
          </button>
          <div v-if="activeIndex === index" class="p-6 pt-0">
            <p class="text-[#121212]/80/80">{{ faq.answer }}</p>
          </div>
        </div>
      </div>
    </section>
  </div>
  <Footer />
</template>

<script setup>
import { ref } from 'vue';
import NavBar from '@/components/NavBar.vue';
import Footer from '@/components/Footer.vue';

const activeIndex = ref(null);
const faqs = ref([
  {
    id: 1,
    question: 'What is IVY Immunization?',
    answer:
      'IVY Immunization is a platform designed to help parents track their child’s vaccinations from birth to adulthood. It provides automated schedules, reminders, and downloadable records to ensure no vaccine is missed.',
  },
  {
    id: 2,
    question: 'How do I use the system?',
    answer:
      'Simply sign up for an account, add your child’s details, and start tracking vaccinations. The system will provide automated schedules and reminders to keep you on track.',
  },
  {
    id: 3,
    question: 'Is IVY Immunization free to use?',
    answer:
      'Yes, IVY Immunization is completely free for parents to use. Our goal is to make vaccination tracking accessible to everyone.',
  },
  {
    id: 4,
    question: 'How does IVY Immunization track vaccinations?',
    answer:
      'IVY Immunization uses a combination of user input and automated schedules to track vaccinations. You can manually add vaccines or let the system generate a schedule based on your child’s age.',
  },
  {
    id: 5,
    question: 'Can I download my child’s vaccination record?',
    answer:
      'Yes, you can download your child’s vaccination record as a PDF at any time. This makes it easy to share with schools, doctors, or other healthcare providers.',
  },
  {
    id: 6,
    question: 'How do I update my child’s vaccination information?',
    answer:
      'You can update your child’s vaccination information by logging into your account and editing their profile. Add new vaccines, mark completed doses, or adjust the schedule as needed.',
  },
  {
    id: 7,
    question: 'What if I forget to record a vaccination?',
    answer:
      'No problem! You can add past vaccinations at any time. Simply log the date and details, and the system will update your child’s records accordingly.',
  },
  {
    id: 8,
    question: 'How do I find a clinic nearby?',
    answer:
      'Use our Clinics page to search for nearby vaccination clinics. You can filter by location, type, and services offered to find the best option for your needs.',
  },
]);

const toggleFAQ = (index) => {
  activeIndex.value = activeIndex.value === index ? null : index;
};
</script>