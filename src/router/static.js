export default [
	{
		path: '/termos-de-uso',
		name: 'Terms',
		component: () => import('@/pages/Terms')
	},
	{
		path: '/politica-de-privacidade',
		name: 'Privacy',
		component: () => import('@/pages/Privacy')
	},
	{
		path: '/contato',
		name: 'Contact',
		component: () => import('@/pages/Contact')
	}
]
