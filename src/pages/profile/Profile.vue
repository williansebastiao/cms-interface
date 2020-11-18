<template>
	<Layout>
		<Header :bordered="false" />
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
								<p class="profile__role" v-if="user.permission">{{ user.permission.name }}</p>
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
								<h3 class="profile__name pt-0 is-semibold is-size-6">Personal Information</h3>
								<p class="is-size-7">Update your personal informaiton</p>
							</span>
							<b-button tabindex="6" native-type="submit" type="is-primary save" :loading="loading" rounded>Save</b-button>
						</div>
						<div class="panel__body">
							<h3 class="profile__section has-text-primary is-semibold is-size-5">User Data</h3>

							<InputWithValidation class="profile__field" tab="1" rules="required" type="text" label="First Name" size="is-medium" v-model="user.first_name" />

							<InputWithValidation class="profile__field" tab="2" rules="required" type="text" label="Last Name" size="is-medium" v-model="user.last_name" />
						</div>
						<hr />
						<div class="panel__body">
							<h3 class="profile__section has-text-primary is-semibold is-size-5">Contact Info</h3>

							<InputWithValidation class="profile__field" tab="3" type="text" label="Phone" size="is-medium" v-if="user.phone" v-model="user.phone" />

							<InputWithValidation class="profile__field" tab="4" rules="required|email" type="email" label="Email" size="is-medium" v-model="user.email" />

							<InputWithValidation class="profile__field" tab="5" type="text" label="Site" size="is-medium" v-if="user.site" v-model="user.site" />
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
import Header from '@/components/Header'
import Icon from '@/components/Icon'
import InputWithValidation from '@/components/inputs/InputWithValidation'
import { ValidationObserver } from 'vee-validate'
import Api from '@/services/api'

export default {
	name: 'Profile',
	components: {
		Layout,
		Header,
		InputWithValidation,
		ValidationObserver,
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
		updateProfile() {
			this.loading = true
			console.log('Sending...')
		}
	},
	mounted() {
		this.me()
	}
}
</script>
