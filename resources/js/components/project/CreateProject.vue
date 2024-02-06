<template>
    <user_error_block></user_error_block>
    <div>
        <div class="container mt-5 w-25">
            <h3 class="text-md-center text-bg-secondary">Новый проект</h3>
            <div class="mb-3">
                <input type="text" class="form-control" v-model="nameProject"
                       placeholder="Введите название проекта">
            </div>
            <div class="mb-3">
                <label>Описание проекта</label>
                <textarea class="form-control" v-model="description"
                          placeholder="Введите описание проекта"></textarea>
            </div>
            <div class="mb-3">
                <label>Дата окончания проекта</label>
                <input type="date" class="form-control" v-model="deadlineDate">
            </div>
            <div class="mb-3">
                <label>Категория проекта</label>
                <select class="form-control" v-model="projectCategory">
                    <option v-for="category in openedCategories" :value="category.id">{{ category.name }}</option>
                </select>
            </div>
            <div class="mb-3 d-grid col-4">
                <input :disabled="!isDisabled" @click.prevent="store" class="btn btn-primary" type="submit"
                       value="Создать">
            </div>
        </div>
    </div>
</template>


<script>
import User_error_block from "@/components/elements/user_error_block.vue";

export default {
    name: "CreateProject",
    components: {User_error_block},

    data() {
        return {
            nameProject: null,
            description: null,
            deadlineDate: null,
            projectCategory: null,
            result: {'result': null, 'message': null}
        };
    },

    mounted() {
        this.$store.dispatch('getCategories')
        this.setDefaultDeadline()
    },


    methods: {
        store() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/api/projects', {
                        title: this.nameProject,
                        description: this.description,
                        deadline: this.deadlineDate,
                        category_id: this.projectCategory,
                    }).then(response => {
                        this.result = {'result': 'ok', 'message': "Задача создана"};
                        setTimeout(() => {
                            this.result = {'result': null, 'message': null}
                            this.$router.push({name: 'projects.show', params: {id: response.data.id}});
                        }, 1500);
                    }).catch(error => {
                        this.result = {'result': 'error', 'message': error.response.data.message}
                        setTimeout(() => {
                            this.result = {'result': null, 'message': null}
                        }, 7000);
                    })
                });
        },

        setDefaultDeadline() {
            const currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 2)
            this.deadlineDate = currentDate.toISOString().slice(0, 10);
        }
    },

    computed: {
        isDisabled() {
            return this.nameProject && this.description && this.deadlineDate && this.projectCategory
        },
        openedCategories() {
            return this.$store.getters.openedCategories;
        },
    }
};
</script>


<style scoped>

</style>
