<template>

    <Card style="margin-bottom: 2em">
        <template #title>
            
        </template>

        <template #content>
                

            <div class="field">
                <label for="email" class="block text-900 font-medium mb-2">Email</label>
                <InputText v-model="signupStore.inputs.email" id="email" type="text" class="w-full mb-3"  :class="{'p-invalid': signupStore.validationErrors.email}" />
                <small v-show="signupStore.validationErrors.email" class="p-error">{{ signupStore.validationErrors.email }}</small>
            </div>

        </template>

        <template v-slot:footer>
            <div class="grid grid-nogutter justify-content-between">
                <i></i>
                
                <Button label="Next" @click="nextPage()" :icon="processing ? 'pi pi-spinner pi-spin':'pi pi-angle-right'" icon-pos="right"></Button>
            </div>

            

        </template>

    </Card>


</template>


<script>

import Card from 'primevue/card';

import InputText from 'primevue/inputtext';

import Button from 'primevue/button';

import ProgressSpinner from 'primevue/progressspinner';

import { useSignupStore } from '@/stores/signup'

export default {
    name: 'Email',

    components:{
        Card,
        InputText,
        Button,
        ProgressSpinner,
    },
    
    data() {
        return {
            signupStore: useSignupStore(),
            pageIndex: 1,
            processing: false,
        }
    },
    
    beforeMount() {
        console.log('email vue.')

        if(!this.signupStore.inputs.email) this.signupStore.inputs.email = ''

        if(!this.signupStore.ifIndexValid(this.pageIndex-1)) {
            console.log('previous step not valid...')
            this.$emit('prevPage', {
                pageIndex: this.pageIndex
            }); 
        }
    },

    methods: {
        nextPage() {

            if(this.processing) return

            this.processing = true

            this.signupStore.validationErrors = {}


            if (!this.signupStore.inputs.email.trim()) {
                this.signupStore.validationErrors['email'] = 'Email is required. :)';
                this.signupStore.pageIndexValid(this.pageIndex, false)
                this.processing = false
                return false   
            }

            api
            .get("/emailAvailable", {params: {
                email: this.signupStore.inputs.email
            }})
            .then((response) => {
                this.signupStore.pageIndexValid(this.pageIndex, true)
                this.$emit('nextPage', {pageIndex: this.pageIndex});  
            })
            .catch((err) => {
                this.signupStore.validationErrors['email'] = err.response.data.message
                this.signupStore.pageIndexValid(this.pageIndex, false)
            })
            .finally(() => {
                this.processing = false
            });


            
        },
    },

    
}
</script>
