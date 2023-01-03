<template>
    <router-view />
</template>

<script>

import { useUserStore } from '@/stores/user'

export default {

    async beforeMount() {
        console.log('beforeMount - App.vue')
        const user = useUserStore()
        await user.init()
    }
}
</script>