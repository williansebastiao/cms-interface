<template>
	<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
		<form @submit.prevent="handleSubmit(saveUser)">
			<header class="modal-card-head">
				<h4 class="modal-card-title">
					New
					<strong>User</strong>
				</h4>
			</header>
			<div class="modal-card-body">
				<div class="modal-card mb-3">
					<InputWithValidation class="mb-4" rules="required|min:3" type="text" label="Name" size="is-medium" v-model="name" />

					<InputWithValidation class="mb-4" rules="required|email" type="email" label="Email" size="is-medium" v-model="email" />

					<SelectWithValidation class="mb-4" rules="required" label="Role" size="is-medium" v-model="role">
						<option v-for="r in roles" :value="r.id" :key="r.id">{{ r.name }}</option>
					</SelectWithValidation>

					<InputWithValidation rules="required|min:8" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="password" />
					<password-meter class="mb-5" :password="password" />
				</div>
			</div>
			<footer class="modal-card-foot">
				<b-button class="is-rounded is-outlined is-danger" @click="$emit('close')">Close</b-button>
				<b-button native-type="submit" class="is-rounded is-primary" :loading="loading">Save</b-button>
			</footer>
		</form>
	</ValidationObserver>
</template>

<script>
import InputWithValidation from '@/components/inputs/InputWithValidation'
import SelectWithValidation from '@/components/inputs/SelectWithValidation'
import { ValidationObserver } from 'vee-validate'
import PasswordMeter from 'vue-simple-password-meter'

export default {
	components: {
		InputWithValidation,
		SelectWithValidation,
		ValidationObserver,
		PasswordMeter
	},
	data() {
		return {
			loading: false,
			name: '',
			email: '',
			password: '',
			role: 1,
			roles: [
				{
					id: 1,
					name: 'User'
				},
				{
					id: 2,
					name: 'Moderator'
				},
				{
					id: 3,
					name: 'Administrator'
				}
			]
		}
	},
	methods: {
		saveUser() {
			this.loading = true
			setTimeout(() => {
				this.loading = false
				console.log('Form submitted yay!')
			}, 1000)
		}
	}
}
</script>
