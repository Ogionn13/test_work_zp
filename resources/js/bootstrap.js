import 'bootstrap';


import axios from 'axios';
import router from "@/router/router.js";

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
window.axios.defaults.withXSRFToken = true;

window.axios.interceptors.response.use({}, error => {
    if (error.response.status === 401 || error.response.status === 419) {
        const token = localStorage['x_xsrf_token']
        if (token){
            localStorage.removeItem('x_xsrf_token');
        }
        router.push({ name: 'login'})
    }
    return Promise.reject(error);
})

