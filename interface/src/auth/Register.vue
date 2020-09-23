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

					<InputWithValidation rules="required|min:5" class="mb-5" type="text" label="Name" size="is-medium" v-model="name" />

					<InputWithValidation class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="email" />

					<InputWithValidation rules="required|min:6" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="password" />

					<password-meter class="mb-5" :password="password" @score="Score" />

					<span class="is-block text-center">
						<b-button native-type="submit" class="button is-button is-primary" @click="handleSubmit(Register($event))">Register</b-button>
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
			name: '',
			email: '',
			password: ''
		}
	},
	methods: {
		Register(e) {
			e.preventDefault()
			console.log('Form submitted yay!')
		},
		Score({ score, strength }) {
			console.log(score) // from 0 to 4
			console.log(strength) // one of : 'risky', 'guessable', 'weak', 'safe' , 'secure'
			this.score = score
		}
	}
}
</script>
