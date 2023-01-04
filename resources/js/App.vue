<template>
    <router-view />

    <Toast />

</template>

<script>

import Toast from 'primevue/toast';

export default {

    components: {
        Toast,
    },

    beforeMount() {
        
    }
}
</script>

