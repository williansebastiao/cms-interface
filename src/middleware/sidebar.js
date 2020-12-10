import Api from '@/services/api'

function roles(type) {
	Api.get('user/me').then(response => {
		const { permission } = response.data
		const routes = permission.route
		const route = routes.find(e => e.slug === type)
		localStorage.setItem(`@stup:${type}`, route.role.read)
	})
}

export default roles
