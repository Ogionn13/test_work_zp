<template>
    <div class="d-flex justify-content-center align-items-center centered-links">

        <router-link v-if="token" :to="{ name: 'projects.index' }" class="nav-link">Проекты</router-link>
        <router-link v-if="token" :to="{ name: 'tasks.index' }" class="nav-link">Задачи</router-link>
        <router-link v-if="token" :to="{ name: 'timeProjectsReport' }" class="nav-link">Отчет времязатрат</router-link>
        <router-link v-if="!token" :to="{ name: 'login' }" class="nav-link">Login</router-link>
        <router-link v-if="!token" :to="{ name: 'registration' }" class="nav-link">Registration</router-link>
        <a v-if="token" @click.prevent="logout" href="" class="nav-link">Logout</a>
    </div>

    <router-view :key="$route.fullPath"></router-view>
</template>


<script>

export default {
    name: "Index",

    data() {
        return {
            token: null,
            userName: null
        }
    },

    mounted() {
        this.getToken();
    },

    updated() {
        this.getToken()
    },

    methods: {
        getToken() {
            this.token = localStorage.getItem('x_xsrf_token')
        },

        logout() {
            axios.post('/logout').then(
                response => {
                    localStorage.removeItem('x_xsrf_token');
                    this.$router.push({name: 'login'})
                })
        },
    }
}
</script>


<style>

.nav-link {
    margin: 0 10px;
    color: #333;
    font-weight: bold;
}

</style>
