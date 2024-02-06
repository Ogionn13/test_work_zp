<template>
    <user_block></user_block>
    <div class="container mt-5 w-75">
        <h2 class="text-md-center text-bg-secondary">Открытые задачи</h2>
        <div class="card-body table-responsive card p-1">
            <table class="table table-hover text-nowrap">
                <thead class="table-warning text-md-center border-3">
                <tr>
                    <th>Название</th>
                    <th>Дата завершения</th>
                    <th>Статус</th>
                    <th>Время по задаче</th>
                    <th>Проект</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="task in openTasks" v-bind:key="task.id">
                    <td>
                        <router-link :to="{ name: 'tasks.show', params: { id: task.id }}"
                                     class="text-decoration-none text-dark">
                            {{ task.title }}
                        </router-link>
                    </td>
                    <td class="text-md-center">{{ task.deadline }}</td>
                    <td class="text-md-center">{{ task.task_status_name }}</td>
                    <th class="text-md-center">{{ formatTime( task.length) }}</th>
                    <td class="my-btn-to-project">
                        <router-link :to="{ name: 'projects.show', params: { id: task.project_id }}"
                                     class="text-decoration-none text-dark">
                            {{ task.project_title }}
                        </router-link>
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
        <input type="submit" @click.prevent="createTask" class="btn btn-primary" value="Добавить новую задачу">
    </div>
</template>

<script>

import User_block from "@/components/elements/user_block.vue";

export default {
    name: "IndexTask",
    components: {User_block},

    data() {
        return {
            openTasks: []
        }
    },

    mounted() {
        this.getOpenTasks();
    },

    computed: {
    },


    methods: {
        getOpenTasks() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.get('/api/tasks')
                        .then(response => {
                            console.log(response.data)
                            this.openTasks = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения задач', error);
                        });
                });
        },

        formatTime(time){
            const hours = Math.floor(time / 3600);
            const minutes = Math.floor((time % 3600) / 60).toString().padStart(2, '0');;
            const seconds = (time % 60).toString().padStart(2, '0');;
            return hours + ': ' + minutes + ': ' + seconds ;
        },

        createTask() {
            this.$router.push({ name: 'tasks.create'})
        }
    }
};
</script>


<style scoped>
td.my-btn-to-project {
    max-width: 25ch;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
