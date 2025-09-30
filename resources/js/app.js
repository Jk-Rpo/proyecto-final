import './bootstrap';
import './../css/app.css'
import { createApp } from 'vue'

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import ReceptionsCreate from './components/receptions/ReceptionsCreate.vue'
import ReceptionsIndex from './components/receptions/ReceptionsIndex.vue'
import ReceptionsShow from './components/receptions/ReceptionsShow.vue'
import ReceptionsEdit from './components/receptions/ReceptionsEdit.vue'

import PatientsIndex from "./components/patients/PatientsIndex.vue";
import PatientsCreate from "./components/patients/PatientsCreate.vue";
import PatientsEdit from "./components/patients/PatientsEdit.vue";
import PatientsShow from "./components/patients/PatientsShow.vue";  


const app = createApp({})
app.component('receptions-create', ReceptionsCreate)
app.component('receptions-index', ReceptionsIndex)    
app.component('receptions-show', ReceptionsShow)
app.component('receptions-edit', ReceptionsEdit)

app.component("patients-index", PatientsIndex);
app.component("patients-create", PatientsCreate);
app.component("patients-edit", PatientsEdit);
app.component("patients-show", PatientsShow);

app.mount('#app')

// import { createApp } from 'vue'
// import App from './App.vue'
// import router from './router'
// import axios from 'axios'

// axios.defaults.baseURL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

// createApp(App).use(router).mount('#app')
