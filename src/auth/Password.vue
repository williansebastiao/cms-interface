<template>
	<transition name="slide-fade" mode="out-in">
		<Layout>
			<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
				<form class="auth__form" @submit.prevent="handleSubmit(setPassword)">
					<Logo />
					<div class="mb-5 text-center">
						<h1 class="has-text-primary is-size-4 is-bold">Set your new password</h1>
						<p>
							<span>to access your account and</span>
							<router-link :to="{ name: 'Login' }" class="is-semibold pl-2">back to login</router-link>
						</p>
					</div>

					<InputWithValidation tab="1" class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="auth.email" />
					<InputWithValidation tab="2" class="mb-5" rules="required|min:8" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="auth.password"></InputWithValidation>
					<InputWithValidation tab="3" class="mb-5" rules="required|min:8" type="password" label="Confirm password" vid="confirmPassword" size="is-medium" password-reveal v-model="auth.password_confirmation"></InputWithValidation>

					<span class="is-block text-center">
						<b-button tabindex="4" native-type="submit" class="button is-button is-primary" :loading="loading">Sign In</b-button>
					</span>
				</form>
			</ValidationObserver>
		</Layout>
	</transition>
</template>

<script>
import Layout from '@/layouts/Auth'
import Logo from '@/components/Logo'
import InputWithValidation from '@/components/inputs/InputWithValidation'
import { ValidationObserver } from 'vee-validate'
import { ToastProgrammatic as Toast } from 'buefy'
import Api from '@/services/api'

export default {
	components: {
		Layout,
		Logo,
		InputWithValidation,
		ValidationObserver
	},
	data() {
		return {
			loading: false,
			auth: {
				email: '',
				password: '',
				password_confirmation: '',
				token: this.$route.params.token
			}
		}
	},
	methods: {
		async setPassword() {
			try {
				this.loading = true
				const response = await Api.post('user/reset', this.auth)
				const { status } = response
				if (status === 200) {
					const { message } = response.data
					Toast.open({
						message,
						type: 'is-success',
						position: 'is-bottom-right'
					})
					localStorage.setItem('@stup:email', this.auth.email)
					setTimeout(async () => {
						await this.$router.push('/')
					}, 500)
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
