<template>
	<transition name="errors">
		<Layout class="error">
			<Error class="error__page" :message="message" :back="true">
				<h1 class="error__name">
					<span>4</span>
					<span>0</span>
					<span>4</span>
				</h1>
			</Error>
		</Layout>
	</transition>
</template>

<script>
import Layout from '@/layouts/Default'
import Error from '@/components/Error'

export default {
	name: 'NotFound',
	components: {
		Layout,
		Error
	},
	data() {
		return {
			message: 'Something <strong>went wrong</strong> here!'
		}
	}
}
</script>
