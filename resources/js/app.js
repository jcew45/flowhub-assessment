import './bootstrap';
import router from "./router";
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/aura-light-green/theme.css';
import 'primeicons/primeicons.css'
import ConfirmationService from 'primevue/confirmationservice';

import { createApp } from "vue";

import App from "./App.vue";

createApp(App)
.use(router)
.use(PrimeVue)
.use(ConfirmationService)
.mount("#app");