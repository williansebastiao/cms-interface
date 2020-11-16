<template>
	<Layout>
		<div class="columns">
			<Title dashboard-step="1" />
			<Weather :bordered="false" />
			<Notifications />
		</div>
		<div class="columns">
			<div class="column">
				<span dashboard-step="2">Under construction...</span>
			</div>
			<div class="column">
				<p>kkkkk</p>
			</div>
		</div>

		<v-tour name="dashboard" :steps="steps"></v-tour>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Title from '@/components/Title'
import Weather from '@/components/Weather'
import Notifications from '@/components/Notifications'

export default {
	name: 'Dashboard',
	components: {
		Layout,
		Title,
		Weather,
		Notifications
	},
	data() {
		return {
			bordered: true,
			steps: [
				{
					target: '[dashboard-step="1"]',
					header: {
						title: 'Hello!'
					},
					content: `You started our tour!`,
					params: {
						placement: 'bottom'
					}
				},
				{
					target: '[dashboard-step="2"]',
					content: 'Try it, you will love it!<br>You can put HTML in the steps and completely customize the DOM to suit your needs.',
					params: {
						placement: 'bottom'
					}
				}
			]
		}
	},
	mounted: function() {
		this.$tours['dashboard'].start()
	}
}
</script>
