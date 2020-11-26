<template>
	<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
		<form @submit.prevent="handleSubmit(saveRole)">
			<header class="modal-card-head">
				<h4 class="modal-card-title">
					{{ name }}
					<strong>Role</strong>
				</h4>
			</header>
			<div class="modal-card-body">
				<b-loading :is-full-page="false" v-model="isOpening"></b-loading>
				<div class="modal-card">
					<div class="columns mb-2">
						<div class="column is-12-mobile is-4-tablet">
							<InputWithValidation rules="required|min:3" type="text" label="Name" size="is-medium" v-model="permission.name" />
						</div>
						<div class="column is-8-mobile is-7-tablet">
							<InputWithValidation rules="required|min:3" type="text" label="Description" size="is-medium" v-model="permission.description" />
						</div>
						<div class="column is-4-mobile is-1-tablet">
							<b-field label="Color" class="mb-2">
								<v-swatches v-model="permission.color" :swatches="swatches" row-length="5" shapes="circles" popover-x="left"></v-swatches>
							</b-field>
						</div>
					</div>
					<h3 class="is-size-5 is-semibold has-text-primary">Permissions</h3>
					<hr class="my-3" />
					<div class="columns">
						<div class="column is-mobile-4"></div>
						<div v-for="(role, i) in crud" :key="i" class="column is-12-mobile is-2-tablet text-center">
							<span class="is-size-7 text-uppercase is-semibold action" @click="selectAll(role.label)">{{ role.name }}</span>
						</div>
					</div>
					<span class="item" v-for="(r, i) in permission.route" :key="i">
						<div class="columns mb-0">
							<div class="column is-12-mobile is-4-tablet">
								<h4 class="is-size-6 is-semibold has-text-primary">{{ r.name }}</h4>
							</div>
							<div class="column is-12-mobile is-2-tablet text-center" v-for="(value, key, i) in r.role" :key="i">
								<b-checkbox type="is-primary" v-model="r.role[key]" :name="r.name.toLowerCase() + '_' + key" class="ml-4" :value="value"></b-checkbox>
								<input type="hidden" :value="r.slug" />
							</div>
						</div>
						<hr class="mt-0 mb-4" />
					</span>
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
import VSwatches from 'vue-swatches'
import { ValidationObserver } from 'vee-validate'
import '@/mixins/date'
import Api from '@/services/api'
import eventHub from '@/services/eventHub'
import { ToastProgrammatic as Toast } from 'buefy'

export default {
	components: {
		InputWithValidation,
		ValidationObserver,
		VSwatches
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
			swatches: ['#feca57', '#ff9f43', '#ee5253', '#f368e0', '#b53471', '#7202f8', '#10ac84', '#01a3a4', '#0abde3', '#2e86de', '#341f97', '#dbdbdb', '#8395a7', '#576574', '#222f3e'],
			crud: [
				{
					label: 'read',
					name: 'Read'
				},
				{
					label: 'create',
					name: 'Create'
				},
				{
					label: 'edit',
					name: 'Edit'
				},
				{
					label: 'delete',
					name: 'Delete'
				}
			],
			permission: {
				name: '',
				description: '',
				color: '#dbdbdb',
				active: true,
				route: [
					{
						name: 'Dashboard',
						role: {
							read: false,
							create: false,
							edit: false,
							delete: false
						},
						slug: 'dashboard'
					},
					{
						name: 'Users',
						role: {
							read: false,
							create: false,
							edit: false,
							delete: false
						},
						slug: 'users'
					},
					{
						name: 'Roles',
						role: {
							read: false,
							create: false,
							edit: false,
							delete: false
						},
						slug: 'roles'
					}
				]
			}
		}
	},
	methods: {
		async selectAll(role) {
			let c = role.toLowerCase(),
				r = this.permission.route

			for (let i in r) {
				r[i].role[c] = !r[i].role[c]
			}
		},
		async saveRole() {
			this.name === 'New' ? await this.store() : await this.update()
		},
		async store() {
			try {
				this.loading = true
				const response = await Api.post('permission/store', this.permission)
				const { status } = response
				if (status === 201) {
					const { message } = response.data
					this.$emit('close')
					Toast.open({
						message,
						type: 'is-success',
						position: 'is-bottom'
					})
					eventHub.$emit('reload-roles')
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
		async update() {
			try {
				this.loading = true
				const response = await Api.put(`permission/update/${this.id}`, this.permission)
				const { status } = response
				if (status === 200) {
					const { message } = response.data
					this.$emit('close')
					Toast.open({
						message,
						type: 'is-success',
						position: 'is-bottom'
					})
					eventHub.$emit('reload-roles')
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
					const response = await Api.get(`permission/findById/${this.id}`)
					const { status } = response
					if (status === 200) {
						const { data } = response
						this.permission = data
						this.isOpening = false
					}
				} catch (e) {
					console.log(e)
				}
			}
		}
	},
	mounted() {
		this.findById()
	}
}
</script>
