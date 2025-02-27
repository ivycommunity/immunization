<script>
export default {
    name: 'registrationTopBar',
    props: {
        scrollY: {
            type: Number,
            default: 0
        },
        headerText: {
            type: String,
            default: 'Login'
        }
    },
    data() {
        return {
            isOpen: false,
            isVisible: true,
            lastScrollY: 0,
            scrollThreshold: 50, // Add a threshold for scroll detection
        };
    },
    watch: {
        scrollY: {
            handler(newValue) {
                // Calculate the difference between the current and last scroll position
                const scrollDifference = newValue - this.lastScrollY;

                // Hide the top bar only if scrolling up beyond the threshold
                if (scrollDifference < -this.scrollThreshold) {
                    this.isVisible = false;
                }
                // Show the top bar only if scrolling down beyond the threshold
                else if (scrollDifference > this.scrollThreshold) {
                    this.isVisible = true;
                }

                // Update the last scroll position
                this.lastScrollY = newValue;
            },
            immediate: true
        }
    },
    methods: {
        toggleMenu() {
            this.isOpen = !this.isOpen;
        }
    }
};
</script>

<template>
    <div>
        <!-- Fixed top bar -->
        <div
            class="fixed top-0 left-0 right-0 flex items-center justify-between h-16 p-6 box-border bg-white z-10"
            :class="{
                'shadow-md': isVisible,
                'shadow-none': !isVisible,
                'translate-y-0': isVisible,
                '-translate-y-full': !isVisible
            }"
            style="transition: transform 0.3s ease-in-out;"
        >
            <div class="flex items-center">
                <img
                    src="@/assets/userI/icons/arrow-left.svg"
                    alt="Back"
                    class="h-5 w-5 cursor-pointer"
                    style="filter: invert(50%) sepia(20%) saturate(100%) hue-rotate(200deg) brightness(100%) contrast(10%);"
                >
            </div>
            
            <!-- Header in the topbar -->
            <div class="w-full text-center">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#432C81]">{{ headerText }}</h2>
            </div>
            
            <!-- Empty div to balance the flex layout -->
            <div class="h-5 w-5"></div>
        </div>
        
        <!-- Spacer to prevent content from hiding behind fixed header -->
        <div class="h-16"></div>
        
        <!-- Secondary header for when top bar is hidden -->
        <div class="w-full text-center mb-4" v-if="!isVisible">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#432C81]">{{ headerText }}</h2>
        </div>
    </div>
</template>