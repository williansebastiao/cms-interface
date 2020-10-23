<template>
	<section class="error__wrapper error__wrapper--no-results">
		<slot></slot>
		<div class="error__message">
			<svg-icon v-if="icon" class="error__icon" icon="warning"></svg-icon>
			<p class="is-bold is-size-4" v-html="title"></p>
			<p v-html="message"></p>
		</div>
	</section>
</template>

<script>
import Icon from '@/components/Icon'

export default {
	name: 'Error',
	components: {
		'svg-icon': Icon
	},
	props: {
		icon: {
			type: Boolean,
			default: true
		},
		title: {
			type: String,
			default: 'Ooops...'
		},
		message: {
			type: String,
			default: 'Your filter returned with no results'
		},
		back: {
			type: Boolean,
			default: false
		}
	}
}
</script>
