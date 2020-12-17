<template>
	<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
		<form @submit.prevent="handleSubmit(saveUser)">
			<header class="modal-card-head">
				<h4 class="modal-card-title">
					{{ name }}
					<strong>User</strong>
				</h4>
			</header>
			<div class="modal-card-body">
				<b-loading :is-full-page="false" v-model="isOpening"></b-loading>
				<div class="modal-card mb-3">
					<div class="columns mb-4">
						<div class="column">
							<InputWithValidation rules="required|min:3" type="text" label="First Name" size="is-medium" v-model="user.first_name" />
						</div>
						<div class="column">
							<InputWithValidation rules="required|min:3" type="text" label="Last Name" size="is-medium" v-model="user.last_name" />
						</div>
					</div>

					<InputWithValidation class="mb-4" rules="required|email" type="email" label="Email" size="is-medium" v-model="user.email" />

					<SelectWithValidation class="mb-4" rules="required" label="Role" size="is-medium" v-model="user.permission_id">
						<option v-for="r in permission" :value="r._id" :key="r._id">{{ r.name }}</option>
					</SelectWithValidation>

					<InputWithValidation rules="required|min:8" type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="user.password" v-if="name === 'New'" />
					<InputWithValidation type="password" label="Password" vid="password" size="is-medium" password-reveal v-model="user.password" v-if="name === 'Edit'" />
					<password-meter class="mb-5" :password="user.password" />
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
import Api from '@/services/api'
import eventHub from '@/services/eventHub'
import { ToastProgrammatic as Toast } from 'buefy'

export default {
	components: {
		InputWithValidation,
		SelectWithValidation,
		ValidationObserver,
		PasswordMeter
	},
	props: {
		id: {
			type: String,
			required: false
		},
		name: {
			type: String,
			required: true
		}
	},
	data() {
		return {
			isOpening: false,
			loading: false,
			user: {},
			role: 1,
			permission: []
		}
	},
	methods: {
		async getAllRoles() {
			try {
				const response = await Api.get('permission/findAll')
				const { status } = response
				if (status === 200) {
					const { data } = response
					this.permission = data
				}
			} catch (e) {
				console.log(e)
			}
		},
		async update() {
			try {
				this.loading = true
				const response = await Api.put(`user/update/${this.id}`, this.user)
				const { status } = response
				if (status === 200) {
					const { message } = response.data
					this.$emit('close')
					history.pushState({}, '', '/users')
					Toast.open({
						message,
						type: 'is-success',
						position: 'is-bottom'
					})
					eventHub.$emit('reload-users')
				}
			} catch (e) {
				const { status } = e
				if (status === 422) {
					const { message } = e.data
					Toast.open({
						message,
						type: 'is-danger',
						position: 'is-bottom'
					})
				}
			} finally {
				this.loading = false
			}
		},
		async findById() {
			if (this.name === 'Edit') {
				this.isOpening = true
				try {
					const response = await Api.get(`user/findById/${this.id}`)
					const { status } = response
					if (status === 200) {
						const { data } = response
						this.user = data
						this.isOpening = false
					}
				} catch (e) {
					console.log(e)
				}
			}
		},
		async store() {
			try {
				this.loading = true
				const response = await Api.post('user/store', this.user)
				const { status } = response
				if (status === 201) {
					const { message } = response.data
					this.$emit('close')
					history.pushState({}, '', '/users')
					Toast.open({
						message,
						type: 'is-success',
						position: 'is-bottom'
					})
					eventHub.$emit('reload-users')
				}
			} catch (e) {
				const { status } = e
				if (status === 422) {
					const { message } = e.data
					Toast.open({
						message,
						type: 'is-danger',
						position: 'is-bottom'
					})
				}
			} finally {
				this.loading = false
			}

			this.loading = true
			setTimeout(() => {
				this.loading = false
			}, 1000)
		},
		async saveUser() {
			this.name === 'New' ? await this.store() : await this.update()
		}
	},
	mounted() {
		this.findById()
		this.getAllRoles()
	}
}
</script>
