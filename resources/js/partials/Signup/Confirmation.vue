<template>

    <Card style="margin-bottom: 2em">
        <template #title>
            
        </template>

        <template #content>
                

            <div class="field col-12">
                <label>Firstname</label>
                <b>{{signupStore.inputs.firstname}}</b>
            </div>

            <div class="field col-12">
                <label>Lastname</label>
                <b>{{signupStore.inputs.lastname}}</b>
            </div>

            <div class="field col-12">
                <label>Email</label>
                <b>{{signupStore.inputs.email}}</b>
            </div>

        </template>

        <template v-slot:footer>
            
            <ProgressBar v-if="creating" mode="indeterminate" style="height: .5em" />
            <div v-else class="grid grid-nogutter justify-content-between">
                <i></i>
                <Button label="Create Account!" @click="createAccount()" icon="pi pi-angle-right" icon-pos="right"></Button>
            </div>

            <div :style="{color:'var(--red-500)'}">{{ createError }}</div>

        </template>

    </Card>


</template>


<script>

import Card from 'primevue/card';

import Button from 'primevue/button';

import { useSignupStore } from '@/stores/signup'

import ProgressBar from 'primevue/progressbar';

export default {
    name: 'Pass',

    components:{
        Card,
        Button,
        ProgressBar,
    },
    
    data() {
        return {
            signupStore: useSignupStore(),
            pageIndex: 3,
            creating: false,

            createError: '',

        }
    },
    
    beforeMount() {
        console.log('confirmation vue.')

        if(!this.signupStore.inputs.pass1) this.signupStore.inputs.pass1 = ''
        if(!this.signupStore.inputs.pass2) this.signupStore.inputs.pass2 = ''

        if(!this.signupStore.ifIndexValid(this.pageIndex-1)) {
            console.log('previous step not valid...')
            this.$emit('prevPage', {
                pageIndex: this.pageIndex
            }); 
        }
    },

    methods: {
        createAccount() {
            console.log('create account todo...')

            if(this.creating) return

            this.creating = true
            this.createError = ''

            api
            .post("/user", this.signupStore.inputs)
            .then((response) => {
                console.log(response) 
                this.signupStore.inputs = {}
                this.$emit('complete', this.signupStore.inputs);
            })
            .catch((err) => {
                console.warn(err.response.data.message)
                this.createError = err.response.data.message
            })
            .finally(() => {
                this.creating = false
            });

        }
    },

    
}
</script>
