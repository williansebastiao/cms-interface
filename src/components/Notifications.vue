<template>
	<div class="notifications">
		<button class="notifications__button" @click="toggleNotification">
			<svg-icon icon="bell"></svg-icon>
			<span class="notifications__button__icon" v-if="counter > 0">{{ this.counter }}</span>
		</button>
		<div class="notifications__list" :class="{ active: opened }" v-on:mouseleave="toggleNotification">
			<ul class="scroll">
				<li v-for="(n, i) in notifications" :key="i">
					<a href="#!" :class="{ read: n.read }">
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
import Pusher from 'pusher-js'
import Api from '@/services/api'

export default {
	name: 'Notifications',
	components: {
		'svg-icon': Icon
	},
	data() {
		return {
			opened: false,
			notifications: {},
			counter: 0,
			user: {}
		}
	},
	methods: {
		subscribe() {
			Pusher.logToConsole = false
			const pusher = new Pusher('53cbf8c7c95b4a051597', {
				cluster: 'mt1'
			})
			const channel = pusher.subscribe('notification')
			channel.bind('notification', obj => {
				this.notifications.unshift(obj)
				Api.get('user/me').then(res => {
					if (res.data.notification) {
						let counter = res.data.notification['counter']
						localStorage.setItem('@stup:counter', counter)
						this.counter = localStorage.getItem('@stup:counter')
					}
				})
				if (localStorage.getItem('@stup:counter')) {
					this.counter = localStorage.getItem('@stup:counter')
				}
			})
		},
		async toggleNotification() {
			this.opened = !this.opened
			await this.clearNotifications()
		},
		async findAll() {
			try {
				const response = await Api.get('notification/findAll')
				this.notifications = response.data
			} catch (e) {
				console.log(e)
			}
		},
		async countNotification() {
			try {
				const response = await Api.get('user/me')
				const { data } = response
				if (data.notification) {
					let counter = data.notification['counter']
					localStorage.setItem('@stup:counter', counter)
					this.counter = localStorage.getItem('@stup:counter')
				} else {
					let counter = 0
					localStorage.setItem('@stup:counter', counter)
					this.counter = localStorage.getItem('@stup:counter')
				}
			} catch (e) {
				console.log(e)
			}
		},
		async clearNotifications() {
			try {
				await Api.put('notification/clearNotifications')
				let counter = 0
				localStorage.setItem('@stup:counter', counter)
				this.counter = localStorage.getItem('@stup:counter')
			} catch (e) {
				console.log(e)
			}
		}
	},
	mounted() {
		this.countNotification()
		this.findAll()
		if (localStorage.getItem('@stup:counter')) {
			this.counter = localStorage.getItem('@stup:counter')
		}
	},
	created() {
		this.subscribe()
	}
}
</script>
