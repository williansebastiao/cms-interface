<template>
	<b-dropdown class="block__dropdown" trigger="click" position="is-bottom-left" v-if="btn">
		<svg-icon class="dots" slot="trigger" icon="dots"></svg-icon>
		<b-dropdown-item v-for="(l, i) in items" :key="i" :class="l.color ? l.color : 'has-text-grey-light'" v-show="showDelete(l.name)" @click="handleClick(l, id)">
			<div v-if="showDelete(l.name)">
				<svg-icon :icon="l.icon"></svg-icon>
				<span>{{ l.name }}</span>
			</div>
		</b-dropdown-item>
	</b-dropdown>
</template>
<script>
import Icon from '@/components/Icon'
import eventHub from '@/services/eventHub'

export default {
	name: 'Trigger',
	components: {
		'svg-icon': Icon
	},
	props: {
		id: {
			type: String,
			required: false
		},
		permission: {
			type: String,
			required: false
		},
		visible: {
			type: Object,
			required: false
		},
		items: {
			type: Array,
			required: false,
			default: () => {
				return [
					{
						name: 'Edit',
						icon: 'edit'
					},
					{
						name: 'Delete',
						icon: 'trash',
						color: 'has-text-danger'
					}
				]
			}
		}
	},
	data() {
		return {
			role: {},
			btn: true
		}
	},
	methods: {
		handleClick(el, id) {
			const name = el.name
			if (name === 'Edit') {
				eventHub.$emit('open-modal-role', {
					id
				})
			} else {
				eventHub.$emit('delete-role', {
					id
				})
			}
		},
		showDelete(name) {
			try {
				const permission = this.permission
				const role = this.role

				switch (role) {
					case 'root':
						if (permission === 'administrator' || permission === 'user') {
							if (name === 'Edit') {
								return true
							} else {
								return false
							}
						} else if (permission !== 'administrator' || permission !== 'user') {
							if (name === 'Edit') {
								return this.visible.edit
							} else {
								return this.visible.delete
							}
						}
						break
					case 'user':
					default:
						if (permission === 'administrator' || permission === 'user') {
							if (name === 'Edit') {
								return true
							} else {
								return false
							}
						} else if (permission !== 'administrator' || permission !== 'user') {
							if (name === 'Edit') {
								return this.visible.edit
							} else {
								return this.visible.delete
							}
						}
				}
			} catch (e) {
				console.log(e)
			}
		},
		showButton() {
			const permission = this.permission
			const edit = this.visible.edit
			const del = this.visible.delete
			if (permission !== 'administrator' || permission !== 'user') {
				if (edit || del) {
					this.btn = true
				} else {
					this.btn = false
				}
			}
		}
	},
	created() {
		eventHub.$off()
		eventHub.$on('me', obj => {
			const { role } = obj
			this.role = role.name
		})
	}
}
</script>
