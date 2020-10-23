<template>
	<b-dropdown class="block__dropdown" trigger="click" position="is-bottom-left">
		<svg-icon class="dots" slot="trigger" icon="dots"></svg-icon>
		<b-dropdown-item v-for="(l, i) in items" :key="i" :class="l.color ? l.color : 'has-text-grey-light'" @click="l.action">
			<svg-icon :icon="l.icon"></svg-icon>
			<span>{{ l.name }} 1</span>
		</b-dropdown-item>
	</b-dropdown>
</template>

<script>
import Icon from '@/components/Icon'
export default {
	name: 'Trigger',
	components: {
		'svg-icon': Icon
	},
	data() {

	},
	methods: {

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
	}
}
</script>
