<template>
	<Layout>
		<div class="columns">
			<Title />
			<Weather :bordered="false" />
		</div>
		<section class="profile columns">
			<div class="column is-one-third">
				<article class="profile__column profile__column--menu">
					<div class="profile__infos">

					</div>
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
					<p>huahuahua</p>
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
			}
		}
	}
}
</script>
