export default [
	{
		path: '/login',
		alias: '/',
		name: 'Login',
		component: () => import('@/auth/Login')
	},
	{
		path: '/forgot',
		name: 'Forgot',
		component: () => import('@/auth/Forgot')
	},
	{
		path: '/register',
		name: 'Register',
		component: () => import('@/auth/Register')
	}
]
