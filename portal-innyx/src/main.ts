import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';

import App from '@/App.vue'
import router from '@/router'

import "primevue/resources/themes/lara-light-green/theme.css";
import "primeflex/primeflex.css"
import 'primeicons/primeicons.css'


const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

const app = createApp(App)
app.use(pinia)
app.use(router)
app.use(PrimeVue)
app.use(ToastService);

app.mount('#app')
