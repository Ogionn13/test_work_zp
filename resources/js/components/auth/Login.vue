<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-md-center font-weight-bolder sm-1">Авторизация</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Email</label>
                            <div class="col-md-6">
                                <input v-model="email" type="email" class="form-control " name="email" required
                                       autocomplete="email" autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Пароль</label>
                            <div class="col-md-6">
                                <input v-model="password" type="password" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input @click.prevent="login" type="submit" value="Войти" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <error_block></error_block>
        </div>
    </div>

</template>

<script>
import Error_block from "@/components/elements/error_block.vue";

export default {
    name: "Login",
    components: {Error_block},

    data() {
        return {
            email: null,
            password: null,
            result: {'result': null, 'message': null}
        }
    },

    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/login', {email: this.email, password: this.password})
                        .then(result => {
                            localStorage.setItem('x_xsrf_token', result.config.headers['X-XSRF-TOKEN'])
                            this.$router.push({ name: 'projects.index' });
                        })
                        .catch(error => {
                            this.result = {'result': 'error', 'message': error.response.data.message}
                            setTimeout(() => {
                                this.result = {'result': null, 'message': null}
                            }, 10000);
                        })
                });
        }
    }
}
</script>

<style scoped>

</style>
