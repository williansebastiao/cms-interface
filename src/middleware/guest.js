function guest(to, from, next) {
	const token = localStorage.getItem('@stup:token')
	if(token) {
		next('Dashboard')
	}
	return next()
}

export default guest
