import auth from '@/middleware/auth'

export default [
	{
		path: '/dashboard',
		name: 'Dashboard',
		icon: 'dashboard',
		visible: JSON.parse(localStorage.getItem('@stup:dashboard')),
		beforeEnter: auth,
		component: () => import('@/pages/Dashboard')
	},
	{
		path: '/roles',
		name: 'Roles',
		icon: 'roles',
		visible: JSON.parse(localStorage.getItem('@stup:roles')),
		beforeEnter: auth,
		component: () => import('@/pages/Roles')
	},
	{
		path: '/users/:page?/:id?',
		name: 'Users',
		icon: 'users',
		visible: JSON.parse(localStorage.getItem('@stup:users')),
		beforeEnter: auth,
		component: () => import('@/pages/Users')
	}
]
