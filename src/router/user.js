export default [
	{
		path: '/profile',
		name: 'Profile',
		icon: 'profile',
		component: () => import('@/pages/profile/Profile'),
		children: [
			{
				path: 'notifications',
				name: 'Notification Settings',
				icon: 'bell',
				component: () => import('@/pages/profile/Notifications')
			}
		]
	}
]
