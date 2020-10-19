function auth(to, from, next) {
	const token = localStorage.getItem('@stup:token')
	if (!token) {
		next('login')
	}
	return next()
}

export default auth
