<template>
	<transition name="slide-fade" mode="out-in">
		<Layout>
			<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
				<form class="auth__form" action="#">
					<Logo />
					<div class="mb-5 text-center">
						<h1 class="has-text-primary is-size-3">
							<span>Set your</span>
							<span class="is-bold">password</span>
						</h1>
						<p>to access your account again</p>
					</div>

					<InputWithValidation class="mb-5" rules="required|min:6" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="auth.password"></InputWithValidation>

					<span class="is-block text-center">
						<b-button native-type="submit" class="button is-button is-primary" :loading="loading" @click="handleSubmit(SignIn($event))">Sign In</b-button>
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
// import { ToastProgrammatic as Toast } from 'buefy'
// import Api from '@/services/api'

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
		//
	}
}
</script>
