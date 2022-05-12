import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from '../pages/Login.vue';
import StudentMain from '../pages/StudentMain.vue';
import Main from '../pages/Main.vue';
import Dashboard from '../pages/Admin/Dashboard.vue';
import Books from '../pages/Admin/Books.vue';
import Admins from '../pages/Admin/Admins.vue';
import Students from '../pages/Admin/Students.vue';
import Visitors from '../pages/Admin/Visitors.vue';
import Teachers from '../pages/Admin/Teachers.vue';
import Borrows from '../pages/Admin/Borrows.vue';
import studentView from '../pages/View/Student.vue';
import teacherView from '../pages/View/Teacher.vue';
import visitorView from '../pages/View/Visitor.vue';
import Borrowed from '../pages/Admin/Borroweds.vue';
import Return from '../pages/Admin/Returned.vue';

import UserDashboard from '../pages/User/Dashboard.vue';
import UserBorroweds from '../pages/User/Borrows.vue'

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active-route',
    routes: [
        {
            path: '',
            name: 'main',
            component: Main,
            meta: {
                requiresAuth: true,
                user_type : ['admin'],
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
                    path: '/visitors',
                    name: 'visitors',
                    component: Visitors,
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
                    path: '/visitor-view/:id',
                    name: 'visitor-view',
                    component: visitorView,
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
            path: '/student/',
            name: 'user_main',
            component: StudentMain,
            meta: {
                requiresAuth: true,
                user_type : ['student','teacher','visitor'],
            },
            children: [
               
                {
                    path: 'dashboard',
                    name: 'dashboard',
                    component: UserDashboard,
                },
                {
                    path: 'borroweds',
                    name: 'borroweds',
                    component: UserBorroweds,
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

    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const user_type = to.matched.length > 1 ? to.matched[0].meta.user_type : ''

    if (!requiresAuth && user) {
        console.log('not require auth but there is user')
        if (localStorage.getItem("user_type") == "admin") {
            console.log("admin")
            next("/dashboard")
        } else {
            console.log("student")
            next("/student/dashboard")
        }
    } else if (requiresAuth && !user) {
        console.log('require auth there is no user')
        next('/login');
    } else if (user_type && !user_type.includes(localStorage.getItem("user_type"))) {
        if (localStorage.getItem("user_type") == "admin") {
            console.log("admin")
            next("/dashboard")
        } else if(localStorage.getItem("user_type") == "teacher" || localStorage.getItem("user_type") == "student" || localStorage.getItem("user_type") == "visitor") {
            console.log("student")
            next("/student/dashboard")
        }
    } else {
        
        console.log('next')
        next();
    }

})

export default router;