<template>
	<Layout>
		<Header>
			<b-skeleton v-if="!errored && !this.roles.read" height="30" position="is-centered" animated></b-skeleton>
			<b-button v-else type="is-secondary export" :loading="exporting" size="is-small" rounded outlined @click="exportUsers($event)">
				<span>Export</span>
				<svg-icon class="icon is-small" icon="export"></svg-icon>
			</b-button>
			<b-skeleton v-if="!this.roles.create" height="40" position="is-right" animated></b-skeleton>
			<b-button v-else type="is-primary create" rounded @click="createUser($event)">
				<svg-icon icon="add-user" class="icon is-small"></svg-icon>
				<span>Create</span>
			</b-button>
		</Header>
		<section v-if="!errored" class="columns filter">
			<div class="column filter__wrapper">
				<b-field label="Order" v-model="filter.order" :label-position="label">
					<b-select placeholder="Name" @input="filterByOrder">
						<option selected value="1">Name</option>
						<option value="2">E-mail</option>
						<option value="4">Status</option>
					</b-select>
				</b-field>
				<b-field label="Role" v-model="role" :label-position="label">
					<b-select placeholder="All Roles" @input="filterByRole">
						<option v-for="r in permission" :value="r._id" :key="r._id">{{ r.name }}</option>
					</b-select>
				</b-field>
				<b-field label="Status" v-model="filter.status" :label-position="label">
					<b-select placeholder="Active" @input="filterByStatus">
						<option selected value="1">Active</option>
						<option value="2">Inactive</option>
					</b-select>
				</b-field>
				<b-field>
					<b-input placeholder="Search..." type="search" icon="magnify" v-model="user.first_name" @input="findByName"></b-input>
				</b-field>
			</div>
			<div v-if="showPagination" class="column is-flex is-justify-content-flex-end">
				<b-pagination @change="changeUrl" :current.sync="current" :total="total" :page="page" :per-page="pagination" :simple="true" :rounded="true" order="is-right" icon-prev="chevron-left" icon-next="chevron-right"></b-pagination>
			</div>
		</section>
		<Error v-if="errored" :icon="true" :back="true" />
		<Results v-if="users.length == 0 && !loading" />
		<div v-if="loading" class="columns is-multiline">
			<div v-for="n in pagination" :key="n" class="column is-12-mobile is-6-tablet is-4-desktop">
				<Placeholder />
			</div>
		</div>
		<transition-group name="filtering" class="filtering columns is-multiline" tag="div">
			<div v-for="u in users" :key="u._id" class="column is-12-mobile is-6-tablet is-4-desktop">
				<article :class="[!u.active ? 'block inactive' : 'block']">
					<div class="block__avatar image is-48x48">
						<b-tooltip v-if="u.permission" :label="u.permission.name" type="is-primary" position="is-right">
							<span class="block__role" :style="{ background: u.permission.color }"></span>
						</b-tooltip>
						<b-image ratio="1by1" :src="u.avatar" :alt="u.full_name" :rounded="true"></b-image>
					</div>
					<div class="block__content">
						<h3 class="block__name">{{ u.full_name }}</h3>
						<p class="block__email">{{ u.email }}</p>
					</div>
					<Trigger :id="u._id" :visible="roles" :role="u.role.name" :name="u.full_name" :active="u.active" />
				</article>
			</div>
		</transition-group>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Header from '@/components/Header'
import Icon from '@/components/Icon'
import Placeholder from '@/components/placeholders/User'
import Trigger from '@/components/triggers/Users'
import Error from '@/components/Error'
import Results from '@/components/Results'
import Modal from '@/components/modals/User'
import Api from '@/services/api'
import eventHub from '@/services/eventHub'
import Middleware from '@/middleware/roles'
import { toast } from '@/helpers/toast'
import { create, update } from '@/helpers/modal'

