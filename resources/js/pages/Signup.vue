<template>

    <div class="card">
        <div class="flex flex-wrap align-items-center justify-content-center card-container yellow-container">
            <div class="w-28rem">
            
                <Card style="margin-bottom: 2em">
                    <template #content>
                        <div class="card">
                            <Steps #item="item" :model="items" :readonly="true" aria-label="Form Steps" />
                        </div>
                    </template>
                </Card>

                <router-view v-slot="{Component}"  @prevPage="prevPage($event)" @nextPage="nextPage($event)" @complete="complete">
                    <keep-alive>
                        <component :is="Component" />
                    </keep-alive>
                </router-view>

            </div>
        </div>
    </div>


    <div class="card">
        <div class="flex flex-wrap align-items-center justify-content-center card-container yellow-container">
            <div class="w-28rem">
                <Card style="margin-bottom: 2em">
                    <template #content>
                        <div class="text-600 font-medium line-height-3">You have an account?</div>
                        <router-link class="font-medium no-underline ml-2 text-blue-500 cursor-pointer"  :to="{name: 'signin'}">Login now!</router-link>
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

export default {
    components: {
        Steps,
        Personal,
        Card,

    },
    data() {
        return {
            items: [{
                label: 'Personal',
                to: "/signup",
            },
            {
                label: 'Email',
                to: "/signup/email",
            },
            {
                label: 'Password',
                to: "/signup/password",
            },
            {
                label: 'Confirmation',
                to: "/signup/confirmation",
            }],
            
        }
    },
    methods: {
        nextPage(event) {
            this.$router.push(this.items[event.pageIndex + 1].to);
        },
        prevPage(event) {
            this.$router.push(this.items[event.pageIndex - 1].to);
        },
        async complete(formObject) {
            console.log('registration complete...', formObject)
            
            this.$toast.add({severity:'success', summary:'Account created', detail: 'Dear, ' + formObject.firstname + ' ' + formObject.lastname + ' your account created.'});
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