<template>
	<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
		<header class="modal-card-head">
			<h4 class="modal-card-title">
				New
				<strong>User</strong>
			</h4>
		</header>
		<div class="modal-card-body">
			<form class="modal-card" action="#">
				<InputWithValidation rules="required|min:3" class="mb-5" type="text" label="Name" size="is-medium" v-model="name" />

				<InputWithValidation class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="email" />

				<SelectWithValidation class="mb-5" rules="required" label="Role" v-model="role">
					<option v-for="r in roles" :value="r.id" :key="r.id">{{ r.name }}</option>
				</SelectWithValidation>

				<InputWithValidation rules="required|min:8" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="password" />
				<password-meter class="mb-5" :password="password" />
			</form>
		</div>
		<footer class="modal-card-foot">
			<b-button class="is-rounded is-outlined is-danger" @click="$emit('close')">Close</b-button>
			<b-button native-type="submit" class="is-rounded is-primary" @click="handleSubmit(save($event))">Save</b-button>
		</footer>
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
		save() {
			console.log('Form submitted yay!')
		}
	}
}
</script>
