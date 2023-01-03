<template>

    <Card style="margin-bottom: 2em">
        <template #title>
            
        </template>

        <template #content>
                

            <div class="field">
                <label for="password" class="block text-900 font-medium mb-2">Password</label>

                <div>
                    <Password 
                    v-model="signupStore.inputs.password"
                    minLength="8"
                    toggleMask
                    >
                        <template #header>
                            <h6>Pick a password</h6>
                        </template>
                        <template #footer>
                            <Divider />
                            <p class="mt-2">Suggestions</p>
                            <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
                                <li>At least one lowercase</li>
                                <li>At least one uppercase</li>
                                <li>At least one numeric</li>
                                <li>Minimum 8 characters</li>
                            </ul>
                        </template>
                    </Password>
                </div>

                <small v-show="signupStore.validationErrors.password" class="p-error">{{ signupStore.validationErrors.password }}</small>
            </div>

            <div class="field">
                <label for="pass2" class="block text-900 font-medium mb-2">Repeat password</label>
                <div><Password v-model="signupStore.inputs.pass2" toggleMask :feedback="false" class="" ></Password></div>
                <small v-show="signupStore.validationErrors.pass2" class="p-error">{{ signupStore.validationErrors.pass2 }}</small>
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

import Password from 'primevue/password';

export default {
    name: 'Pass',

    components:{
        Card,
        InputText,
        Button,
        Password,
    },
    
    data() {
        return {
            signupStore: useSignupStore(),
            pageIndex: 2,
        }
    },
    
    beforeMount() {
        console.log('pass vue.')

        if(!this.signupStore.inputs.password) this.signupStore.inputs.password = ''
        if(!this.signupStore.inputs.pass2) this.signupStore.inputs.pass2 = ''

        if(!this.signupStore.ifIndexValid(this.pageIndex-1)) {
            console.log('previous step not valid...')
            this.$emit('prevPage', {
                pageIndex: this.pageIndex
            }); 
        }
    },

    methods: {
        nextPage() {
            this.signupStore.validationErrors = {}

            const validateSuccess = this.validateForm()

            if(validateSuccess) {

                this.$emit('nextPage', {pageIndex: this.pageIndex}
                );  
            }

            this.signupStore.pageIndexValid(this.pageIndex, validateSuccess)
            
        },
        validateForm() {

            if (!this.signupStore.inputs.password.trim())
                this.signupStore.validationErrors['password'] = 'Password is required';
            else if (this.signupStore.inputs.password.length < 8)
                this.signupStore.validationErrors['password'] = 'Must be at least 8 characters';

            if (!this.signupStore.inputs.pass2.trim())
                this.signupStore.validationErrors['pass2'] = 'Repeat password';

            if (
                this.signupStore.inputs.password.trim() &&
                this.signupStore.inputs.pass2.trim() &&
                this.signupStore.inputs.password != this.signupStore.inputs.pass2
            ) this.signupStore.validationErrors['pass2'] = 'Passwords must match';

            return !Object.keys(this.signupStore.validationErrors).length;
        },
    },

    
}
</script>
