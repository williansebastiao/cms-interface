<template>
	<section class="columns is-mobile">
		<Title />
		<div class="column page__actions">
			<slot></slot>
		</div>
		<Weather :bordered="bordered" dashboard-step="1" />
		<Notifications dashboard-step="2" />
	</section>
</template>

<script>
import Title from '@/components/Title'
import Weather from '@/components/Weather'
import Notifications from '@/components/Notifications'

export default {
	name: 'Header',
	components: {
		Title,
		Weather,
		Notifications
	},
	props: {
		bordered: {
			type: Boolean,
			default: true
		}
	},
	computed: {
		name() {
			return this.$route.name
		}
	}
}
</script>
