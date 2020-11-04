<template>
	<transition name="slide-fade" mode="out-in">
		<Layout>
			<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
				<form class="auth__form" @submit.prevent="handleSubmit(createUser)">
					<Logo />
					<div class="mb-5 text-center">
						<h1 class="has-text-primary is-size-4 is-bold">Create Account</h1>
						<p>
							Already have an account?
							<router-link :to="{ name: 'Login' }" class="is-semibold">Sign In</router-link>
						</p>
					</div>

					<div class="columns mb-5">
						<div class="column pl-0">
							<InputWithValidation tab="1" rules="required|min:3" type="text" label="First Name" size="is-medium" v-model="auth.firstname" />
						</div>
						<div class="column pr-0">
							<InputWithValidation tab="2" rules="required|min:3" type="text" label="Last Name" size="is-medium" v-model="auth.lastname" />
						</div>
					</div>

					<InputWithValidation tab="3" class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="auth.email" />

					<InputWithValidation tab="4" rules="required|min:8" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="auth.password" />

					<password-meter class="mb-5" :password="auth.password" @score="Score" />

					<span class="is-block text-center">
						<b-button tabindex="5" native-type="submit" class="button is-button is-primary" :loading="loading">Register</b-button>
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
				firstname: '',
				lastname: '',
				email: '',
				password: ''
			}
		}
	},
	methods: {
		async createUser() {
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
					Toast.open({
						message,
						type: 'is-danger',
						position: 'is-bottom'
					})
				}
			} finally {
				this.loading = false
			}
		},
		Score({ score, strength }) {
			console.log(score, strength) // score: from 0 to 4 - strength: 'risky', 'guessable', 'weak', 'safe' , 'secure'
			this.score = score
		}
	}
}
</script>
