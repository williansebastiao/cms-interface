<template>
	<Layout>
		<div class="columns">
			<Title />
			<Weather :bordered="false" />
		</div>
		<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
			<section class="profile columns">
				<div class="column profile__sidebar">
					<article class="profile__column ">
						<div class="columns mb-0">
							<div class="column is-one-third profile__image">
								<img :src="user.avatar" :alt="user.full_name" />
							</div>
							<div class="column">
								<h3 class="profile__name is-semibold is-size-5">{{ user.full_name }}</h3>
								<p class="profile__role" v-if="user.permission">{{ user.permission.name }}</p>
							</div>
						</div>
						<ul class="profile__list">
							<li v-if="user.phone">
								<span class="profile__list__key">Phone:</span>
								<a href="#" class="profile__list__value">{{ user.phone }}</a>
							</li>
							<li v-if="user.email">
								<span class="profile__list__key">Email:</span>
								<a href="#" class="profile__list__value">{{ user.email }}</a>
							</li>
							<li v-if="user.address.zipcode">
								<span class="profile__list__key">Location:</span>
								<span class="profile__list__value">{{ user.address.city }}/{{ user.address.state }}</span>
							</li>
						</ul>
						<ul class="profile__navigation">
							<li v-for="(m, i) in navigation" :key="i">
								<router-link tag="a" :to="m.path">
									<svg-icon :icon="m.icon"></svg-icon>
									<span>{{ m.name }}</span>
								</router-link>
							</li>
						</ul>
					</article>
				</div>
				<form class="column" @submit.prevent="handleSubmit(updateProfile)">
					<article class="profile__column panel">
						<div class="panel__header">
							<span class="is-flex is-flex-direction-column is-justify-content-center">
								<h3 class="profile__name pt-0 is-semibold is-size-6">Personal Information</h3>
								<p class="is-size-7">Update your informations</p>
							</span>
							<b-button tabindex="6" native-type="submit" type="is-primary save" :loading="loading" rounded>Save</b-button>
						</div>
						<div class="panel__body">
							<h3 class="profile__section has-text-primary is-semibold is-size-5">User Data</h3>

							<InputWithValidation class="profile__field" tab="1" rules="required" type="text" label="Site" size="is-medium" v-model="user.site" />

							<InputWithValidation class="profile__field" tab="2" rules="required|min:15" type="text" label="Phone" size="is-medium" v-mask="'(##) #####-####'" v-model="user.phone" />

							<InputWithValidation class="profile__field" tab="3" type="text" label="Zipcode" size="is-medium" v-mask="'#####-###'" v-model="user.address.zipcode" :blur="findAddress" />

							<InputWithValidation class="profile__field" tab="4" rules="required|min:2" type="text" label="Address" size="is-medium" v-model="user.address.street" />

							<InputWithValidation class="profile__field" tab="5" rules="required|min:1" type="text" label="Number" size="is-medium" ref="number" v-model="user.address.number" />

							<InputWithValidation class="profile__field" tab="6" rules="required|min:4" type="text" label="Neighborhood" size="is-medium" v-model="user.address.neighborhood" />

							<InputWithValidation class="profile__field" tab="7" rules="required|min:2" type="text" label="State" size="is-medium" v-model="user.address.state" />

							<InputWithValidation class="profile__field" tab="8" rules="required|min:4" type="text" label="City" size="is-medium" v-model="user.address.city" />

						</div>
					</article>
				</form>
			</section>
		</ValidationObserver>
	</Layout>
</template>

<script>
import Menu from '@/router/user'
import Layout from '@/layouts/Default'
import Title from '@/components/Title'
import Icon from '@/components/Icon'
import Weather from '@/components/Weather'
import InputWithValidation from '@/components/inputs/InputWithValidation'
import { ValidationObserver } from 'vee-validate'
import Api from '@/services/api'
import { ToastProgrammatic as Toast } from 'buefy'

export default {
	name: 'Personal',
	components: {
		Layout,
		Title,
		Weather,
		InputWithValidation,
		ValidationObserver,
		'svg-icon': Icon
	},
	data() {
		return {
			loading: false,
			bordered: true,
			onAccept(e) {
				const maskRef = e.detail
				this.value = maskRef.value
				console.log('accept', maskRef.value)
			},
			user: {}
		}
	},
	computed: {
		navigation() {
			return Menu[0].children
		}
	},
	methods: {
		async me() {
			try {
				const response = await Api.get('user/me')
				const { status } = response
				if (status === 200) {
					const {data} = response
					this.user = data
					if(!data.site) {
						this.user = ({...this.user, site: ''})
					}
					if(!data.address) {
						this.user = ({...this.user, address: {zipcode: '', address: '', number: '', neighborhood: '', state: '', city: ''}})
					}
					console.log(this.user)
				}
			} catch (e) {
				console.log(e)
			}
		},
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
								this.user.address.street = body.logradouro
								this.user.address.neighborhood = body.bairro
								this.user.address.state = body.uf
								this.user.address.city = body.localidade
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
				const response = await Api.put(`user/personal/${this.user._id}`, this.user)
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
		this.me()
	}
}
</script>
