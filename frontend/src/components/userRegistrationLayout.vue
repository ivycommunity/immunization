<template>
    <div class="default-layout">
        <Topbar :title="topBartitle" />
        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script>
    import Topbar from '@/components/registrationTopBar.vue';
    export default {
        name: 'userRegistrationLayout',
        components: {
            Topbar,
        },
        props: {
            topBartitle: {
                type: String,
                default: 'IVY Immunization',
            },
        },
    };
</script>

  