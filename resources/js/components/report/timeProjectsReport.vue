<template>
    <user_block></user_block>
        <div class="container mt-5 w-75">
            <h2 class="text-md-center text-bg-secondary">Затраты времени по проектам</h2>
            <div class="card-body table-responsive card p-1">
                <table class="table table-hover text-nowrap">
                    <thead class="text-md-center table-secondary border-3">
                    <tr>
                        <th>Проект</th>
                        <th>Дата завершения</th>
                        <th>Количество задач</th>
                        <th>Суммарное время</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="project in projectsWithTime" v-bind:key="project.id">
                        <td>
                            <router-link :to="{ name: 'projects.show', params: { id: project.id }}"
                                         class="text-decoration-none text-dark">
                                {{ project.title }}
                            </router-link>
                        </td>
                        <td class="text-md-center">{{ project.deadline }}</td>
                        <td class="text-md-center">{{ project.tasks_count }}</td>
                        <td class="text-md-right ml-4">{{ formatTime(project.tasks_sum_length) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
    </div>

</template>

<script>

import User_block from "@/components/elements/user_block.vue";

export default {
    name: "IndexProject",
    components: {User_block},
    data() {
        return {
            projectsWithTime: [],
        };
    },

    computed: {

    },

    mounted() {
        this.getProjectsWithTime();
    },

    methods: {
        getProjectsWithTime() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.get('/api/projects/timeReport')
                        .then(response => {
                            this.projectsWithTime = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения проeктов', error);
                        });
                });
        },

        formatTime(time) {
            const hours = Math.floor( time / 3600);
            const minutes = Math.floor(( time % 3600) / 60).toString().padStart(2, '0');
            const seconds =  (time % 60).toString().padStart(2, '0');
            return hours+ ' ч. ' + minutes + ' мин. ' + seconds +' сек.';
        },
    }
};
</script>


<style scoped>

</style>
