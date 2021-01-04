<template>
	<Layout>
		<Header>
			<b-skeleton v-if="!errored && !this.roles.read" height="30" position="is-centered" animated></b-skeleton>
			<b-button v-else type="is-secondary export" :loading="exporting" size="is-small" rounded outlined @click="exportRoles($event)">
				<span>Export</span>
				<svg-icon class="icon is-small" icon="export"></svg-icon>
			</b-button>
			<b-skeleton v-if="!this.roles.create" height="40" position="is-right" animated></b-skeleton>
			<b-button v-else type="is-primary create" rounded @click="createRole($event)">
				<svg-icon icon="add-user" class="icon is-small"></svg-icon>
				<span>Create</span>
			</b-button>
		</Header>
		<section v-if="!errored" class="columns filter">
			<div class="column filter__wrapper" v-if="!errored">
				<b-field label="Order by" v-model="order" :label-position="label">
					<b-select placeholder="Name" @input="filterBy">
						<option selected value="1">Name</option>
						<option value="2">Date</option>
					</b-select>
				</b-field>
				<b-field>
					<b-input placeholder="Search..." type="search" icon="magnify" @input="findByName" v-model="role.name"></b-input>
				</b-field>
			</div>
		</section>
		<Error v-if="errored" :back="true" />
		<Results v-if="permission.length == 0 && !loading" />
		<div v-if="loading" class="columns is-multiline">
			<div v-for="r in placeholder" :key="r" class="column is-12-mobile is-6-tablet is-4-desktop">
				<Placeholder />
			</div>
		</div>
		<transition-group name="filtering" class="filtering columns is-multiline" tag="div">
			<div v-for="r in permission" :key="r._id" class="list-item column is-12-mobile is-6-tablet is-4-desktop">
				<article class="block" :style="{ 'border-left-color': r.color }">
					<div class="block__content">
						<h3 class="block__name">{{ r.name }}</h3>
						<p class="block__email">{{ format(r.created_at) }} • {{ timeTo(r.created_at) }}</p>
					</div>
					<Trigger :id="r._id" :permission="r.slug" :visible="roles" />
				</article>
			</div>
		</transition-group>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Header from '@/components/Header'
import Icon from '@/components/Icon'
import Placeholder from '@/components/placeholders/Role'
import Trigger from '@/components/triggers/Roles'
import Error from '@/components/Error'
import Results from '@/components/Results'
import Modal from '@/components/modals/Role'
import Api from '@/services/api'
import Middleware from '@/middleware/roles'
import eventHub from '@/services/eventHub'
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
			placeholder: 5,
			loading: true,
			errored: false,
			// Filter
			order: 1,
			label: 'on-border',
			// Export
			exporting: false,
			permission: [],
			user: {},
			role: {
				name: ''
			},
			roles: {}
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
			} finally {
				this.loading = false
			}
		},
		filterBy(e) {
			const type = parseInt(e)
			type === 1 ? this.getAllRoles() : this.findByDate()
		},
		async findByDate() {
			try {
				const response = await Api.get('permission/findAllOrderByDate')
				const { status } = response
				if (status === 200) {
					const { data } = response
					this.permission = data
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
				if (!empty.test(this.role.name)) {
					const response = await Api.post('permission/findByName', {
						name: this.role.name
					})
					const { status } = response
					if (status === 200) {
						const { data } = response
						this.permission = data
					}
				} else {
					await this.getAllRoles()
				}
			} catch (e) {
				console.log(e)
			} finally {
				this.loading = false
			}
		},
		async exportRoles() {
			this.exporting = true
			try {
				const response = await Api.post('permission/export')
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
					this.createRole()
					break
				case 'edit':
					this.updateRole(url[5])
			}
		},
		createRole() {
			create('roles', Modal, 'New')
		},
		updateRole(id) {
			update('roles', id, Modal, 'Edit')
		},
		deleteRole() {
			this.$buefy.dialog.alert({
				size: 'is-delete',
				type: 'is-outlined is-primary',
				title: 'Attention',
				message: '<span>Do you really want <br>to <strong>delete</strong> this role?</span> <small>All users with this role will lose access.</small>',
				canCancel: true,
				focusOn: 'cancel',
				cancelText: 'No',
				confirmText: 'Yes',
				onConfirm: () => {
					toast('is-success', 'This role was removed successfully')
				}
			})
		}
	},
	mounted() {
		this.getAllRoles()
		this.getUrlParams()
		eventHub.$on('edit-modal-role', obj => {
			update('roles', obj.id, Modal, 'Edit')
		})
		eventHub.$on('reload-roles', () => {
			this.getAllRoles()
		})
		eventHub.$on('delete-role', obj => {
			this.$buefy.dialog.alert({
				size: 'is-delete',
				type: 'is-outlined is-primary',
				title: 'Attention',
				message: '<span>Do you really want <br>to <strong>delete</strong> this role?</span> <small>All users with this role will lose access.</small>',
				canCancel: true,
				focusOn: 'cancel',
				cancelText: 'No',
				confirmText: 'Yes',
				onConfirm: async () => {
					try {
						const response = await Api.delete(`permission/destroy/${obj.id}`)
						const { status } = response
						if (status === 200) {
							const { message } = response.data
							toast('is-success', message)
							await this.getAllRoles()
						}
					} catch (e) {
						console.log(e)
					}
				}
			})
		})
	},
	async created() {
		this.roles = await Middleware()
		if (!this.roles.read) {
			await this.$router.push('/404')
		}
	}
}
</script>
