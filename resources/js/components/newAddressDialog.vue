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
            
            <div>
                <Button label="Cancel" icon="pi pi-times" @click="show = false" class="p-button-text"/>
                <Button label="Find Again" icon="pi pi-check" @click="selected = null" class="p-button-text" />
                <Button label="Submit" :icon="processing ? 'pi pi-spinner pi-spin':'pi pi-angle-right'"  @click="add" autofocus />
            </div>
            <div v-show="addErrror" class="mt-5 p-error">{{ addErrror }}</div>
            
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

import {useAddressesStore} from '@/stores/addresses'

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
            addErrror: '',
            processing: false,
            addressesStore: useAddressesStore(),

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
                    .catch((err) => {
                        console.log(err)
                        this.filtered = []
                        this.$toast.add({severity:'error', summary:'Placematik', detail: 'Failed to fetch addresses from API Placematic', life: 3000});
                    });
                    
                } else {
                    this.filtered = []
                }
                
            }, 250);
        },

        add() {
            this.addErrror = ''

            if(this.processing) return

            this.processing = true

            if(!this.selected || !this.selected.city) {
                this.addErrror = "Something went wrong"
                return console.warn('Add address: is not object')
            }

            api
            .post('/address', this.selected)
            .then((response) => {
                console.log(response.data.data)
                
                console.log('newAddress', response.data.data)

                this.addressesStore.push(response.data.data);
                //TODO . dodac to do tabelki.
                this.$emit('visibleChanges', false)
                this.selected = false
            })
            .catch((err) => {
                console.log(err)
                this.addErrror = err.response.data.message
            })
            .finally(() => {
                this.processing = false
            })
        }
    }
}
</script>

<style>
.p-autocomplete-input{
    width: 100%;
  }
  </style>