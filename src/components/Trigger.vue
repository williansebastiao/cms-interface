<template>
	<b-dropdown class="block__dropdown" trigger="click" position="is-bottom-left">
		<svg-icon class="dots" slot="trigger" icon="dots"></svg-icon>
		<b-dropdown-item v-for="(l, i) in items" :key="i" :class="l.color ? l.color : 'has-text-grey-light'" :data-id="id" @click="handleClick(l, id)">
			<svg-icon :icon="l.icon"></svg-icon>
			<span>{{ l.name }}</span>
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
		items: {
			type: Array,
			required: true
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
		}
	}
}
</script>
