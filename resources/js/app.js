import './bootstrap';
import {createApp} from 'vue';
import store from './store/index.js';
import Router from "@/router/router.js";
import Index from "@/components/Index.vue";


const app = createApp({});

app.use(Router);
app.use(store);
app.component('Index', Index);
app.mount('#app');
