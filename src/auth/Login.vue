<template>
	<transition name="slide-fade" mode="out-in">
		<Layout>
			<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
				<form class="auth__form" @submit.prevent="handleSubmit(signIn)">
					<Logo />
					<div class="mb-5 text-center">
						<h1 class="has-text-primary is-size-3 is-bold">Sign In</h1>
						<p>
							or
							<router-link :to="{ name: 'Register' }" class="is-semibold">create your account</router-link>
						</p>
					</div>

					<InputWithValidation tab="1" class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="auth.email" />

					<InputWithValidation tab="2" class="mb-5" rules="required|min:8" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="auth.password">
						<router-link :to="{ name: 'Forgot' }" class="auth__forgot is-primary is-semibold" tabindex="4">Forgot your password?</router-link>
					</InputWithValidation>

					<span class="is-block text-center">
						<b-button tabindex="3" native-type="submit" class="button is-button is-primary" :loading="loading">Sign In</b-button>
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
import Api from '@/services/api'
import { ToastProgrammatic as Toast } from 'buefy'

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
				password: ''
			}
		}
	},
	methods: {
		async signIn() {
			try {
				this.loading = true
				const response = await Api.post('client/authenticate', this.auth)
				const { status } = response
				if (status === 200) {
					const { token } = response.data
					localStorage.setItem('@stup:token', token)
					await this.$router.push('dashboard')
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
