<template>
  <footer class="bg-[#121212] text-[#F8F8FF] py-12 px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Quick Links -->
      <div>
        <h3 class="text-xl font-bold mb-4 text-[#04A699]">Quick Links</h3>
        <ul class="space-y-2">
          <li>
            <router-link to="/" class="hover:text-[#04A699] transition duration-300">Home</router-link>
          </li>
          <li>
            <router-link to="/about-us" class="hover:text-[#04A699] transition duration-300">About Us</router-link>
          </li>
          <li>
            <router-link to="/contact-us" class="hover:text-[#04A699] transition duration-300">Contact Us</router-link>
          </li>
          <li>
            <router-link to="/vaccinations" class="hover:text-[#04A699] transition duration-300">Vaccinations</router-link>
          </li>
          <li>
            <router-link to="/clinics" class="hover:text-[#04A699] transition duration-300">Clinics Near You</router-link>
          </li>
          <li>
            <router-link to="/questions" class="hover:text-[#04A699] transition duration-300">FAQ</router-link>
          </li>
        </ul>
      </div>

      <!-- Contact Us -->
      <div>
        <h3 class="text-xl font-bold mb-4 text-[#04A699]">Contact Us</h3>
        <ul class="space-y-2">
          <li>
            <router-link to="mailto:support@ivyimmunization.com" class="hover:text-[#04A699] transition duration-300">
              support@ivyimmunization.com
            </router-link>
          </li>
          <li>
            <router-link to="tel:+1234567890" class="hover:text-[#04A699] transition duration-300">
              +1 (234) 567-890
            </router-link>
          </li>
          <li>
            <router-link to="/contact-us" class="hover:text-[#04A699] transition duration-300">
              123 Health Lane, Tech City, TX 12345
            </router-link>
          </li>
        </ul>
      </div>

      <!-- Follow Us -->
      <div>
        <h3 class="text-xl font-bold mb-4 text-[#04A699]">Follow Us</h3>
        <div class="flex space-x-4">
          <router-link to="#" class="text-[#F8F8FF] hover:text-[#04A699] transition duration-300">
            <i class="fab fa-facebook fa-2x"></i>
          </router-link>
          <router-link to="#" class="text-[#F8F8FF] hover:text-[#04A699] transition duration-300">
            <i class="fab fa-twitter fa-2x"></i>
          </router-link>
          <router-link to="#" class="text-[#F8F8FF] hover:text-[#04A699] transition duration-300">
            <i class="fab fa-instagram fa-2x"></i>
          </router-link>
          <router-link to="#" class="text-[#F8F8FF] hover:text-[#04A699] transition duration-300">
            <i class="fab fa-whatsapp fa-2x"></i>
          </router-link>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="text-center mt-8 border-t border-[#02343B] pt-8">
      <p class="text-sm text-[#F8F8FF]/80">
        &copy; {{ new Date().getFullYear() }} IVY Immunization. All rights reserved.
      </p>
    </div>
  </footer>
</template>

<script setup>
// No reactive state or logic is needed for this component, so <script setup> is minimal.
</script>