import { createWebHistory, createRouter } from 'vue-router';
import Home from './components/HomeComponent.vue';
import Main from './components/MainComponent.vue';
import Login from './components/LoginComponent.vue';
import TokenController from './js/TokenController';

const configflg = {
    main: true,
    login: false,
}

const beforeAuth = path => (from, to, next) => {
    const isToken = TokenController.getToken();
    const flg = configflg[path];
    if ( ( flg && isToken ) || !flg ) {
        return next();
    } else {
        next('/login');
    }
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
    },
    {
        path: '/',
        name: 'home',
        component: Home,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;