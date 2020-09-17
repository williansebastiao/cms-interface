<template>
	<transition name="slide-fade" mode="out-in">
		<Layout>
			<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
				<form class="auth__form" action="#">
					<Logo />
					<div class="mb-5 text-center">
						<h1 class="has-text-primary is-size-3 is-bold">Sign In</h1>
						<p>
							or
							<router-link :to="{ name: 'Register' }" class="is-semibold">create your account</router-link>
						</p>
					</div>

					<InputWithValidation class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="email" />

					<InputWithValidation class="mb-5" rules="required|min:6" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="password">
						<router-link :to="{ name: 'Forgot' }" class="auth__forgot is-primary is-semibold">Forgot your password?</router-link>
					</InputWithValidation>

					<span class="is-block text-center">
						<b-button native-type="submit" class="button is-button is-primary" @click="handleSubmit(SignIn($event))">Sign In</b-button>
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

export default {
	components: {
		Layout,
		Logo,
		InputWithValidation,
		ValidationObserver
	},
	data() {
		return {
			email: '',
			password: ''
		}
	},
	methods: {
		SignIn(e) {
			e.preventDefault()
			console.log('Form submitted yay!')
		}
	}
}
</script>
