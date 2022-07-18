import admin from '@/middleware/admin';
export default [
	{
        path: '/admin/dashboard',
        name: 'auth.dashboard',
        component: () => import('@/layouts/AdminLayout.vue'),
        meta: {
            layout: 'Admin'
        },
        children: [
            {
                path: '',
                component: () => import('@/views/Admin/Panel.vue'),
                name: 'auth.dashboard'
            }]
    },
    {
        path: '/admin/roles/',
        name: 'auth.roles',
        component: () => import('@/layouts/AdminLayout.vue'),
        meta: {
            layout: 'Admin'
        },
        children: [
            {
                path: '',
                component: () => import('@/views/Admin/Role/List.vue'),
                name: 'auth.roles.listing'
            },
            {
                path: 'add',
                component: () => import('@/views/Admin/Role/Form.vue'),
                name: 'auth.roles.add'
            },
            {
                path: 'edit/:id',
                component: () => import('@/views/Admin/Role/Edit.vue'),
                name: 'auth.roles.edit'
            }
        ],
        beforeEnter: admin,
    },
    {
        path: '/admin/permissions/',
        name: 'auth.permissions',
        component: () => import('@/layouts/AdminLayout.vue'),
        meta: {
            layout: 'Admin'
        },
        children: [
            {
                path: '',
                component: () => import('@/views/Admin/Permission/List.vue'),
                name: 'auth.permissions.listing'
            },
            {
                path: 'add',
                component: () => import('@/views/Admin/Permission/Form.vue'),
                name: 'auth.permissions.add'
            },
            {
                path: 'edit/:id',
                component: () => import('@/views/Admin/Permission/Edit.vue'),
                name: 'auth.permissions.edit'
            }
        ],
        beforeEnter: admin,
    },
    {
        path: '/admin/users/',
        name: 'auth.users',
        component: () => import('@/layouts/AdminLayout.vue'),
        meta: {
            layout: 'Admin'
        },
        children: [
            {
                path: '',
                component: () => import('@/views/Admin/User/List.vue'),
                name: 'auth.users.listing'
            },
            {
                path: 'add',
                component: () => import('@/views/Admin/User/Add.vue'),
                name: 'auth.users.add'
            },
            {
                path: 'edit/:id',
                component: () => import('@/views/Admin/User/Edit.vue'),
                name: 'auth.users.edit'
            },
            {
                path: 'exemption/:uid',
                component: () => import('@/views/Admin/User/Exemption/List.vue'),
                name: 'auth.users.exemption.listing'
            },
            {
                path: 'exemption/:uid/add',
                component: () => import('@/views/Admin/User/Exemption/Form.vue'),
                name: 'auth.users.exemption.add'
            },
            {
                path: 'exemption/:uid/edit/:id',
                component: () => import('@/views/Admin/User/Exemption/Form.vue'),
                name: 'auth.users.exemption.edit'
            },
        ],
        beforeEnter: admin,
    },
];
