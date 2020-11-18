export default [
	{
		path: '/profile',
		name: 'Profile',
		icon: 'profile',
		component: () => import('@/pages/profile/Personal'),
		children: [
			{
				path: '/profile',
				name: 'Personal Information',
				icon: 'profile',
				component: () => import('@/pages/profile/Personal')
			},
			{
				path: '/profile/address',
				name: 'Address Information',
				icon: 'profile',
				component: () => import('@/pages/profile/Address')
			},
			{
				path: '/profile/notifications',
				name: 'Notification Settings',
				icon: 'bell',
				component: () => import('@/pages/profile/Notifications')
			},
			{
				path: '/profile/password',
				name: 'Password Security',
				icon: 'roles',
				component: () => import('@/pages/profile/Password')
			}
		]
	}
]
