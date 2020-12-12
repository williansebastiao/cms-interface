<template>
	<Layout>
		<template>
			<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
				<form @submit.prevent="handleSubmit(updateProfile)">
					<article class="profile__column panel">
						<div class="panel__header">
							<span class="is-flex is-flex-direction-column is-justify-content-center">
								<h3 class="profile__name pt-0 is-semibold is-size-6">Password Security</h3>
								<p class="is-size-7">Update your password</p>
							</span>
							<b-button tabindex="6" native-type="submit" type="is-primary save" :loading="loading" rounded>Save</b-button>
						</div>
						<div class="panel__body">
							<h3 class="profile__section has-text-primary is-semibold is-size-5">User Data</h3>

							<InputWithValidation class="profile__field" tab="1" rules="required|min:8" type="password" label="Old Password" vid="password" size="is-medium" password-reveal v-model="user.old_password" />
							<password-meter class="mb-5" :password="user.old_password" />

							<InputWithValidation class="profile__field" tab="2" rules="required|min:8" type="password" label="New Password" vid="password" size="is-medium" password-reveal v-model="user.password" />
							<password-meter class="mb-5" :password="user.password" />

							<InputWithValidation class="profile__field" tab="3" rules="required|min:8" type="password" label="Confirm your Password" vid="password" size="is-medium" password-reveal v-model="user.confirm_password" />
							<password-meter class="mb-5" :password="user.confirm_password" />
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
import PasswordMeter from 'vue-simple-password-meter'
import Api from '@/services/api'
import { ValidationObserver } from 'vee-validate'
import { ToastProgrammatic as Toast } from 'buefy'

export default {
	name: 'Password',
	components: {
		Layout,
		InputWithValidation,
		ValidationObserver,
		PasswordMeter
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
				const response = await Api.put(`user/password`, this.user)
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
	}
}
</script>
