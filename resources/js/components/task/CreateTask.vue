<template>
    <user_error_block></user_error_block>
    <div>
        <div class="container mt-5 w-25">
            <h2 class="text-md-center text-bg-secondary">Новая задача</h2>
            <div class="mb-3">
                <input type="text" class="form-control" v-model="nameTask" placeholder="Введите название задачи">
            </div>
            <div class="mb-3">
                <label>Описание задачи</label>
                <textarea class="form-control" v-model="description" placeholder="Введите описание задачи"></textarea>
            </div>
            <div class="mb-3">
                <label>Дата окончания задачи</label>
                <input type="datetime-local" class="form-control" v-model="deadline">
            </div>
            <div class="mb-3">
                <label>Категория Задачи</label>
                <select class="form-control" v-model="taskStatus">
                    <option v-for="status in is_openedStatuses" :value="status.id">{{ status.name }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Проект</label>
                <select class="form-control" v-model="taskProject">
                    <option v-for="project in openProjects" :value="project.id">{{ project.title }}</option>
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
            nameTask: null,
            description: null,
            deadline: null,
            taskStatus: null,
            taskProject: this.$route.query.project_id,
            projects: [],
            statuses: [],
            result: {'result': null, 'message': null}
        };
    },


    computed: {
        is_openedStatuses() {
            return this.$store.getters.openedTaskStatus;
        },
        openProjects() {
            return this.projects.filter((project) => project.category.is_closed === 0);
        },
        isDisabled() {
            return this.nameTask && this.description && this.deadline && this.taskProject && this.taskStatus
        },

    },

    mounted() {
        this.getProjects()
        this.setDefaultDeadline()
        this.$store.dispatch('getTaskStatuses')
    },

    methods: {
        getProjects() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.get('/api/projects')
                        .then(response => {
                            this.projects = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения проeктов', error);
                        });
                });
        },

        setDefaultDeadline() {
            const currentDate = new Date();
            currentDate.setHours(currentDate.getHours() + 6);
            this.deadline = currentDate.toISOString().slice(0, 16);
        },

        store() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/api/tasks', {
                        title: this.nameTask,
                        description: this.description,
                        deadline: this.deadline,
                        project_id: this.taskProject,
                        task_status_id: this.taskStatus
                    }).then(response => {
                        this.result = {'result': 'ok', 'message': "Задача создана"};
                        setTimeout(() => {
                            this.result = {'result': null, 'message': null}
                            this.$router.push({name: 'tasks.show', params: {id: response.data.id}});
                        }, 1500);
                    }).catch(error => {
                        this.result = {'result': 'error', 'message': error.response.data.message}
                        setTimeout(() => {
                            this.result = {'result': null, 'message': null}
                        }, 7000);
                    })
                })
        },
    },

};
</script>


<style scoped>

</style>
