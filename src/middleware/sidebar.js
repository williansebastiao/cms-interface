function roles(type, obj) {
	const { permission } = obj
	const routes = permission.route
	const route = routes.find(e => e.slug === type)
	localStorage.removeItem(`@stup:${type}`)
	localStorage.setItem(`@stup:${type}`, route.role.read)
}

export default roles
