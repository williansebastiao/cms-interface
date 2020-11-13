<template>
	<Layout>
		<div class="columns">
			<Title />
			<Weather :bordered="false" />
		</div>
		<section class="profile columns">
			<div class="column is-one-third">
				<article class="profile__column profile__column--menu">
					<div class="profile__infos"></div>
					<ul class="profile__list">
						<li>
							<span class="profile__list__key">Phone:</span>
							<a href="#" class="profile__list__value">{{ user.phone }}</a>
						</li>
						<li>
							<span class="profile__list__label">Email:</span>
							<a href="#" class="profile__list__value">{{ user.email }}</a>
						</li>
						<li>
							<span class="profile__list__label">Location:</span>
							<span class="profile__list__value">{{ user.email }}</span>
						</li>
					</ul>
					<ul class="profile__navigation">
						<li v-for="(m, i) in navigation" :key="i">
							<router-link tag="a" :to="m.route">
								<svg-icon :icon="m.icon"></svg-icon>
								<span>{{ m.name }}</span>
							</router-link>
						</li>
					</ul>
				</article>
			</div>
			<div class="column">
				<article class="profile__column">
					<ul>
						<li v-for="message in messages" v-html="message.text" :key="message._id"></li>
					</ul>
					<textarea v-model="message" style="width: 100%;height: 100px"></textarea>
					<button type="button" @click="send">Enviar</button>
				</article>
			</div>
		</section>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Title from '@/components/Title'
import Icon from '@/components/Icon'
import Weather from '@/components/Weather'
import Pusher from 'pusher-js'
import Api from '@/services/api'

export default {
	name: 'Profile',
	components: {
		Layout,
		Title,
		Weather,
		'svg-icon': Icon
	},
	data() {
		return {
			bordered: true,
			navigation: [
				{
					icon: 'profile',
					name: 'Personal Information',
					route: '/profile'
				},
				{
					icon: 'bell',
					name: 'Notification SettingsS',
					route: '/notification'
				},
				{
					icon: 'roles',
					name: 'Password Security',
					route: '/password'
				}
			],
			user: {
				avatar: null,
				firstname: 'Wallace',
				lastname: 'Erick',
				role: 'Administrator',
				email: 'wallace.erick@orbital.company',
				phone: '11999834963',
				address: {
					code: '07700115',
					street: 'Av. Presidente Kenendy',
					district: null,
					number: '616',
					city: 'Caieiras',
					state: 'SP'
				}
			},
			messages: [],
			message: ''
		}
	},
	methods: {
		subscribe() {
			Pusher.logToConsole = false
			const pusher = new Pusher('53cbf8c7c95b4a051597', {
				cluster: 'mt1'
			})
			const channel = pusher.subscribe('stup')
			channel.bind('notification', obj => {
				this.messages.push(obj)
			})
		},
		async send() {
			try {
				const response = await Api.post('notification/send', {
					message: this.message
				})
				const { status } = response
				if (status === 200) {
					console.log('mensagem enviada')
				}
			} catch (e) {
				console.log(e)
			}
		}
	},
	created() {
		this.subscribe()
		//this.messages = [{text: 'will', _id: '1234456'}]
	}
}
</script>
