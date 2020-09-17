<template>
	<form action="#">
		<div class="modal-card">
			<header class="modal-card-head">
				<h4 class="modal-card-title">
					<span>Novo</span>
					<strong>Usuário</strong>
				</h4>
			</header>
			<footer class="modal-card-foot">
				<button class="button" type="button" @click="$emit('close')">Close</button>
				<button class="button is-primary">Create</button>
			</footer>
		</div>
	</form>
</template>

<script>
import InputWithValidation from '@/components/inputs/InputWithValidation'
import SelectWithValidation from '@/components/inputs/SelectWithValidation'
import { ValidationObserver } from 'vee-validate'

export default {
	components: {
		InputWithValidation,
		SelectWithValidation,
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
