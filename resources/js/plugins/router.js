import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from '../pages/Login.vue';
import Main from '../pages/Main.vue';
import Dashboard from '../pages/Admin/Dashboard.vue';
import Books from '../pages/Admin/Books.vue';
import Admins from '../pages/Admin/Admins.vue';
import Students from '../pages/Admin/Students.vue';
import Teachers from '../pages/Admin/Teachers.vue';
import Borrows from '../pages/Admin/Borrows.vue';
import studentView from '../pages/View/Student.vue';
import teacherView from '../pages/View/Teacher.vue';
import Borrowed from '../pages/Admin/Borroweds.vue';
import Return from '../pages/Admin/Returned.vue';

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
                    path: '/admins',
                    name: 'admins',
                    component: Admins,
                },
                {
                    path: '/students',
                    name: 'students',
                    component: Students,
                },
                {
                    path: '/teachers',
                    name: 'teachers',
                    component: Teachers,
                },
                {
                    path: '/borrows',
                    name: 'borrows',
                    component: Borrows,
                },
                {
                    path: '/student-view/:id',
                    name: 'student-view',
                    component: studentView,
                },
                {
                    path: '/teacher-view/:id',
                    name: 'teacher-view',
                    component: teacherView,
                },
                {
                    path: '/borrowed',
                    name: 'borrowed',
                    component: Borrowed,
                },
                {
                    path: '/return',
                    name: 'return',
                    component: Return,
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