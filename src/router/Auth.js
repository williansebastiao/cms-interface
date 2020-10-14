import guest from  '@/middleware/guest'

export default [
	{
		path: '/login',
		alias: '/',
		name: 'Login',
		beforeEnter: guest,
		component: () => import('@/auth/Login')
	},
	{
		path: '/forgot',
		name: 'Forgot',
		beforeEnter: guest,
		component: () => import('@/auth/Forgot')
	},
	{
		path: '/register',
		name: 'Register',
		beforeEnter: guest,
		component: () => import('@/auth/Register')
	}
]
