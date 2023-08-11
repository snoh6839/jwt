import { createWebHistory, createRouter } from 'vue-router';
import Main from './components/MainComponent.vue';
import Login from './components/LoginComponent.vue';

const beforeAuth = path => (from, to, next) => {
    const isAuth = 
};

const routes = [
    {
        path: '/main',
        name: 'main',
        component: Main,
        beforeEnter: beforeAuth('main')
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter: beforeAuth('login')
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;