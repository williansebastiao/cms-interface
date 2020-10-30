<template>
	<Layout>
		<div class="columns">
			<Title />
		</div>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Title from '@/components/Title'

export default {
	name: 'Profile',
	components: {
		Layout,
		Title
	},
	data() {
		return {
			bordered: true
		}
	},
	mounted: function() {
		// this.$tours['dashboard'].start()
	}
}
</script>
