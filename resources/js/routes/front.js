import admin from '@/middleware/admin'
export default [
    {
        path: '/',
        name: 'index',
        component: () => import('@/layouts/FrontendLayout.vue'),
        meta: {
            layout: 'Front'
        },
        children: [
            {
                path: '',
                component: () => import('@/views/Frontend/index.vue'),
                name: 'index'
            },
            {
                path: 'service',
                component: () => import('@/views/Frontend/service.vue'),
                name: 'service'
            }


        ]
    }]
