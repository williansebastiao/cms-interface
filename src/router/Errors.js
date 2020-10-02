export default [
	{
		path: '*',
		name: 'Error',
		component: () => import('@/errors/404')
	}
]
