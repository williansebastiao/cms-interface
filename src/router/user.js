export default [
	{
		path: '/profile',
		name: 'Profile',
		icon: 'profile',
		component: () => import('@/pages/Privacy')
	},
	{
		path: '/logout',
		name: 'Logout',
		icon: 'logout',
		component: () => import('@/auth/Login')
	}
]
