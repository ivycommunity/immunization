<script>
import { defineComponent } from 'vue'
import Navbar from './NavBar.vue'
import Footer from './Footer.vue'

export default defineComponent({
    name: 'LandingsLayout',
    components: {
        Navbar,
        Footer
    }
})
</script>

<template>
    <div class="landing-layout">
        <Navbar />
        
        <main class="mt-20">
            <slot></slot>
        </main>
        
        <Footer />
    </div>
</template>