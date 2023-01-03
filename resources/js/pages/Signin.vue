<template>

    <div class="card">
        <div class="flex flex-wrap align-items-center justify-content-center card-container yellow-container">
            <div class="w-28rem">

                <Card style="margin-bottom: 2em">
                    <template #title>
                        
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

</template>
    
    
    
    
    <script>
    
    import Steps from 'primevue/steps';
    
    import Personal from '../partials/Signup/Personal.vue'
    
    import Card from 'primevue/card';
    
    import InputText from 'primevue/inputtext';

    import Button from 'primevue/button';

    import Password from 'primevue/password';

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

                api
                .post("/login", this.inputs)
                .then((response) => {
                    console.log(response) 
                })
                .catch((err) => {
                    console.warn(err.response.data.message)
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