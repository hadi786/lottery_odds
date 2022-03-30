import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import ExampleComponent from './components/ExampleComponent.vue'

const routes = [
    {
        path: "/",
        component: ExampleComponent
    }
]

const router = new VueRouter({
    mode: 'history', //removes # (hashtag) from url
    base: '/',
    fallback: true,
    routes
})
export default router