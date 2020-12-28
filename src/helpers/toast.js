import { ToastProgrammatic as Toast } from 'buefy'

const toast = (type, message) => {
	Toast.open({
		type: type,
		message: message,
		position: 'is-bottom',
		closable: false,
		duration: 4000
	})
}

export { toast }
