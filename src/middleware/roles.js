import Api from '@/services/api'

async function roles() {
	try {
		const response = await Api.get('user/me')
		const { permission } = response.data
		const routes = permission.route

		const url = window.location.href.split('/')[3]
		const route = routes.find(e => e.slug === url)

		switch (url) {
			case 'users':
				return route.role
			case 'roles':
				return route.role
		}

		/*switch (page) {
			case 'read':
				console.log(page)
				console.log(route.role.read)
				break
			case 'create':
				console.log(page)
				console.log(route.role.create)
				break
			case 'edit':
				console.log(page)
				console.log(route.role.edit)
				break
			case 'delete':
				console.log(page)
				console.log(route.role.delete)
				break
		}*/
	} catch (e) {
		console.log(e)
	}
}

export default roles
