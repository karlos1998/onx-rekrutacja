<template>

    <Menubar></Menubar>

    <TableAddress></TableAddress>

</template>


<script>

import Menubar from '../components/Menubar.vue'

import TableAddress from '../partials/TableAddress/Table.vue'

export default {
    components:{
        Menubar,
        TableAddress,
    }
}
</script>