<template>
    <div class="container mt-3 w-75 d-flex justify-content-end">
        <div class="col-3 text-left">
            <strong class="text-gray ">{{ userName }}</strong>
        </div>
    </div>
</template>

<script>
export default {
    name: "user_block",

    data() {
        return {
            userName: null,
        }
    },

    mounted() {
        this.getUserName()
    },

    methods: {
        getUserName() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.get('/api/user/name')
                        .then(response => {
                            console.log(response)
                            this.userName = response.data;
                        })
                        .catch(error => {
                            this.userName = 'Имя не определено';
                        });
                });
        },
    }
}
</script>

<style scoped>

</style>
