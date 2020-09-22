<template>
	<form action="#">
		<div class="modal-card">
			<header class="modal-card-head">
				<h4 class="modal-card-title">
					<span>Novo</span>
					<strong>Usuário</strong>
				</h4>
			</header>
			<div class="dsds">
				<InputWithValidation rules="required|min:5" class="mb-5" type="text" label="Name" size="is-medium" v-model="name" />

				<InputWithValidation class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="email" />

				<SelectWithValidation>
					<option value="1">sdsdsd</option>
				</SelectWithValidation>

				<InputWithValidation rules="required|min:6" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="password" />

				<password-meter class="mb-5" :password="password" @score="Score" />
			</div>
			<footer class="modal-card-foot">
				<button class="button" type="button" @click="$emit('close')">Close</button>
				<b-button native-type="submit" class="button is-button is-primary" @click="handleSubmit(Create($event))">Create</b-button>
			</footer>
		</div>
	</form>
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
			score: null
		}
	},
	methods: {
		Create(e) {
			e.preventDefault()
			console.log('Form submitted yay!')
		}
	}
}
</script>
