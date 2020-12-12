<template>
	<Layout>
		<template>
			<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
				<form @submit.prevent="handleSubmit(updateProfile)">
					<article class="profile__column panel">
						<div class="panel__header">
							<span class="is-flex is-flex-direction-column is-justify-content-center">
								<h3 class="profile__name pt-0 is-semibold is-size-6">Address Information</h3>
								<p class="is-size-7">Update your address information</p>
							</span>
							<b-button tabindex="6" native-type="submit" type="is-primary save" :loading="loading" rounded>Save</b-button>
						</div>
						<div class="panel__body">
							<h3 class="profile__section has-text-primary is-semibold is-size-5">Address</h3>
							<InputWithValidation class="profile__field" tab="3" rules="required" label="Zipcode" size="is-medium" v-mask="'#####-###'" v-model="user.address.zipcode" :blur="findAddress" />

							<InputWithValidation class="profile__field" tab="4" rules="required|min:2" type="text" label="Address" size="is-medium" v-model="user.address.street" />

							<InputWithValidation class="profile__field" tab="5" rules="required|min:1" type="text" label="Number" size="is-medium" ref="number" v-model="user.address.number" />

							<InputWithValidation class="profile__field" tab="6" rules="required|min:4" type="text" label="Neighborhood" size="is-medium" v-model="user.address.neighborhood" />

							<InputWithValidation class="profile__field" tab="7" rules="required|min:2" type="text" label="State" size="is-medium" v-model="user.address.state" />

							<InputWithValidation class="profile__field" tab="8" rules="required|min:4" type="text" label="City" size="is-medium" v-model="user.address.city" />
						</div>
					</article>
				</form>
			</ValidationObserver>
		</template>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Profile'
import InputWithValidation from '@/components/inputs/InputWithValidation'
import { ValidationObserver } from 'vee-validate'
import { ToastProgrammatic as Toast } from 'buefy'
import Api from '@/services/api'
import eventHub from '@/services/eventHub'

export default {
	name: 'Address',
	components: {
		Layout,
		InputWithValidation,
		ValidationObserver
	},
	data() {
		return {
			loading: false,
			user: {
				address: {
					zipcode: '',
					street: '',
					number: '',
					neighborhood: '',
					state: '',
					city: ''
				}
			}
		}
	},
	methods: {
		async findAddress(e) {
			try {
				const zipcode = /^\d{5}$|^\d{5}-\d{3}$/
				if (!zipcode.test(e.target.value)) {
					Toast.open({
						message: 'Digite corretamente o cep',
						type: 'is-danger',
						position: 'is-bottom'
					})
				} else {
					const cep = e.target.value.replace(/\D/g, '')
					fetch(`https://viacep.com.br/ws/${cep}/json`)
						.then(response => response.json())
						.then(body => {
							if (body.erro) {
								Toast.open({
									message: 'Cep não encontrado ou inválido!',
									type: 'is-danger',
									position: 'is-bottom'
								})
							} else {
								let address = this.user.address

								address.street = body.logradouro
								address.neighborhood = body.bairro
								address.state = body.uf
								address.city = body.localidade
								// Force focus um number
								this.$refs.number.$el.querySelector('input').focus()
							}
						})
						.catch(error => {
							console.log(error)
						})
				}
			} catch (e) {
				console.log(e)
			}
		},
		async updateProfile() {
			try {
				this.loading = true
				const response = await Api.put(`user/address`, this.user)
				const { status } = response
				if (status === 200) {
					const { message } = response.data
					Toast.open({
						message,
						type: 'is-success',
						position: 'is-bottom'
					})
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
		}
	},
	mounted() {
		eventHub.$on('me', obj => {
			if (typeof obj.address === 'undefined') {
				this.user = {
					address: {
						zipcode: '',
						address: '',
						number: '',
						neighborhood: '',
						state: '',
						city: ''
					}
				}
			} else {
				this.user.address = obj.address
			}
		})
	}
}
</script>
