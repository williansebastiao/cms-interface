export default [
	{
		path: '/profile/',
		name: 'Profile',
		icon: 'profile',
		component: () => import('@/pages/profile/Address'),
		children: [
			{
				path: '',
				name: 'Personal Information',
				icon: 'profile',
				component: () => import('@/pages/profile/Address')
			},
			{
				path: 'address',
				name: 'Address Informations',
				icon: 'profile',
				component: () => import('@/pages/profile/Address')
			},
			{
				path: 'notifications',
				name: 'Notification Settings',
				icon: 'bell',
				component: () => import('@/pages/profile/Notifications')
			},
			{
				path: 'password',
				name: 'Password Security',
				icon: 'roles',
				component: () => import('@/pages/profile/Password')
			}
		]
	}
]
