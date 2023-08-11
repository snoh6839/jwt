import { createWebHistory, createRouter } from 'vue-router';
import Home from './components/HomeComponent.vue';
import Main from './components/MainComponent.vue';
import Login from './components/LoginComponent.vue';
import TokenController from './js/TokenController';

const configflg = {
    home: false,
    main: true,
    login: false,
}

const beforeAuth = path => (from, to, next) => {
    const isToken = TokenController.getToken();
    const flg = configflg[path];

    // if ( ( flg && isToken ) || !flg ) {
    //     return next();
    // } else {
    //     next('/login');
    // }

    if (isToken ){
        if( path == 'login' ){
            next('/main');
        }
        return next();
    } else {
        if ( flg ) {
            next('/login');
        }
        return next();
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
        beforeEnter: beforeAuth('home')
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;