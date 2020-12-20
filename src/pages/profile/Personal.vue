<template>
	<Layout>
		<template>
			<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
				<form @submit.prevent="handleSubmit(updateProfile)">
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
							<InputWithValidation class="profile__field" tab="1" rules="required" type="text" label="First Name" v-model="user.first_name" size="is-medium" />

							<InputWithValidation class="profile__field" tab="2" rules="required" type="text" label="Last Name" size="is-medium" v-model="user.last_name" />
						</div>
						<hr />
						<div class="panel__body">
							<h3 class="profile__section has-text-primary is-semibold is-size-5">Contact Info</h3>

							<InputWithValidation class="profile__field" tab="3" type="text" label="Phone" size="is-medium" v-mask="'(##) #####-####'" v-model="user.phone" />

							<InputWithValidation class="profile__field" tab="4" rules="required|email" type="email" label="Email" size="is-medium" v-model="user.email" />

							<InputWithValidation class="profile__field" tab="5" type="text" label="Site" size="is-medium" v-model="user.site" />
						</div>
					</article>
				</form>
			</ValidationObserver>
		</template>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Profile'
import InputWithValidation from '@/components/inputs/InputWithValidation'
import { ValidationObserver } from 'vee-validate'
import { ToastProgrammatic as Toast } from 'buefy'
import Api from '@/services/api'
import eventHub from '@/services/eventHub'

export default {
	name: 'Personal',
	components: {
		Layout,
		InputWithValidation,
		ValidationObserver
	},
	data() {
		return {
			loading: false,
			user: {}
		}
	},
	methods: {
		async updateProfile() {
			try {
				this.loading = true
				if (this.user.site) {
					const url = this.user.site.replace('http://', '').replace('https://', '')
					this.user = { ...this.user, site: `http://${url}` }
				}
				const response = await Api.put(`user/personal`, this.user)
				const { status } = response
				if (status === 200) {
					const { message } = response.data
					Toast.open({
						message,
						type: 'is-success',
						position: 'is-bottom'
					})
				}
			} catch (e) {
				const { status } = e
				if (status === 422) {
					const { message } = e.data
					Toast.open({
						message,
						type: 'is-danger',
						position: 'is-bottom'
					})
				}
			} finally {
				this.loading = false
			}
		}
	},
	mounted() {
		//eventHub.$off()
		eventHub.$on('me', obj => {
			this.user = obj
		})
	}
}
</script>
