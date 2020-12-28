<template>
	<b-dropdown class="block__dropdown" trigger="click" position="is-bottom-left" v-if="this.visible.edit || this.visible.delete">
		<svg-icon class="dots" slot="trigger" icon="dots"></svg-icon>
		<b-dropdown-item v-for="(l, i) in items" :key="i" :class="l.color ? l.color : 'has-text-grey-light'" v-show="showButtons(l.id)" @click="handleClick(l, id)">
			<div v-if="showButtons(l.id)">
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
			required: true
		},
		visible: {
			type: Object,
			required: true
		},
		role: {
			type: String,
			required: true
		},
		active: {
			type: Boolean,
			required: true
		},
		name: {
			type: String,
			required: true
		},
		items: {
			type: Array,
			required: false,
			default: () => {
				return [
					{
						id: 1,
						name: 'Edit',
						icon: 'edit'
					},
					{
						id: 2,
						name: 'Restore',
						icon: 'restore',
						color: 'has-text-info'
					},
					{
						id: 3,
						name: 'Deactivate',
						icon: 'restore',
						color: 'has-text-info'
					},
					{
						id: 4,
						name: 'Active',
						icon: 'restore',
						color: 'has-text-info'
					},
					{
						id: 5,
						name: 'Delete',
						icon: 'trash',
						color: 'has-text-danger'
					}
				]
			}
		}
	},
	methods: {
		handleClick(el, id) {
			const name = el.id
			if (name === 1) {
				eventHub.$emit('edit-modal-users', {
					id,
					root: this.role
				})
			} else if (name === 5) {
				eventHub.$emit('delete-users', {
					id
				})
			} else if (name === 4) {
				eventHub.$emit('restore-users', {
					id
				})
			} else if (name === 3) {
				eventHub.$emit('disable-users', {
					id
				})
			}
		},
		showButtons(name) {
			try {
				if (this.role === 'root') {
					if (name === 1) {
						return this.visible.edit
					} else {
						return false
					}
				} else {
					if (this.active) {
						if (name === 1) {
							return this.visible.edit
						} else if (name === 5) {
							return this.visible.delete
						} else if (name === 3) {
							return true
						}
					} else {
						if (name === 1) {
							return false
						} else if (name === 5) {
							return false
						} else if (name === 4) {
							return true
						}
					}
				}
			} catch (e) {
				console.log(e)
			}
		}
	}
}
</script>
