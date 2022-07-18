import admin from '@/middleware/admin'
export default [
    {
        path: '/',
        name: 'front',
        component: () => import('@/layouts/FrontendLayout.vue'),
        meta: {
            layout: 'Front'
        },
        children: [
            {
                path: '',
                component: () => import('@/views/Frontend/index.vue'),
                name: 'front.index'
            },
            {
                path: 'service',
                component: () => import('@/views/Frontend/service.vue'),
                name: 'front.service'
            }


        ]
    }]
