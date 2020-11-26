export default [
	{
		path: '/profile/',
		name: 'Profile',
		icon: 'profile',
		component: () => import('@/pages/profile/Password'),
		children: [
			{
				path: 'personal',
				name: 'Personal Information',
				icon: 'profile',
				component: () => import('@/pages/profile/Personal')
			},
			{
				path: 'address',
				name: 'Address Information',
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
