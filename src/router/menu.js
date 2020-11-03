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
		// children: [
		// 	{
		// 		path: 'create',
		// 		component: () => import('@/components/modals/User'),
		// 		props: true
		// 	}
		// ]
	},
	// {
	// 	path: '/chat',
	// 	name: 'Chat',
	// 	icon: 'chat',
	// 	//beforeEnter: guest,
	// 	component: () => import('@/pages/Privacy')
	// },
	// {
	// 	path: '/charts',
	// 	name: 'Charts',
	// 	icon: 'charts',
	// 	//beforeEnter: guest,
	// 	component: () => import('@/pages/Terms')
	// },
	// {
	// 	path: '/settings',
	// 	name: 'Settings',
	// 	icon: 'settings',
	// 	//beforeEnter: guest,
	// 	component: () => import('@/pages/Contact')
	// }
]
