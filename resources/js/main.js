import './bootstrap'

import './api'

import 'primevue/resources/themes/tailwind-light/theme.css'
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";

import 'primeflex/primeflex.scss';

import "../css/main.css"


import {createApp} from 'vue';
import App from './App.vue';
import PrimeVue from 'primevue/config';
//import Dialog from 'primevue/dialog';
import ToastService from 'primevue/toastservice';

import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

import router from './router'

const app = createApp(App);

app.use(PrimeVue);
app.use(router)
app.use(ToastService)

app.use(pinia)
//app.component('Dialog', Dialog);

app.mount('#app')