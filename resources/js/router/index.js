import { createRouter, createWebHistory } from 'vue-router'
import ReceptionsIndex from '../components/receptions/ReceptionsIndex.vue'
import ReceptionsCreate from '../components/receptions/ReceptionsCreate.vue'
import ReceptionsEdit from '../components/receptions/ReceptionsEdit.vue'
import ReceptionsShow from '../components/receptions/ReceptionsShow.vue'

const routes = [
    { path: '/receptions', component: ReceptionsIndex },
    { path: '/receptions/create', component: ReceptionsCreate },
    { path: '/receptions/:id/edit', component: ReceptionsEdit },
    { path: '/receptions/:id', component: ReceptionsShow }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router