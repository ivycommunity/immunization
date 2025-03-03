<template>
  <NavBar />
  <div class="mt-28 min-h-screen bg-[#02343B] text-[#F8F8FF]">
    <section class="py-20 px-6 text-center">
      <h1 class="text-5xl font-bold mb-4">
        Track Your Child's Vaccinations with <span class="text-[#04A699]">IVY Immunization</span>
      </h1>
      <p class="text-xl mb-8">
        Easy, reliable, and up-to-date vaccination tracking from birth to adulthood.
      </p>
      <button class="bg-[#04A699] text-[#F8F8FF] px-8 py-3 rounded-lg font-semibold hover:bg-[#038C7F] transition duration-300">
        Get Started
      </button>
    </section>

    <section class="bg-[#F8F8FF] py-16 px-6">
      <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-12">Why Choose IVY Immunization?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="bg-[#04A699] p-6 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
              📅
            </div>
            <h3 class="text-xl text-[#121212]/80 font-semibold mb-2">Automated Vaccination Schedule</h3>
            <p class="text-[#121212]/80">Never miss a vaccination with automated reminders.</p>
          </div>
          <div class="text-center">
            <div class="bg-[#04A699] p-6 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
              🔔
            </div>
            <h3 class="text-xl text-[#121212]/80 font-semibold mb-2">Reminder Notifications</h3>
            <p class="text-[#121212]/80">Get timely alerts for upcoming vaccinations.</p>
          </div>
          <div class="text-center">
            <div class="bg-[#04A699] p-6 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
              📄
            </div>
            <h3 class="text-xl text-[#121212]/80 font-semibold mb-2">Downloadable Records</h3>
            <p class="text-[#121212]/80">Access and share vaccination records anytime.</p>
          </div>
          <div class="text-center">
            <div class="bg-[#04A699] p-6 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
              �
            </div>
            <h3 class="text-xl text-[#121212]/80 font-semibold mb-2">Easy Clinic Locator</h3>
            <p class="text-[#121212]/80">Find nearby clinics for vaccinations.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-16 px-6">
      <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="bg-[#04A699] p-6 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
              1
            </div>
            <h3 class="text-xl font-semibold mb-2">Sign Up</h3>
            <p class="text-[#F8F8FF]/80">Create an account in minutes.</p>
          </div>
          <div class="text-center">
            <div class="bg-[#04A699] p-6 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
              2
            </div>
            <h3 class="text-xl font-semibold mb-2">Add Your Child</h3>
            <p class="text-[#F8F8FF]/80">Enter your child's details and vaccination history.</p>
          </div>
          <div class="text-center">
            <div class="bg-[#04A699] p-6 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center">
              3
            </div>
            <h3 class="text-xl font-semibold mb-2">Track & Manage</h3>
            <p class="text-[#F8F8FF]/80">Stay updated with reminders and records.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="bg-[#F8F8FF] py-16 px-6">
      <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl text-[#04A699] font-bold text-center mb-12">Trusted by Parents Worldwide</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div class="bg-[#02343B] p-6 rounded-lg">
            <p class="text-[#F8F8FF]/80 mb-4">"IVY Immunization has made managing my child's vaccinations so much easier. The reminders are a lifesaver!"</p>
            <p class="font-semibold">— Sarah L.</p>
          </div>
          <div class="bg-[#02343B] p-6 rounded-lg">
            <p class="text-[#F8F8FF]/80 mb-4">"I love how I can download and share vaccination records with schools and doctors effortlessly."</p>
            <p class="font-semibold">— James T.</p>
          </div>
          <div class="bg-[#02343B] p-6 rounded-lg">
            <p class="text-[#F8F8FF]/80 mb-4">"The clinic locator feature is amazing. It helped me find a nearby clinic quickly."</p>
            <p class="font-semibold">— Emily R.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 px-6 text-center">
      <h2 class="text-4xl font-bold mb-8">Ready to Get Started?</h2>
      <button class="bg-[#04A699] text-[#F8F8FF] px-8 py-3 rounded-lg font-semibold hover:bg-[#038C7F] transition duration-300">
        Sign Up Now
      </button>
    </section>
  </div>
  <Footer />
</template>

<script setup>
import NavBar from '@/components/NavBar.vue';
import Footer from '@/components/Footer.vue';

</script>