export default {
	components: {
		Layout,
		Header,
		Placeholder,
		Trigger,
		Error,
		Results,
		'svg-icon': Icon
	},
	data() {
		return {
			// Pagination
			current: 1,
			page: 1,
			total: 0,
			pagination: 15,
			data: [],
			loading: true,
			errored: false,
			// Filter
			filter: {
				order: '',
				status: '',
				role: ''
			},
			order: '',
			role: '',
			status: 1,
			label: 'on-border',
			// Export
			exporting: false,
			actions: [
				{
					name: 'Edit',
					icon: 'edit'
				},
				{
					name: 'Delete',
					icon: 'trash',
					color: 'has-text-danger'
				}
			],
			permission: [],
			user: {
				first_name: ''
			},
			roles: {},
			showPagination: false,
			destroy: false
		}
	},
	async created() {
		const url = window.location.href.split('/')
		const type = url.find(el => el === 'page')
		if (type === 'page') {
			this.page = url[5]
			this.current = url[5]
		}
		this.roles = await Middleware()
		if (!this.roles.read) {
			await this.$router.push('/404')
		}
	},
	mounted() {
		this.getAllRoles()
		this.getAllUsers()
		this.getUrlParams()
		eventHub.$off()
		eventHub.$on('edit-modal-users', obj => {
			update('users', obj.id, Modal, 'Edit', obj.root)
		})
		eventHub.$on('disable-users', async obj => {
			try {
				const response = await Api.put(`user/disable/${obj.id}`)
				const { status } = response
				if (status === 200) {
					const { message } = response.data
					toast('is-success', message)
					await this.getAllUsers()
				}
			} catch (e) {
				console.log(e)
			}
		})
		eventHub.$on('delete-users', obj => {
			this.$buefy.dialog.alert({
				size: 'is-delete',
				type: 'is-outlined is-primary',
				title: 'Attention',
				message: '<span>Do you really want <br>to <strong>delete</strong> this user?</span> <small>This process cannot be undone.</small>',
				canCancel: true,
				focusOn: 'cancel',
				cancelText: 'No',
				confirmText: 'Yes',
				onConfirm: async () => {
					try {
						const response = await Api.delete(`user/destroy/${obj.id}`)
						const { status } = response
						if (status === 200) {
							const { message } = response.data
							toast('is-success', message)
							await this.getAllUsers()
						}
					} catch (e) {
						console.log(e)
					}
				}
			})
		})
		eventHub.$on('restore-users', async obj => {
			try {
				const response = await Api.put(`user/restore/${obj.id}`)
				const { status } = response
				if (status === 200) {
					const { message } = response.data
					toast('is-success', message)
					await this.getAllUsers()
				}
			} catch (e) {
				console.log(e)
			}
		})
		eventHub.$on('reload-users', () => {
			this.getAllUsers()
		})
	},
	computed: {
		users() {
			const url = window.location.href.split('/')
			const type = url.find(el => el === 'page')
			if (type === 'page') {
				let current = this.current - 1
				return this.data.slice(current * this.pagination, (current + 1) * this.pagination)
			} else {
				let current = this.current - 1
				return this.data.slice(current * this.pagination, (current + 1) * this.pagination)
			}
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
		async getAllUsers() {
			try {
				const response = await Api.get('user/findAll')
				const { status } = response
				if (status === 200) {
					const { data } = response
					this.data = data
					this.total = data.length
					if (this.total > 15) {
						this.showPagination = true
					} else {
						this.showPagination = false
					}
				}
			} catch (e) {
				console.log(e)
			} finally {
				this.loading = false
			}
		},
		async findByName() {
			try {
				const empty = /^\s*$/
				if (!empty.test(this.user.first_name)) {
					const response = await Api.post('user/findByName', {
						name: this.user.first_name
					})
					const { status } = response
					if (status === 200) {
						const { data } = response
						this.data = data
						this.total = data.length
						console.log(data)
					}
				} else {
					await this.getAllUsers()
				}
			} catch (e) {
				console.log(e)
			} finally {
				this.loading = false
			}
		},
		async filterByOrder(e) {
			try {
				this.filter.order = e
				const response = await Api.post('user/filterByOrder', {
					name: this.filter.order
				})
				const { status } = response
				if (status === 200) {
					const { data } = response
					this.data = data
					this.total = data.length
				}
			} catch (e) {
				console.log(e)
			} finally {
				this.loading = false
			}
		},
		async filterByStatus(e) {
			try {
				this.filter.status = e
				const response = await Api.post('user/filterByStatus', {
					name: this.filter.status
				})
				const { status } = response
				if (status === 200) {
					const { data } = response
					this.data = data
					this.total = data.length
				}
			} catch (e) {
				console.log(e)
			} finally {
				this.loading = false
			}
		},
		async filterByRole(e) {
			try {
				this.filter.role = e
				const response = await Api.post('user/filterByRole', {
					name: this.filter.role
				})
				const { status } = response
				if (status === 200) {
					const { data } = response
					this.data = data
					this.total = data.length
				}
			} catch (e) {
				console.log(e)
			} finally {
				this.loading = false
			}
		},
		async exportUsers() {
			this.exporting = true
			try {
				const response = await Api.post('user/export')
				const { status } = response
				if (status === 422) {
					toast('is-warning', 'The file was not generated successfully')
				} else {
					const { message } = response.data
					toast('is-success', 'The file was generated successfully')
					setTimeout(() => {
						this.exporting = false
						const node = document.createElement('a')
						node.href = message
						node.click()
					}, 2000)
				}
			} catch (e) {
				console.log(e)
			} finally {
				this.exporting = false
			}
		},
		getUrlParams() {
			const url = location.href.split('/')
			const params = url[4]
			const type = url.find(el => el === params)
			switch (type) {
				case 'create':
					this.createUser()
					break
				case 'edit':
					this.updateUser(url[5])
			}
		},
		createUser() {
			create('users', Modal, 'New')
		},
		updateUser(id) {
			update('users', id, Modal, 'Edit')
		},
		changeUrl(page) {
			this.current = page
			if (page === 1) {
				history.pushState({}, '', '/users')
			} else {
				history.pushState({}, '', '/users')
				history.pushState({}, '', `users/page/${this.current}`)
			}
		}
	}
}
</script>
