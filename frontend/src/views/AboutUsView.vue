  <template>
    <LandingsLayout>
      <div class="min-h-screen bg-[#02343B] text-[#F8F8FF]">

        <section class="py-20 px-6 text-center">
          <h2 class="text-4xl font-bold mb-8">Our Mission</h2>
          <p class="max-w-2xl mx-auto text-lg leading-relaxed">
            At IVY Immunization, we believe every child deserves a healthy start in life. Our mission is to simplify vaccination tracking for parents, ensuring no child misses a critical vaccine. By providing an easy-to-use platform, we aim to reduce confusion, eliminate missed appointments, and empower parents with reliable, up-to-date information.
          </p>
        </section>
    
        <section class="bg-[#F8F8FF] py-16 px-6">
          <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">The Problem & Our Solution</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div class="bg-[#04A699] p-8 rounded-lg">
                <h3 class="text-2xl font-semibold mb-4">The Problem</h3>
                <p class="text-[#F8F8FF]/80">
                  Parents often struggle to keep track of their child's vaccination schedules, leading to missed appointments, confusion, and unnecessary stress. Without a centralized system, managing vaccination records can be overwhelming and time-consuming.
                </p>
              </div>
              <div class="bg-[#04A699] p-8 rounded-lg">
                <h3 class="text-2xl font-semibold mb-4">Our Solution</h3>
                <p class="text-[#F8F8FF]/80">
                  IVY Immunization provides a seamless platform for parents to track their child's vaccinations from birth to adulthood. With automated schedules, reminder notifications, and downloadable records, we make vaccination management simple, reliable, and stress-free.
                </p>
              </div>
            </div>
          </div>
        </section>
    
        
        <section class="py-16 px-6">
          <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Meet Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

              <div class="bg-[#F8F8FF] p-6 rounded-lg text-center">
                <img src="https://th.bing.com/th?id=OIF.Rz3WiIJDZzwI%2fMu5LV8BLg&w=163&h=180&c=7&r=0&o=5&pid=1.7" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4" />
                <h3 class="text-xl text-[#121212]/80 font-semibold">John Doe</h3>
                <p class="text-[#121212]/80">Co-Founder & CEO</p>
              </div>

              <div class="bg-[#F8F8FF] p-6 rounded-lg text-center">
                <img src="https://th.bing.com/th?id=OIF.Rz3WiIJDZzwI%2fMu5LV8BLg&w=163&h=180&c=7&r=0&o=5&pid=1.7" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4" />
                <h3 class="text-xl text-[#121212]/80 font-semibold">Jane Smith</h3>
                <p class="text-[#121212]/80">Lead Developer</p>
              </div>

              <div class="bg-[#F8F8FF] p-6 rounded-lg text-center">
                <img src="https://th.bing.com/th?id=OIF.Rz3WiIJDZzwI%2fMu5LV8BLg&w=163&h=180&c=7&r=0&o=5&pid=1.7" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4" />
                <h3 class="text-xl text-[#121212]/80 font-semibold">Dr. Emily Brown</h3>
                <p class="text-[#121212]/80">Healthcare Advisor</p>
              </div>
            </div>
          </div>
        </section>
    
        <!-- Partners -->
        <section class="bg-[#F8F8FF] py-16 px-6">
          <div class="max-w-6xl text-[#121212]/80 mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Our Partners</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
              <!-- Partner 1 -->
              <div class="flex items-center justify-center">
                <img src="https://via.placeholder.com/150" alt="Partner Logo" class="w-32" />
              </div>
              <!-- Partner 2 -->
              <div class="flex items-center justify-center">
                <img src="https://via.placeholder.com/150" alt="Partner Logo" class="w-32" />
              </div>
              <!-- Partner 3 -->
              <div class="flex items-center justify-center">
                <img src="https://via.placeholder.com/150" alt="Partner Logo" class="w-32" />
              </div>
              <!-- Partner 4 -->
              <div class="flex items-center justify-center">
                <img src="https://via.placeholder.com/150" alt="Partner Logo" class="w-32" />
              </div>
            </div>
          </div>
        </section>
      </div>
    </LandingsLayout>
  </template>
  
  <script>
  
  import LandingsLayout from '@/components/landingsLayout.vue';

  export default {
    name: 'AboutUs',
    components : {
      LandingsLayout
    }
  };

  </script>
  