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

					<InputWithValidation class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="auth.email">
						<router-link :to="{ name: 'Login' }" class="auth__forgot is-primary is-semibold">Remember your password?</router-link>
					</InputWithValidation>

					<span class="is-block text-center">
						<b-button v-show="!loading" native-type="submit" class="button is-button is-primary" @click="handleSubmit(reset($event))">Send</b-button>
						<b-button v-show="loading" native-type="button" class="button is-button is-primary">Loading...</b-button>
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
				email: ''
			}
		}
	},
	methods: {
		async reset(e) {
			e.preventDefault()
			try {
				this.loading = true

				const response = await Api.post('client/email', this.auth)
				const {status} = response
				if(status === 200) {
					const {message} = response.data
					Toast.open({message, type: 'is-success', position: 'is-bottom-right'})
				}
			} catch (e) {
				const { status } = e
				if (status === 422) {
					const { message } = e.data
					Toast.open({
						message,
						type: 'is-danger',
						position: 'is-bottom-right'
					})
				}
			} finally {
				this.loading = true
			}
		}
	}
}
</script>
