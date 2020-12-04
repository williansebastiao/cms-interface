<template>
	<b-dropdown class="block__dropdown" trigger="click" position="is-bottom-left" v-if="this.visible.edit || this.visible.delete">
		<svg-icon class="dots" slot="trigger" icon="dots"></svg-icon>
		<b-dropdown-item v-for="(l, i) in items" :key="i" :class="l.color ? l.color : 'has-text-grey-light'" :data-id="id" @click="handleClick(l, id)">
			<div v-if="showButtons(l.name)">
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
	methods: {
		handleClick(el, id) {
			const name = el.name
			if (name === 'Edit') {
				eventHub.$emit('open-modal-users', {
					id
				})
			} else {
				eventHub.$emit('delete-users', {
					id
				})
			}
		},
		showButtons(name) {
			try {
				if (this.role === 'root') {
					if (name === 'Edit') {
						return this.visible.edit
					} else {
						return false
					}
				} else {
					if (name === 'Edit') {
						return this.visible.edit
					} else {
						return this.visible.delete
					}
				}
			} catch (e) {
				console.log(e)
			}
		}
	}
}
</script>
