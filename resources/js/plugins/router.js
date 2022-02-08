import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from '../pages/Login.vue';
import Main from '../pages/Main.vue';
import Dashboard from '../pages/Admin/Dashboard.vue';
import Books from '../pages/Admin/Books.vue';
import Admin from '../pages/Admin/Admin.vue';
import Student from '../pages/Admin/Student.vue';
import Teacher from '../pages/Admin/Teacher.vue';
import Borrow from '../pages/Admin/Borrow.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active-route',
    routes: [{
            path: '',
            name: 'main',
            component: Main,
            meta: {
                requiresAuth: true
            },
            children: [{
                    path: '/dashboard',
                    name: 'dashboard',
                    component: Dashboard,
                },
                {
                    path: '/books',
                    name: 'books',
                    component: Books,
                },
                {
                    path: '/admin',
                    name: 'admin',
                    component: Admin,
                },
                {
                    path: '/student',
                    name: 'student',
                    component: Student,
                },
                {
                    path: '/teacher',
                    name: 'teacher',
                    component: Teacher,
                },
                {
                    path: '/borrow',
                    name: 'borrow',
                    component: Borrow,
                },

            ]
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                requiresAuth: false
            },
        },
    ]
});

router.beforeEach(async(to, from, next) => {
    localStorage.setItem('from', from.fullPath)

    const user = localStorage.getItem('token')


    console.log(user)
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (!requiresAuth && user) {
        console.log('not require auth but there is user')
        next(from)
    } else if (requiresAuth && !user) {
        console.log('require auth there is no user')
        next('/login');
    } else {
        console.log('next')
        next();
    }

})

export default router;