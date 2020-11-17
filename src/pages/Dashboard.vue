<template>
	<Layout>
		<div class="columns">
			<Title />
			<Weather :bordered="false" dashboard-step="1" />
			<Notifications dashboard-step="2" />
		</div>
		<div class="columns">
			<div class="column">
				<h3 class="is-size-3 is-bold has-text-primary mt-5">{{ $t('hi') }}</h3>
				<p class="is-size-4 mb-5" dashboard-step="2">{{ $t('message') }}</p>
				<Languages />
			</div>
			<div class="column"></div>
		</div>
		<v-tour name="dashboard" :steps="steps" :callbacks="callbacks"></v-tour>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Title from '@/components/Title'
import Weather from '@/components/Weather'
import Notifications from '@/components/Notifications'
import Languages from '@/components/Languages'

export default {
	name: 'Dashboard',
	components: {
		Layout,
		Title,
		Weather,
		Notifications,
		Languages
	},
	data() {
		return {
			bordered: true,
			callbacks: {
				onFinish: this.endOfTour
			},
			steps: [
				{
					target: '[dashboard-step="1"]',
					header: {
						title: 'Hello!'
					},
					content: `You started our tour! <br><small>This is your location.</small>`,
					params: {
						placement: 'left'
					}
				},
				{
					target: '[dashboard-step="2"]',
					content: 'Here are your system notifications, stay plugged.',
					params: {
						placement: 'bottom'
					}
				}
			]
		}
	},
	mounted: function() {
		this.startTour()
	},
	methods: {
		startTour() {
			let hidden = localStorage.getItem('@stup:tour')
			if (!hidden) {
				this.$tours['dashboard'].start()
			}
		},
		endOfTour() {
			localStorage.setItem('@stup:tour', 'hidden')
		}
	}
}
</script>
