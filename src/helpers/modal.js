import { ModalProgrammatic as Modal } from 'buefy'

const create = (page, component, name) => {
	history.pushState({}, '', `/${page}`)
	history.pushState({}, '', `${page}/create`)
	Modal.open({
		parent: this,
		component: component,
		scroll: 'keep',
		customClass: 'is-user is-sm',
		trapFocus: true,
		onCancel: () => {
			history.pushState({}, '', `/${page}`)
		},
		props: {
			name: name
		}
	})
}

const update = (page, id, component, name) => {
	history.pushState({}, '', `/${page}`)
	history.pushState({}, '', `users/edit/${id}`)
	Modal.open({
		parent: this,
		component: component,
		scroll: 'clip',
		customClass: 'is-user is-sm',
		trapFocus: true,
		onCancel: () => {
			history.pushState({}, '', '/${page}')
		},
		props: {
			id: id,
			name: name
		}
	})
}

export { create, update }
