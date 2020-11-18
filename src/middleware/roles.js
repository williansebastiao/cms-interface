import Api from '@/services/api'

async function roles() {
	try {
		const response = await Api.get('user/me')
		console.log(response)
	} catch (e) {
		console.log(e)
	}
	console.log('roles')
}

export default roles
