<script>
  export default {
    name: 'registrationError',
  };
</script>

<template>
    <div >
        <a 
            href="/user/signin"
            class="flex flex-wrap items-center justify-between h-dvh p-6 box-border bg-white"   
        >
            <div 
                class="w-full max-w-md mx-auto mb-8"
            >
                <img 
                src="@/assets/userI/Goodies-Error1.png"
                alt="People illustrations" 
                class="w-full h-auto object-contain"
                >
                <div class="flex flex-col items-center justify-center text-center">
                    <h3 class="text-[#432C81] text-lg font-semibold">Oops! No Internet Connection</h3>
                    <p class="text-[#82799D] text-sm">Click anywhere on screen to try again</p>
                </div>
            </div>
        </a>
    </div>
</template>