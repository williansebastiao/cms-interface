import auth from '@/middleware/auth'

export default [
	{
		path: '/dashboard',
		name: 'Dashboard',
		icon: 'dashboard',
		beforeEnter: auth,
		component: () => import('@/pages/Dashboard')
	},
	{
		path: '/roles',
		name: 'Roles',
		icon: 'roles',
		// beforeEnter: auth,
		component: () => import('@/pages/Roles')
	},
	{
		path: '/users',
		name: 'Users',
		icon: 'users',
		// beforeEnter: auth,
		component: () => import('@/pages/Users')
	},
	{
		path: '/404',
		name: '404',
		beforeEnter: auth,
		component: () => import('@/errors/404')
	}
]
