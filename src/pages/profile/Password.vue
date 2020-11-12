<template>
	<Layout>
		<div class="columns">
			<Title />
			<Weather :bordered="false" />
		</div>
		<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
			<section class="profile columns">
				<div class="column profile__sidebar">
					<article class="profile__column ">
						<div class="columns mb-0">
							<div class="column is-one-third profile__image">
								<img :src="user.avatar" :alt="user.full_name" />
							</div>
							<div class="column">
								<h3 class="profile__name is-semibold is-size-5">{{ user.full_name }}</h3>
								<p class="profile__role">{{ user.permission.name }}</p>
							</div>
						</div>
						<ul class="profile__list">
							<li v-if="user.phone">
								<span class="profile__list__key">Phone:</span>
								<a href="#" class="profile__list__value">{{ user.phone }}</a>
							</li>
							<li v-if="user.email">
								<span class="profile__list__key">Email:</span>
								<a href="#" class="profile__list__value">{{ user.email }}</a>
							</li>
							<li v-if="user.address">
								<span class="profile__list__key">Location:</span>
								<span class="profile__list__value">{{ user.address.city }}/{{ user.address.state }}</span>
							</li>
						</ul>
						<ul class="profile__navigation">
							<li v-for="(m, i) in navigation" :key="i">
								<router-link tag="a" :to="m.path">
									<svg-icon :icon="m.icon"></svg-icon>
									<span>{{ m.name }}</span>
								</router-link>
							</li>
						</ul>
					</article>
				</div>
				<form class="column" @submit.prevent="handleSubmit(updateProfile)">
					<article class="profile__column panel">
						<div class="panel__header">
							<span class="is-flex is-flex-direction-column is-justify-content-center">
								<h3 class="profile__name pt-0 is-semibold is-size-6">Password Security</h3>
								<p class="is-size-7">Update your ppassword</p>
							</span>
							<b-button tabindex="6" native-type="submit" type="is-primary save" :loading="loading" rounded>Save</b-button>
						</div>
						<div class="panel__body">
							<h3 class="profile__section has-text-primary is-semibold is-size-5">User Data</h3>

							<InputWithValidation class="profile__field" tab="1" rules="required|min:8" type="password" label="Old password" vid="password" size="is-medium" password-reveal v-model="user.old_password" />
							<password-meter class="mb-5" :password="user.old_password" />

							<InputWithValidation class="profile__field" tab="2" rules="required|min:8" type="password" label="New password" vid="password" size="is-medium" password-reveal v-model="user.password" />
							<password-meter class="mb-5" :password="user.password" />

							<InputWithValidation class="profile__field" tab="3" rules="required|min:8" type="password" label="Confirm password" vid="password" size="is-medium" password-reveal v-model="user.confirm_password" />
							<password-meter class="mb-5" :password="user.confirm_password" />
						</div>
					</article>
				</form>
			</section>
		</ValidationObserver>
	</Layout>
</template>

<script>
import Menu from '@/router/user'
import Layout from '@/layouts/Default'
import Title from '@/components/Title'
import Icon from '@/components/Icon'
import Weather from '@/components/Weather'
import InputWithValidation from '@/components/inputs/InputWithValidation'
import { ValidationObserver } from 'vee-validate'
import PasswordMeter from 'vue-simple-password-meter'
import Api from '@/services/api'

export default {
	name: 'Password',
	components: {
		Layout,
		Title,
		Weather,
		InputWithValidation,
		ValidationObserver,
		PasswordMeter,
		'svg-icon': Icon
	},
	data() {
		return {
			loading: false,
			bordered: true,
			onAccept(e) {
				const maskRef = e.detail
				this.value = maskRef.value
				console.log('accept', maskRef.value)
			},
			user: {}
		}
	},
	computed: {
		navigation() {
			return Menu[0].children
		}
	},
	methods: {
		async me() {
			try {
				const response = await Api.get('user/me')
				const { status } = response
				if (status === 200) {
					this.user = response.data
				}
			} catch (e) {
				console.log(e)
			}
		},
		async updateProfile() {
			try {
				console.log('try')
			} catch (e) {
				console.log(e)
			}
		}
	},
	mounted() {
		this.me()
	}
}
</script>
