<template>
	<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
		<form @submit.prevent="handleSubmit(saveRole)">
			<header class="modal-card-head">
				<h4 class="modal-card-title">
					New
					<strong>Role</strong>
				</h4>
			</header>
			<div class="modal-card-body">
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
								<v-swatches v-model="permission.color" :swatches="swatches" :row-length="swatches.length / 2" shapes="circles" popover-x="left"></v-swatches>
							</b-field>
						</div>
					</div>
					<h3 class="is-size-5 is-semibold has-text-primary">Permissions</h3>
					<hr class="my-3" />
					<div class="columns">
						<div class="column is-mobile-4"></div>
						<div v-for="(type, i) in crud" :key="i" class="column is-12-mobile is-2-tablet text-center">
							<span class="is-size-7 text-uppercase is-semibold">{{ type }}</span>
						</div>
					</div>
					<span v-for="(role, i) in roles" :key="i">
						<div class="columns mb-0">
							<div class="column is-12-mobile is-4-tablet">
								<h4 class="is-size-6 is-semibold has-text-primary">{{ role }}</h4>
							</div>
							<div class="column is-12-mobile is-2-tablet text-center" v-for="(type, i) in crud" :key="i">
								<b-checkbox type="is-primary" :name="role.toLowerCase() + '_' + type.toLowerCase()" class="ml-4"></b-checkbox>
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

export default {
	components: {
		InputWithValidation,
		ValidationObserver,
		VSwatches
	},
	data() {
		return {
			loading: false,
			name: '',
			description: '',
			color: '#dbdbdb',
			swatches: ['#f368e0', '#b53471', '#7202f8', '#feca57', '#ff9f43', '#ee5253', '#0abde3', '#10ac84', '#01a3a4', '#2e86de', '#341f97', '#8395a7'],
			crud: ['Read', 'Create', 'Edit', 'Delete'],
			roles: ['Dashboard', 'Users', 'Roles', 'Chat'],
			permission: {
				name: '',
				description: '',
				color: '',
				route: [
					{
						name: '',
						role: {
							read: false,
							create: false,
							edit: false,
							delete: false
						}
					},
				],
				active: true
			}
		}
	},
	methods: {
		saveRole() {
			this.loading = true
			setTimeout(() => {
				this.loading = false
				console.log(this.permission)
			}, 1000)
		}
	},
	mounted() {
		
	}
}
</script>
