<template>
	<transition name="errors">
		<Layout class="error">
			<section class="error__wrapper">
				<h1 class="error__name">
					<span>4</span>
					<span>0</span>
					<span>4</span>
				</h1>
				<p class="error__message">
					<strong>{{ title }}</strong>
					<span>{{ message }}</span>
				</p>
				<router-link tag="a" class="button is-button is-primary" :to="{ name: 'Dashboard' }">Go Back</router-link>
			</section>
		</Layout>
	</transition>
</template>

<script>
import Layout from '@/layouts/Default'

export default {
	name: '404',
	components: {
		Layout
	},
	data() {
		return {
			type: true,
			title: 'OOOPS...',
			message: 'Something went wrong here!'
		}
	}
}
</script>
