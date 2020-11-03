<template>
	<Layout>
		<div class="columns">
			<Title />
			<Weather :bordered="false" />
		</div>
		<section class="profile columns">
			<div class="column is-one-third">
				<article class="profile__column profile__column--menu">
					<div class="columns mb-0">
						<div class="column is-one-third profile__image">
							<img :src="user.avatar" :alt="user.name">
						</div>
						<div class="column">
							<h3 class="profile__name is-semibold is-size-5">{{ user.firstname }} {{ user.lastname }}</h3>
							<p class="profile__role">{{ user.role }}</p>
						</div>
					</div>
					<ul class="profile__list">
						<li>
							<span class="profile__list__key">Phone:</span>
							<a href="#" class="profile__list__value">{{ user.phone }}</a>
						</li>
						<li>
							<span class="profile__list__key">Email:</span>
							<a href="#" class="profile__list__value">{{ user.email }}</a>
						</li>
						<li>
							<span class="profile__list__key">Location:</span>
							<span class="profile__list__value">{{ user.address.city }}/{{ user.address.state }}</span>
						</li>
					</ul>
					<ul class="profile__navigation">
						<li v-for="(m, i) in menu" :key="i">
							<router-link tag="a" :to="m.path">
								<svg-icon :icon="m.icon"></svg-icon>
								<span>{{ m.name }}</span>
							</router-link>
						</li>
					</ul>
				</article>
			</div>
			<div class="column">
				<article class="profile__column">
					<p>huahuahua</p>
				</article>
			</div>
		</section>
	</Layout>
</template>

<script>
import Menu from '@/router/user'
import Layout from '@/layouts/Default'
import Title from '@/components/Title'
import Icon from '@/components/Icon'
import Weather from '@/components/Weather'

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
			menu: [
				{
					icon: 'profile',
					name: 'Personal Information',
					path: '/profile'
				},
				{
					icon: 'bell',
					name: 'Notification Settings',
					path: '/profile/notifications'
				},
				{
					icon: 'roles',
					name: 'Password Security',
					path: '/profile/password'
				}
			],
			user: {
				avatar: 'https://preview.keenthemes.com/metronic/theme/html/demo3/dist/assets/media/users/300_21.jpg',
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
			}
		}
	},
	computed: {
		navigation() {
			return Menu[0].children
		}
	}
}
</script>
