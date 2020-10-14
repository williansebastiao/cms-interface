function auth(to, from, next) {
	const token = localStorage.getItem('@stup:token')
	if(!token) {
		next('Login')
	}
	return next()
}

export default auth
