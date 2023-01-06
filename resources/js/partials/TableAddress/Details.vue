<template>


    <Dialog 
    @show="$emit('visibleChanges', true)" 
    @hide="$emit('visibleChanges', false)"
    :modal="true" header="Find Address" v-model:visible="isVisible" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}"
        >

        <div>
            <div v-for="(val, key) in {
                    street:'Street name', 
                    houseNumber: 'House number', 
                    city: 'City', 
                    zip:'Zip Code',
                    cityDistricted: 'City Districted',
                    state: 'State',
                    county: 'County',
                    
                }" class="field col-12">
                <div>{{val}}</div>
                <b>{{data[key]}}</b>
            </div>
            
        </div>

        <template #footer>
            <Button label="Hide" icon="pi pi-times" @click="show = false" class="p-button-text"/>
        </template>
    </Dialog>

</template>

<script>
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';

import AutoComplete from 'primevue/autocomplete';


export default {
    props: {
        show: Boolean,
        data: Object,
    },

    components:{
        Dialog,
        Button,
        AutoComplete,
    },
    data() {
        return {
            isVisible: false,
        }
    },

    watch: {
        show() {
            console.log('show details watch', this.show)
            this.isVisible = this.show
        },
        data() {
            console.log('data details', this.data)
        }
    },

    computed: {

    },

    methods: {
        
    }
}
</script>

