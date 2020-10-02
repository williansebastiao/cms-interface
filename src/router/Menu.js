export default [
	{
		path: '/dashboard',
		name: 'Dashboard',
		icon: 'dashboard',
		// beforeEnter: yourGuard,
		component: () => import('@/pages/Dashboard')
	},
	{
		path: '/users',
		name: 'Users',
		icon: 'users',
		component: () => import('@/pages/Users')
		// children: [
		// 	{
		// 		path: 'create',
		// 		component: () => import('@/components/modals/User'),
		// 		props: true
		// 	}
		// ]
	},
	{
		path: '/chat',
		name: 'Chat',
		icon: 'chat',
		component: () => import('@/pages/Privacy')
	},
	{
		path: '/charts',
		name: 'Charts',
		icon: 'charts',
		component: () => import('@/pages/Terms')
	},
	{
		path: '/settings',
		name: 'Settings',
		icon: 'settings',
		component: () => import('@/pages/Contact')
	}
]
