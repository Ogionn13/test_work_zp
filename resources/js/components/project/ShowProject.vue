<template>
    <div class="container w-75" v-if="project">
        <user_error_block></user_error_block>
        <div class="form-group d-flex justify-content-center mt-4">
            <h2 contenteditable="true" ref='newTitle' @blur="editTitle()">{{ project.title }}</h2>
        </div>

        <div class="container mt-3 w-75">
            <div>
                <h2>Описание проекта</h2>
                <p ref='newDescription' class="mr-5" contenteditable="true" @blur="editDescription('description')">
                    {{ project.description }}</p>
            </div>
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center">
                    <div class="d-grid col-2">
                        <label>Категория проекта:</label>
                    </div>
                    <select class="form-control w-25 border-transparent" @change="editCategory"
                            v-model="project.category_id">
                        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <div class="d-grid col-2">
                        <label for="startDate">Дата создания:</label>
                    </div>
                    <div class="ml-3">{{ project.created_at_formated }}</div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="d-grid col-2">
                        <label for="endDate">Закрыть к:</label>
                    </div>
                    <div class="d-grid col-1">
                        <input type="date" class="form-control border-transparent" @input="editDeadline"
                               v-model="project.deadline">
                    </div>
                </div>
            </div>
            <h2 class="text-md-center mt-5">Задачи в проекте</h2>
            <table class="table ">
                <thead class="text-md-center table-secondary border-3">
                <tr>
                    <th>Название</th>
                    <th>Дата завершения</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="task in openTasks">
                    <td>
                        <router-link :to="{ name: 'tasks.show', params: { id: task.id }}"
                                     class="text-decoration-none text-dark">
                            {{ task.title }}
                        </router-link>
                    </td>
                    <td class="text-md-center">{{ task.deadline }}</td>
                    <td>{{ task.status_name }}</td>
                </tr>
                </tbody>
            </table>
            <div class="d-grid col-3">
                <input type="submit" @click.prevent="createTask" class="btn   btn-primary" value="Новая задача">
            </div>
            <h2 class="text-md-center mt-5">Завершенные задачи</h2>
            <table class="table">
                <thead class="text-md-center ">
                <tr>
                    <th>Название</th>
                    <th>Дата завершения</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="task in closedTasks" :key="task.id">
                    <td>
                        <router-link :to="{ name: 'tasks.show', params: { id: task.id }}"
                                     class="text-decoration-none text-dark">
                            {{ task.title }}
                        </router-link>
                    </td>
                    <td class="text-md-center">{{ task.deadline }}</td>
                    <td>{{ task.task_status.name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
import User_error_block from "@/components/elements/user_error_block.vue";

export default {
    name: "ShowProject",
    components: {User_error_block},

    data() {
        return {
            project: null,
            result: {'result': null, 'message': null}
        };
    },


    mounted() {
        this.$store.dispatch('getCategories');
        this.getProjectByID();
    },

    computed: {
        openTasks() {
            return this.project.tasks.filter((task) => !task.task_status.is_closed);
        },
        closedTasks() {
            return this.project.tasks.filter((task) => task.task_status.is_closed);
        },
        categories() {
            return this.$store.getters.categories;
        }
    },

    methods: {
        editProject(data, mess) {
            axios.patch('/api/projects/' + this.$route.params.id, data)
                .then(response => {
                    this.result = {'result': 'ok', 'message': mess}
                })
                .catch(error => {
                    this.result =  {'result': 'error', 'message': error.response.data.message}
                })
                .finally(() => {
                    setTimeout(() => {
                        this.result = {'result': null, 'message': null}
                    }, 4000);
                });
        },

        editTitle() {
            if (this.$refs.newTitle.textContent !== this.project.title) {
                this.project.title = this.$refs.newTitle.textContent
                this.editProject({title: this.project.title}, 'Отредактировано название проекта')
            }
        },

        editCategory() {
            this.editProject({category_id: this.project.category_id}, 'смена категории проекта');
        },

        editDescription() {
            if (this.$refs.newDescription.textContent !== this.project.description ){
                this.project.description = this.$refs.newDescription.textContent
                this.editProject({description: this.project.description}, 'изменено описание проекта');
            }
          },

        editDeadline() {
            this.editProject({deadline: this.project.deadline}, 'изменено время завершения проекта');
        },

        createTask() {
            this.$router.push({name: 'tasks.create', query: {project_id: this.project.id}})
        },


        getProjectByID() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.get('/api/projects/' + this.$route.params.id)
                        .then(response => {
                            console.log(response.data)
                            this.project = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения проекта', error);
                        });
                });
        },
    }
};
</script>

<style scoped>

</style>
