<template>

    <Card style="margin-bottom: 2em">
        <template #title>
            <div class="text-900 text-3xl font-medium mb-3">Create account</div>
            <span class="text-600 font-medium line-height-3">You have account?</span>
            <a class="font-medium no-underline ml-2 text-blue-500 cursor-pointer">Login now!</a>
        </template>

        <template #content>
                
            <div class="field">
                <label for="firstname" class="block text-900 font-medium mb-2">Firstname</label>
                <InputText v-model="signupStore.inputs.firstname"  id="firstname" type="text" class="w-full mb-3" :class="{'p-invalid': signupStore.validationErrors.firstname}" />
                <small v-show="signupStore.validationErrors.firstname" class="p-error">{{ signupStore.validationErrors.firstname }}</small>
            </div>

            <div class="field">
                <label for="lastname" class="block text-900 font-medium mb-2">Lastname</label>
                <InputText v-model="signupStore.inputs.lastname" id="lastname" type="text" class="w-full mb-3"  :class="{'p-invalid': signupStore.validationErrors.lastname}" />
                <small v-show="signupStore.validationErrors.lastname" class="p-error">{{ signupStore.validationErrors.lastname }}</small>
            </div>

        </template>

        <template v-slot:footer>
            <div class="grid grid-nogutter justify-content-between">
                <i></i>
                <Button label="Next" @click="nextPage()" icon="pi pi-angle-right" icon-pos="right"></Button>
            </div>
        </template>

    </Card>


</template>


<script>

import Card from 'primevue/card';

import InputText from 'primevue/inputtext';

import Button from 'primevue/button';

import { useSignupStore } from '@/stores/signup'

export default {
    name: 'Personal',

    components:{
        Card,
        InputText,
        Button,
    },
    
    data() {
        return {
            signupStore: useSignupStore(),
            pageIndex: 0,
        }
    },
    
    beforeMount() {
        if(!this.signupStore.inputs.firstname) this.signupStore.inputs.firstname = ''
        if(!this.signupStore.inputs.lastname) this.signupStore.inputs.lastname = ''

        console.log('personal vue.')
    },

    methods: {
        nextPage() {
            this.signupStore.validationErrors = {}

            const validateSuccess = this.validateForm()

            if(validateSuccess) {

                this.$emit('nextPage', {pageIndex: this.pageIndex});  
            }

            this.signupStore.pageIndexValid(this.pageIndex, validateSuccess)
            
        },
        validateForm() {

            console.log(this.signupStore.inputs)
            
            if (!this.signupStore.inputs.firstname.trim())
                this.signupStore.validationErrors['firstname'] = 'Firstname is required...';

            if (!this.signupStore.inputs.lastname.trim())
                this.signupStore.validationErrors['lastname'] = 'Lastname is required...';

            return !Object.keys(this.signupStore.validationErrors).length;
        },
    },

    
}
</script>
