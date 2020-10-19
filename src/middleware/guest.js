function guest(to, from, next) {
	const token = localStorage.getItem('@stup:token')
	if (token) {
		next('dashboard')
	}
	return next()
}

export default guest
