<template>
	<section class="error__wrapper">
		<slot></slot>
		<div class="error__message">
			<svg-icon v-if="icon" class="error__icon" icon="warning"></svg-icon>
			<p class="is-bold is-size-4" v-html="title"></p>
			<p v-html="message"></p>
		</div>
		<router-link v-if="back" tag="a" class="button is-button is-primary" :to="{ name: 'Dashboard' }">
			<span class="is-thin pr-1">Back to</span>
			<span>Dashboard</span>
		</router-link>
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
			default: false
		},
		title: {
			type: String,
			default: 'Ooops...'
		},
		message: {
			type: String,
			default: 'An error occurred loading this content!'
		},
		back: {
			type: Boolean,
			default: false
		}
	}
}
</script>
