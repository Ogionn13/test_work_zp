export default {

    state: {
        categories: null,
        openedCategories: null,
        taskStatuses: null,
        openedTaskStatus: null,
        projectsList: null,
        openTasks: null
    },

    mutations: {
        setCategories(state, categories) {
            state.categories = categories
            state.openedCategories = categories.filter(category => !category.is_closed)
        },
        setTaskStatuses(state, taskStatuses) {
            state.taskStatuses = taskStatuses
            state.openedTaskStatus = taskStatuses.filter(taskStatuses => !taskStatuses.is_closed)
        },
        setProjectList(state, projectsList) {
            state.projectsList = projectsList
        },
    },

    actions: {
        getCategories(context) {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.get('/api/categories')
                        .then(response => {
                            context.commit('setCategories', response.data);
                        })
                })
        },

        getTaskStatuses(context) {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.get('/api/taskStatuses')
                        .then(response => {
                            context.commit('setTaskStatuses', response.data);
                        })
                })
        },

        getProjectsList(context) {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.get('/api/projects/list')
                        .then(response => {
                            context.commit('setProjectList', response.data);
                        });
                })
        }
    },

    getters: {
        categories: state => state.categories,
        taskStatuses: state => state.taskStatuses,
        user: state => state.user,
        openedCategories: state => state.openedCategories,
        openedTaskStatus: state => state.openedTaskStatus,
        projectsList: state => state.projectsList,
    },

};
