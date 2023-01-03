<template>


    <Dialog 
    @show="$emit('visibleChanges', true)" 
    @hide="$emit('visibleChanges', false)"
    :modal="true" header="Find Address" v-model:visible="isVisible" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}"
        >

        <div v-if="addressIsSelected">
            <div v-for="(val, key) in {street:'Street name', houseNumber: 'House number', city: 'City', zip:'Zip Code'}" class="field col-12">
                <div>{{val}}</div>
                <b>{{selected[key]}}</b>
            </div>
            
        </div>
        <AutoComplete 
        v-else
        v-model="selected" 
        :suggestions="filtered" 
        @complete="searchAddress($event)" 
        style="width:100%"
        optionLabel="name" />
        

        <template  v-if="addressIsSelected" #footer>
            <Button label="Cancel" icon="pi pi-times" @click="show = false" class="p-button-text"/>
            <Button label="Find Again" icon="pi pi-check" @click="selected = null" class="p-button-text" />
            <Button label="Submit" icon="pi pi-check" @click="show = false" autofocus />
        </template>
        <template v-else #footer>
            <Button label="Cancel" icon="pi pi-times" @click="show = false" class="p-button-text"/>
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
    },

    components:{
        Dialog,
        Button,
        AutoComplete,
    },
    data() {
        return {
            isVisible: false,

            selected: null,

            filtered: [],

        }
    },

    watch: {
        show() {
            console.log('watch show...')
            this.isVisible = this.show
        },
        selected(v) {
            console.log('selected', v)
        }
    },

    computed: {
        addressIsSelected() {
            return this.selected && this.selected.city && this.selected.name
        }
    },

    methods: {
        searchAddress(event) {
            console.log('searchAddress,,,', event)
            setTimeout(() => {

                if (event.query.trim().length) {
                    axios
                    .get("https://address-autocomplete-pl-stage.placematic.pl/1.0/suggest/address", {
                        params: {
                            query: event.query,
                            approximate:'true',
                            approximationRange:'10',
                            outputSchema:'basic',
                            sortBy:'populationClass',
                            apiKey:'apiKey'
                        }
                    })
                    .then((response) => {
                        console.log(response.data)
                        this.filtered = response.data.map((r) => {
                            return {
                                ...{name: r.city + ', ' + r.street + ' ' + r.houseNumber},
                                ...r
                            }
                        });  
                    })
                    .catch((err) => console.log(err));
                    
                } else {
                    this.filtered = []
                }
                
            }, 250);
        }
    }
}
</script>

<style>
.p-autocomplete-input{
    width: 100%;
  }
  </style>