<template>
    <user_error_block></user_error_block>
    <div v-if="task">
        <header class="d-flex justify-content-center mt-4">
            <h1 contenteditable="true" ref="newTitle" @blur="editTitle">{{ task.title }}</h1>
        </header>
        <div class="container d-flex justify-content-center card bg-success-subtle border-3 w-75 mt-3 ">
            <div class="d-flex justify-content-center  align-items-center">
                <div class="col-2 h3">
                    Проект:
                </div>
                <div class="col-7">
                    <select class="form-control bg-success-subtle border-transparent" @change="updateTaskProject"
                            v-model="task.project_id">
                        <option v-for="project in projectList" :value="project.id">{{ project.title }}</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-outline-secondary" @click.prevent="openProject">к проекту
                    </button>
                </div>
            </div>

        </div>

        <div class="container mt-3 w-75">

            <div>
                <h3>Описание задачи</h3>
                <p class="mr-5" contenteditable="true" ref="newDescription" @blur="editDescription">
                    {{ task.description }}</p>
            </div>
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center">
                    <div class="d-grid col-2">
                        <label>Статус задачи:</label>
                    </div>
                    <select class="form-control w-25 border-transparent" @change="updateTaskStatus"
                            v-model="task.task_status_id">
                        <option v-for="taskStatus in taskStatuses" :value="taskStatus.id">{{ taskStatus.name }}</option>
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <div class="d-grid col-2">
                        <label for="endDate">Выполнить к:</label>
                    </div>
                    <div class="d-grid col-1">
                        <input type="datetime-local" class="form-control border-transparent" @input="editDeadline"
                               v-model="task.deadline">
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="d-grid col-2">
                        <label for="endDate">Затраты времени:</label>
                    </div>
                    <div class="d-grid col-3">
                        <p>{{ formatTime }}</p>
                    </div>
                </div>
                <div class="d-grid col-3 mt-5">
                    <p v-if="timerRunning">В работе: {{ elapsedTime }} секунд</p>
                    <button class="btn btn-primary" @click="startTimer" v-if="!timerRunning">Приступить к работе
                    </button>
                    <button class="btn btn-danger" @click="stopTimer" v-if="timerRunning">Остановить</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import User_error_block from "@/components/elements/user_error_block.vue";

export default {
    name: "ShowTask",
    components: {User_error_block},
    data() {
        return {
            task: null,
            timerRunning: false,
            startTime: 0,
            elapsedTime: 0,
            intervalId: 0,
            result: {'result': null, 'message': null}
        };
    },

    mounted() {
        this.getTaskById();
        this.$store.dispatch('getTaskStatuses');
        this.$store.dispatch('getProjectsList');
    },

    computed: {
        taskStatuses() {
            return this.$store.getters.taskStatuses;
        },
        projectList() {
            return this.$store.getters.projectsList;
        },
        formatTime() {
            const hours = Math.floor(this.task.length / 3600);
            const minutes = Math.floor((this.task.length % 3600) / 60);
            const seconds = this.task.length % 60;
            return hours + ' ч. ' + minutes + ' мин. ' + seconds + ' сек.';
        },
    },

    methods: {
        editTask(data, mess) {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.patch('/api/tasks/' + this.$route.params.id, data)
                        .then(response => {
                            this.result = {'result': 'ok', 'message': mess}
                        })
                        .catch(error => {
                            this.result = {'result': 'error', 'message': error.response.data.message}
                        })
                        .finally(() => {
                            setTimeout(() => {
                                this.result = {'result': null, 'message': null}
                            }, 4000);
                        });
                })
        },

        updateWorkTime() {
            this.task.length +=  this.elapsedTime;
            this.editTask({length: this.task.length}, 'Время зафиксировано');
        },

        editTitle() {
            if (this.$refs.newTitle.textContent !== this.task.title) {
                this.task.title = this.$refs.newTitle.textContent
                this.editTask({title: this.$refs.newTitle.textContent}, 'Изменено название задачи');
            }
        },

        editDeadline() {
            this.editTask({deadline: this.task.deadline}, 'Изменена дата завершения задачи');
        },

        editDescription() {
            if (this.$refs.newDescription.textContent !== this.task.description) {
                this.task.description = this.$refs.newDescription.textContent
                this.editTask({description: this.$refs.newDescription.textContent}, 'Изменено описание задачи ');
            }
        },

        updateTaskProject() {
            this.editTask({project_id: this.task.project_id}, ' Изменен связанный проект ');
        },

        updateTaskStatus() {
            this.editTask({task_status_id: this.task.task_status_id}, 'изменен статус задачи ');
        },

        startTimer() {
            this.timerRunning = true;
            this.startTime = new Date().getTime();
            this.intervalId = setInterval(() => {
                this.elapsedTime = Math.floor((new Date().getTime() - this.startTime) / 1000);
            }, 1000);
        },

        stopTimer() {
            this.timerRunning = false;
            clearInterval(this.intervalId);
            this.updateWorkTime();
            this.elapsedTime = 0;
        },

        getTaskById() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.get('/api/tasks/' + this.$route.params.id)
                        .then(response => {
                            this.task = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения проекта', error);
                        });
                });
        },

        openProject() {
            this.$router.push({name: 'projects.show', params: {id: this.task.project_id}});
        }
    },

    beforeUnmount() {
        clearInterval(this.intervalId);
        if (this.timerRunning) {
            this.updateWorkTime();
        }
    }
}
;
</script>

<style scoped>

</style>
