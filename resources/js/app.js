import './bootstrap';
import { createApp } from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Home from './components/Home.vue'
import ReceptionsCreate from './components/receptions/ReceptionsCreate.vue'
import ReceptionsIndex from './components/receptions/ReceptionsIndex.vue'
import ReceptionsShow from './components/receptions/ReceptionsShow.vue'
import ReceptionsEditSpecial from './components/receptions/ReceptionsEditSpecial.vue'
import ReceptionsEditPatient from './components/receptions/ReceptionsEditPatient.vue'
import ReceptionsCreatePatient from './components/receptions/ReceptionsCreatePatient.vue'
import ReceptionsCreateSpecial from './components/receptions/ReceptionsCreateSpecial.vue'

import PatientsIndex from "./components/patients/PatientsIndex.vue";
import PatientsCreate from "./components/patients/PatientsCreate.vue";
import PatientsEdit from "./components/patients/PatientsEdit.vue";
import PatientsShow from "./components/patients/PatientsShow.vue";  

import IntButton from './components/Utils/IntButton.vue'


const app = createApp({})
app.component('home', Home)

app.component('receptions-create', ReceptionsCreate)
app.component('receptions-create-patient', ReceptionsCreatePatient)
app.component('receptions-create-special', ReceptionsCreateSpecial)
app.component('receptions-index', ReceptionsIndex)    
app.component('receptions-show', ReceptionsShow)
app.component('receptions-edit-special', ReceptionsEditSpecial)
app.component('receptions-edit-patient', ReceptionsEditPatient)

app.component("patients-index", PatientsIndex);
app.component("patients-create", PatientsCreate);
app.component("patients-edit", PatientsEdit);
app.component("patients-show", PatientsShow);

app.component('int-button', IntButton)

app.use(ElementPlus)

app.mount('#app')

// import { createApp } from 'vue'
// import App from './App.vue'
// import router from './router'
// import axios from 'axios'

// axios.defaults.baseURL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

// createApp(App).use(router).mount('#app')
