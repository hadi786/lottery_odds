import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import MainBody from './components/MainBody.vue'

const routes = [
    {
        path: "/",
        component: MainBody
    }
]

const router = new VueRouter({
    mode: 'history', //removes # (hashtag) from url
    base: '/',
    fallback: true,
    routes
})
export default router