import { createApp } from 'vue'
import { createPinia } from 'pinia'
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';

import App from '@/App.vue'
import router from '@/router'

import "primevue/resources/themes/lara-light-green/theme.css";
import "primeflex/primeflex.css"

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(PrimeVue)
app.use(ToastService);

app.mount('#app')
