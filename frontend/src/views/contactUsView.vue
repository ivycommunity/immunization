<template>
    <div class="min-h-screen bg-[#02343B] text-[#F8F8FF]">
      <section class="py-20 px-6">
        <div class="max-w-6xl mx-auto">
          <h2 class="text-4xl font-bold text-center mb-12">Contact Us</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-[#121212] p-8 rounded-lg">
              <h3 class="text-2xl font-semibold mb-6">Send Us a Message</h3>
              <form @submit.prevent="submitForm">
                <div class="mb-6">
                  <label for="name" class="block text-sm font-medium mb-2">Name</label>
                  <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    class="w-full bg-[#02343B] text-[#F8F8FF] p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#04A699]"
                    required
                  />
                </div>
                <div class="mb-6">
                  <label for="email" class="block text-sm font-medium mb-2">Email</label>
                  <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    class="w-full bg-[#02343B] text-[#F8F8FF] p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#04A699]"
                    required
                  />
                </div>
                <div class="mb-6">
                  <label for="subject" class="block text-sm font-medium mb-2">Subject</label>
                  <input
                    type="text"
                    id="subject"
                    v-model="form.subject"
                    class="w-full bg-[#02343B] text-[#F8F8FF] p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#04A699]"
                    required
                  />
                </div>
                <div class="mb-6">
                  <label for="message" class="block text-sm font-medium mb-2">Message</label>
                  <textarea
                    id="message"
                    v-model="form.message"
                    rows="5"
                    class="w-full bg-[#02343B] text-[#F8F8FF] p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#04A699]"
                    required
                  ></textarea>
                </div>
                <button
                  type="submit"
                  class="bg-[#04A699] text-[#F8F8FF] px-6 py-3 rounded-lg font-semibold hover:bg-[#038C7F] transition duration-300"
                >
                  Send Message
                </button>
              </form>
            </div>
  
            <div class="space-y-8">
              <div>
                <h3 class="text-2xl font-semibold mb-4">Get in Touch</h3>
                <p class="text-[#F8F8FF]/80">We’re here to help! Reach out to us via email, phone, or social media.</p>
              </div>
              <div>
                <h4 class="text-xl font-semibold mb-2">Email</h4>
                <a href="mailto:support@ivyimmunization.com" class="text-[#04A699] hover:underline">
                  support@ivyimmunization.com
                </a>
              </div>
              <div>
                <h4 class="text-xl font-semibold mb-2">Phone</h4>
                <a href="tel:+1234567890" class="text-[#04A699] hover:underline">
                  +1 (234) 567-890
                </a>
              </div>
              <div>
                <h4 class="text-xl font-semibold mb-2">Social Media</h4>
                <div class="flex space-x-4">
                  <a href="#" class="text-[#04A699] hover:text-[#038C7F]">
                    <i class="fab fa-facebook fa-2x"></i>
                  </a>
                  <a href="#" class="text-[#04A699] hover:text-[#038C7F]">
                    <i class="fab fa-twitter fa-2x"></i>
                  </a>
                  <a href="#" class="text-[#04A699] hover:text-[#038C7F]">
                    <i class="fab fa-instagram fa-2x"></i>
                  </a>
                  <a href="#" class="text-[#04A699] hover:text-[#038C7F]">
                    <i class="fab fa-whatsapp fa-2x"></i>
                  </a>
                </div>
              </div>
              <div>
                <h4 class="text-xl font-semibold mb-2">Physical Address</h4>
                <p class="text-[#F8F8FF]/80 mb-2">
                  123 Health Lane<br />
                  Tech City, TX 12345<br />
                  United States
                </p>
                <a
                  href="https://www.google.com/maps"
                  target="_blank"
                  class="text-[#04A699] hover:underline"
                >
                  View on Google Maps
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ContactUs',
    data() {
      return {
        form: {
          name: '',
          email: '',
          subject: '',
          message: '',
        },
      };
    },
    methods: {
      submitForm() {
        // Handle form submission logic here
        console.log('Form submitted:', this.form);
        alert('Thank you for reaching out! We’ll get back to you soon.');
        this.form = { name: '', email: '', subject: '', message: '' }; // Reset form
      },
    },
  };
  </script>
  
  <style scoped>
  @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
  </style>