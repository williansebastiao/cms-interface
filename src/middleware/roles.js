import Api from '@/services/api'

async function roles() {
	try {
		const response = await Api.get('user/me')
		const { permission } = response.data
		const routes = permission.route

		const url = window.location.href.split('/')[3]
		const route = routes.find(e => e.slug === url)

		console.log(route)

		switch (url) {
			case 'users':
				return route.role
			case 'roles':
				return route.role
		}
	} catch (e) {
		console.log(e)
	}
}

export default roles
