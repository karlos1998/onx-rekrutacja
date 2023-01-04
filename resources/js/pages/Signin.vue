<template>

    <div class="card">
        <div class="flex flex-wrap align-items-center justify-content-center card-container yellow-container">
            <div class="w-28rem">

                <Card style="margin-bottom: 2em">
                    <template #title>
                        <div>Login Form</div>
                    </template>

                    <template #content>        

                        <div class="field">
                            
                            <span class="p-float-label">
                                <InputText id="email" type="text" v-model="inputs.email" />
                                <label for="email">Email</label>
                            </span>
                            
                        </div>

                        <div class="mt-5 field">
                            <span class="p-float-label">
                                <Password id="password" v-model="inputs.password" toggleMask :feedback="false" class="" ></Password>
                                <label for="password" class="block text-900 font-medium mb-2">Password</label>
                            </span>
                        </div>

                    </template>

                    <template v-slot:footer>
                        <div class="grid grid-nogutter justify-content-between">
                            <Button label="Login" @click="login()" :icon="processing ? 'pi pi-spinner pi-spin':'pi pi-angle-right'" icon-pos="right"></Button>
                        </div>
                    </template>

                </Card>
            
            </div>
        </div>
    </div>


    <div class="card">
        <div class="flex flex-wrap align-items-center justify-content-center card-container yellow-container">
            <div class="w-28rem">
                <Card style="margin-bottom: 2em">
                    <template #content>
                        <div class="text-600 font-medium line-height-3">You don't have an account?</div>
                        <router-link class="font-medium no-underline ml-2 text-blue-500 cursor-pointer"  :to="{name: 'signup'}">Create now!</router-link>
                    </template>
                </Card>
            </div>
        </div>
    </div>

</template>
    
    
    
    
<script>
    
    import Steps from 'primevue/steps';
    
    import Personal from '../partials/Signup/Personal.vue'
    
    import Card from 'primevue/card';
    
    import InputText from 'primevue/inputtext';

    import Button from 'primevue/button';

    import Password from 'primevue/password';

    import { useUserStore } from '@/stores/user'

    export default {
        components: {
            Steps,
            Personal,
            Card,
            InputText,
            Button,
            Password,
    
        },
        data() {
            return {
                inputs: {},
                processing:false,
            }
        },
        methods: {
            async login() {
                if(this.processing) return

                this.processing  = true

                await axios.get('/sanctum/csrf-cookie')

                await api
                .post("/login", this.inputs)
                .then(async (response) => {
                    console.log('/login response ->', response) 

                    const user = useUserStore()
                    await user.init()
                    if(user.logged) {
                        this.$router.push({ name: 'dashboard' });
                        this.$toast.add({severity:'success', summary:'Hello', detail: 'Dear, ' + user.data.firstname + ' ' + user.data.lastname + ' you are now logged in.', life: 3000});
                        console.log('after router push... to dashboard :D')
                    } else {
                        this.$toast.add({severity:'error', summary:'Login Fail', detail: 'Something went wrong...', life: 3000});
                    }
                })
                .catch((err) => {
                    console.warn(err.response.data.message)
                    this.$toast.add({severity:'error', summary:'Login Fail', detail: err.response.data.message, life: 3000});
                })
                .finally(() => {
                    this.processing = false
                });
            }
        }
    }
    </script>
    
    <style scoped lang="scss">
    ::v-deep(b) {
        display: block;
    }
    
    ::v-deep(.p-card-body) {
        padding: 2rem;
    }
    </style>