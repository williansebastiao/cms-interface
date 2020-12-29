import { ToastProgrammatic as Toast } from 'buefy'

function toast(type, message) {
	Toast.open({
		type: type,
		message: message,
		position: 'is-bottom',
		closable: false,
		duration: 4000
	})
}

export { toast }
