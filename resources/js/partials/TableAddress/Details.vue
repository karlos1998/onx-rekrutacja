<template>


    <Dialog 
    @show="$emit('visibleChanges', true)" 
    @hide="$emit('visibleChanges', false)"
    :modal="true" header="Details" v-model:visible="isVisible" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}"
        >

        <div>

            <div class="col-12">
                <div class="p-inputgroup">
                    <Button @click="saveFriendlyName" :icon="{
                        'pi': true,
                        'pi-check':!friendlyNameError && !friendlyNameProcessing,
                        'pi-times':friendlyNameError && !friendlyNameProcessing,
                        'pi-spinner pi-spin': friendlyNameProcessing
                    }" :class="{
                        'p-button-success':!friendlyNameError,
                        'p-button-danger': friendlyNameError,
                    }"/>
                    <InputText v-model="friendly_name" placeholder="Friendly name"/>
                </div>
            </div>
            
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

import InputText from 'primevue/inputtext';

export default {
    props: {
        show: Boolean,
        data: Object,
    },

    components:{
        Dialog,
        Button,
        AutoComplete,
        InputText
    },
    data() {
        return {
            isVisible: false,
            friendly_name:'',

            friendlyNameProcessing: false,
            friendlyNameError:false,
        }
    },

    watch: {
        show() {
            console.log('show details watch', this.show)
            this.isVisible = this.show
        },
        data() {
            console.log('data details', this.data)
        },

        'data.friendly_name' () {
            console.log('friendly name set..' , this.data.friendly_name)
            this.friendly_name = this.data.friendly_name
        }
    },

    computed: {

    },

    methods: {
        saveFriendlyName() {

            this.friendlyNameError = false
            this.friendlyNameProcessing = true

            api
            .patch(`address/${this.data.id}`, {
                friendly_name:this.friendly_name
            })
            .then( (response) => {
                console.log(response.data.data)
                this.data.friendly_name = this.friendly_name
            })
            .catch( () => {
                console.log('update catch')
                this.friendlyNameError = true
            })
            .finally(() => {
                this.friendlyNameProcessing = false
            })
        }
    }
}
</script>

