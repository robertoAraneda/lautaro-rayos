import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../pages/Login.vue';
import Index from '../pages/laboratory/Index.vue';
import { settings } from './settings';

Vue.use(VueRouter);

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/laboratorio',
        name: 'Laboratory',
        component: Index,
        meta: { requiresAuth: true },
        children: [...settings],
    },
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    linkExactActiveClass: 'is-active',
    routes,
});

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('access_token');

    if (to.matched.some(record => record.meta.requiresAuth) && !loggedIn) {
        next('/');
    }
    next();
});

export default router;
