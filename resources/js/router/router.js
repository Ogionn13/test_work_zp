import {createRouter, createWebHistory} from "vue-router";
import routes from "@/router/routes.js";
import store from "@/store/index.js";



const  router = createRouter( {
    history: createWebHistory(),
    routes

});


router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('x_xsrf_token')

    if (!token) {
        if (to.name === 'login' || to.name === 'registration') {
            return next()
        }
        return next({ name: "login"})
    }

    if (to.name === 'login' || to.name === 'registration' && token) {
        return next({ name: "home"})
    }

    return next()
});

export default router;
