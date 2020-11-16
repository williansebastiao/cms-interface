<template>
	<div class="notifications">
		<button class="notifications__button" @click="toggleNotification">
			<svg-icon icon="bell"></svg-icon>
			<span class="notifications__button__icon">8</span>
		</button>
		<div class="notifications__list" :class="{ active: opened }" v-on:mouseleave="toggleNotification">
			<ul class="scroll">
				<li v-for="(n, i) in notifications" :key="i">
					<a :href="n.url" :class="{ read: n.read }">
						<i :class="n.icon"></i>
						<span>
							<h3 class="notifications__list__title">{{ n.title }}</h3>
							<p class="notifications__list__description">{{ n.description }}</p>
						</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
import Icon from '@/components/Icon'

export default {
	name: 'Notifications',
	components: {
		'svg-icon': Icon
	},
	data() {
		return {
			opened: false,
			notifications: [
				{
					read: false,
					icon: 'mdi mdi-file-pdf has-text-info',
					title: '5 new user generated report',
					description: 'Reports based on sales',
					url: '/profile'
				},
				{
					read: false,
					icon: 'mdi mdi-cloud-download-outline has-text-warning',
					title: '2.8 GB-total downloads size',
					description: 'Mostly PSD end AL concepts',
					url: '/profile'
				},
				{
					read: false,
					icon: 'mdi mdi-shield-check has-text-danger',
					title: '3 Defence alerts',
					description: '40% less alerts thar last week',
					url: ''
				},
				{
					read: true,
					icon: 'mdi mdi-cart-variant has-text-success',
					title: '$2900 worth producucts sold',
					description: 'Total 234 items',
					url: ''
				},
				{
					read: true,
					icon: 'mdi mdi-toolbox-outline has-text-success',
					title: '2 new items submited',
					description: 'by Grog John',
					url: ''
				},
				{
					read: true,
					icon: 'mdi mdi-newspaper-variant-outline has-text-warning',
					title: 'Avarage 4 blog posts per author',
					description: 'Most posted 12 time',
					url: ''
				},
				{
					read: true,
					icon: 'mdi mdi-account-multiple has-text-info',
					title: '16 authors joined last week',
					description: '9 photodrapehrs, 7 designer',
					url: ''
				},
				{
					read: true,
					icon: 'mdi mdi-send has-text-danger',
					title: '4.5h-avarage response time',
					description: 'Fostest is Barry',
					url: ''
				}
			]
		}
	},
	methods: {
		toggleNotification() {
			this.opened = !this.opened
		}
	}
}
</script>
