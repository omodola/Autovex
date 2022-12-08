import { createRouter, createWebHistory } from 'vue-router'

const routes = [

    {
        path: '/',
        name: 'Dashboard',
        component: () =>
            import("../components/Dashboard.vue"),
    },

    {
        path: '/register',
        name: 'Register',
        component: () =>
            import("../components/Register.vue"),
    },
    {
        path: "/login",
        name: "Login",

        component: () =>
            import( "../components/Login.vue"),

    },


]


const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})


export default router
