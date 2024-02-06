
const routes = [

    {

        path: '/projects/login',
        name: 'login',
        component: () => import('@/components/auth/Login.vue')
    },
    {
        path: '/projects/registration',
        name: 'registration',
        component: () => import('@/components/auth/Registration.vue')
    },
    {
        path: '/projects/:id',
        name: 'projects.show',
        component: () => import('@/components/project/ShowProject.vue')
    },
    {
        path: '/projects',
        name: 'projects.index',
        component: () => import('@/components/project/IndexProject.vue')
    },
    {
        path: '/projects/create',
        name: 'projects.create',
        component: () => import('@/components/project/CreateProject.vue')
    },
    {
        path: '/tasks',
        name: 'tasks.index',
        component: () => import('@/components/task/IndexTask.vue')
    },
    {
        path: '/tasks/create',
        name: 'tasks.create',
        component: () => import('@/components/task/CreateTask.vue')
    },
    {
        path: '/tasks/:id',
        name: 'tasks.show',
        component: () => import('@/components/task/ShowTask.vue')
    },
    {
        path: '/timeProjectsReport',
        name: 'timeProjectsReport',
        component: () => import('@/components/report/timeProjectsReport.vue')
    },
    {
        path: "/:pathMatch(.*)",
        redirect: { name: 'projects.index'}
    }
];




export default routes;
