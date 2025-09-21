import './bootstrap';
import './../css/app.css'
import { createApp } from 'vue'

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import ReceptionCreate from './components/receptions/ReceptionsCreate.vue'

const app = createApp({})
app.component('receptions-create', ReceptionCreate)
app.mount('#app')

// import { createApp } from 'vue'
// import App from './App.vue'
// import router from './router'
// import axios from 'axios'

// axios.defaults.baseURL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

// createApp(App).use(router).mount('#app')
