import {create} from 'apisauce'

const api = create({
	baseURL: process.env.VUE_APP_BASE_API
})

api.addAsyncRequestTransform((request) => () => {
	const token = localStorage.getItem('@stup:token')
	if(token) {
		request.headers['Authorization'] = `Bearer ${token}`
	}
})

api.addResponseTransform((response) => {
	if(!response.ok) {
		throw response
	}
})

export default api
