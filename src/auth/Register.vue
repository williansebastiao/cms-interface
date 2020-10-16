<template>
	<transition name="slide-fade" mode="out-in">
		<Layout>
			<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
				<form class="auth__form" action="#">
					<Logo />
					<div class="mb-5 text-center">
						<h1 class="has-text-primary is-size-4 is-bold">Create Account</h1>
						<p>
							Already have an account?
							<router-link :to="{ name: 'Login' }" class="is-semibold">Sign In</router-link>
						</p>
					</div>

					<InputWithValidation rules="required|min:5" class="mb-5" type="text" label="Name" size="is-medium" v-model="auth.name" />

					<InputWithValidation class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="auth.email" />

					<InputWithValidation rules="required|min:6" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="auth.password" />

					<password-meter class="mb-5" :password="auth.password" @score="Score" />

					<span class="is-block text-center">
						<b-button native-type="submit" class="button is-button is-primary" :loading="loading" @click="handleSubmit(register($event))">Register</b-button>
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
import PasswordMeter from 'vue-simple-password-meter'
import { ToastProgrammatic as Toast } from 'buefy'
import Api from '@/services/api'

export default {
	components: {
		Layout,
		Logo,
		InputWithValidation,
		ValidationObserver,
		PasswordMeter
	},
	data() {
		return {
			loading: false,
			auth: {
				name: '',
				email: '',
				password: ''
			}
		}
	},
	methods: {
		async register(e) {
			e.preventDefault()
			try {
				this.loading = true
				const response = await Api.post('client/register', this.auth)
				const { status } = response
				if (status === 201) {
					const { token } = response.data
					localStorage.setItem('@stup:token', token)
					await this.$router.push('dashboard')
				}
			} catch (e) {
				const { status } = e
				if (status === 422) {
					const { message } = e.data
					Toast.open({ message, type: 'is-danger', position: 'is-bottom-right' })
				}
			} finally {
				this.loading = false
			}
		},
		Score({ score, strength }) {
			console.log(score) // from 0 to 4
			console.log(strength) // one of : 'risky', 'guessable', 'weak', 'safe' , 'secure'
			this.score = score
		}
	}
}
</script>
