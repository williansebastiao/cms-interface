<template>
	<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
		<header class="modal-card-head">
			<h4 class="modal-card-title">
				Novo
				<strong>Usuário</strong>
			</h4>
		</header>
		<div class="modal-card-body">
			<form class="modal-card" action="#">
				<InputWithValidation rules="required|min:5" class="mb-5" type="text" label="Name" size="is-medium" v-model="name" />

				<InputWithValidation class="mb-5" rules="required|email" type="email" label="Email" size="is-medium" v-model="email" />

				<b-select v-model="role" placeholder="Select a subject">
					<option v-for="r in roles" :value="r.id" :key="r.id">{{ r.name }}</option>
				</b-select>

				<SelectWithValidation class="mb-5" rules="required" label="Perfil" size="is-medium" v-model="role">
					<option selected disabled value="aa">sasasas</option>
					<option v-for="r in roles" :value="r.id" :key="r.id">{{ r.name }}</option>
				</SelectWithValidation>

				<InputWithValidation rules="required|min:6" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="password" />
				<password-meter class="mb-5" :password="password" />
			</form>
		</div>
		<footer class="modal-card-foot">
			<b-button class="is-rounded is-outlined is-danger" @click="$emit('close')">Fechar</b-button>
			<b-button native-type="submit" class="is-rounded is-primary" @click="handleSubmit(Create($event))">Salvar</b-button>
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
			role: 'sss',
			roles: [
				{
					id: 1,
					name: 'Usuário'
				},
				{
					id: 2,
					name: 'Moderador'
				},
				{
					id: 3,
					name: 'Administrador'
				}
			]
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
