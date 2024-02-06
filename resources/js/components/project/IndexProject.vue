<template>
    <div class="container mt-5 w-75">
        <h2 class="text-md-center text-bg-secondary">Открытые проекты</h2>
        <div class="card-body table-responsive card p-1">
            <table class="table table-hover text-nowrap">
                <thead class="text-md-center table-secondary border-3">
                <tr>
                    <th>Название</th>
                    <th>Дата завершения</th>
                    <th>Категория</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="project in openProjects" v-bind:key="project.id">
                    <td>
                        <router-link :to="{ name: 'projects.show', params: { id: project.id }}"
                                     class="text-decoration-none text-dark">
                            {{ project.title }}
                        </router-link>
                    </td>
                    <td class="text-md-center">{{ project.deadline }}</td>
                    <td>{{ project.category.name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <input type="submit" @click.prevent="createProject" class="btn btn-primary" value="Добавить новый проект">
        <h2 class="mt-5 text-md-center">Закрытые проекты</h2>
        <div class="card-body table-responsive card p-1">
            <table class="table table-hover text-nowrap">
                <thead class="text-md-center table-secondary border-3">
                <tr>
                    <th>Название</th>
                    <th>Дата завершения</th>
                    <th>Категория</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="project in closedProjects" v-bind:key="project.id">
                    <td>
                        <router-link :to="{ name: 'projects.show', params: { id: project.id }}"
                                     class="text-decoration-none text-dark">
                            {{ project.title }}
                        </router-link>
                    </td>
                    <td class="text-md-center">{{ project.deadline }}</td>
                    <td>{{ project.category.name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<script>

export default {
    name: "IndexProject",

    data() {
        return {
            projects: [],
        };
    },
    computed: {
        openProjects() {
            return this.projects.filter((project) => !project.category.is_closed);
        },
        closedProjects() {
            return this.projects.filter((project) => project.category.is_closed);
        },
    },

    mounted() {
        this.getProjects();
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

        createProject() {
            this.$router.push({name: 'projects.create'})
        }
    }
};
</script>


<style scoped>

</style>
