<template>
    <div class="container mt-3 w-75 d-flex justify-content-between">
        <div class="col-4">
            <div v-if="$parent.result.result && $parent.result.result ==='error'" >
                <p class="card border-0 text-center  bg-danger-subtle">{{ $parent.result.message }}</p>
            </div>
            <div v-if="$parent.result.result && $parent.result.result === 'ok'" >
                <p class="card border-0 text-center  bg-success-subtle">{{ $parent.result.message }}</p>
            </div>

        </div>
        <div class="col-4">
            <strong class="text-gray ">{{ userName }}</strong>
        </div>

    </div>
</template>

<script>
export default {
    name: "user_error_block",

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
