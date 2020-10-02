<template>
	<transition name="slide-fade" mode="out-in">
		<Layout>
			<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
				<form class="auth__form" action="#">
					<Logo />
					<div class="mb-5 text-center">
						<h1 class="has-text-primary is-size-4 is-bold">Forgotten your password?</h1>
						<p>Enter your email to reset your password.</p>
					</div>

					<InputWithValidation class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="email">
						<router-link :to="{ name: 'Login' }" class="auth__forgot is-primary is-semibold">Remember your password?</router-link>
					</InputWithValidation>

					<span class="is-block text-center">
						<b-button native-type="submit" class="button is-button is-primary" @click="handleSubmit(Send($event))">Send</b-button>
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
			email: ''
		}
	},
	methods: {
		Send(e) {
			e.preventDefault()
			console.log('Form submitted yay!')
		}
	}
}
</script>
