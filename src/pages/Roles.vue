<template>
	<Layout>
		<section class="columns is-mobile">
			<Title />
			<div class="column page__actions">
				<b-button v-if="!errored" type="is-secondary export" :loading="exporting" size="is-small" rounded outlined @click="exportRoles($event)">
					<span>Export</span>
					<svg-icon class="icon is-small" icon="export"></svg-icon>
				</b-button>
				<b-button type="is-primary create" rounded @click="createRole($event)">
					<svg-icon icon="add-user" class="icon is-small"></svg-icon>
					<span>Create</span>
				</b-button>
			</div>
			<Weather />
		</section>
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
		<Results v-if="permission == 0 && !loading" />
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
					<Trigger :id="r._id" />
				</article>
			</div>
		</transition-group>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Title from '@/components/Title'
import Icon from '@/components/Icon'
import Placeholder from '@/components/placeholders/Role'
import Trigger from '@/components/triggers/Roles'
import Error from '@/components/Error'
import Results from '@/components/Results'
import Modal from '@/components/modals/Role'
import Weather from '@/components/Weather'
import Api from '@/services/api'
import eventHub from '@/services/eventHub'

export default {
	components: {
		Layout,
		Title,
		Placeholder,
		Trigger,
		Error,
		Results,
		Weather,
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
			role: {
				name: ''
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
		exportRoles() {
			this.exporting = true
			setTimeout(() => {
				this.exporting = false
				this.$buefy.toast.open({
					type: 'is-success',
					message: 'The file was generated successfully',
					position: 'is-bottom',
					closable: false,
					duration: 4000
				})
			}, 2000)
		},
		createRole() {
			this.$buefy.modal.open({
				parent: this,
				component: Modal,
				scroll: 'clip',
				customClass: 'is-role is-lg',
				trapFocus: true,
				props: {
					name: 'New'
				}
			})
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
				onConfirm: () =>
					this.$buefy.toast.open({
						type: 'is-success',
						message: 'This role was removed successfully',
						position: 'is-bottom',
						closable: true,
						duration: 5000
					})
			})
		}
	},
	mounted() {
		this.getAllRoles()
		eventHub.$off()
		eventHub.$on('reload-roles', () => {
			this.getAllRoles()
		})
		eventHub.$on('open-modal-role', obj => {
			this.$buefy.modal.open({
				parent: this,
				component: Modal,
				scroll: 'clip',
				customClass: 'is-role is-lg',
				trapFocus: true,
				props: {
					id: obj.id,
					name: 'Edit'
				}
			})
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
							this.$buefy.toast.open({
								type: 'is-success',
								message: message,
								position: 'is-bottom',
								closable: true,
								duration: 5000
							})
							await this.getAllRoles()
						}
					} catch (e) {
						console.log(e)
					}
				}
			})
		})
	}
}
</script>
