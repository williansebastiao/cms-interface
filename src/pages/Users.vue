<template>
	<Layout>
		<section class="columns is-mobile">
			<Title />
			<div class="column page__actions">
				<b-button v-if="!errored" type="is-secondary export" :loading="exporting" size="is-small" rounded outlined @click="exportUsers($event)">
					<span>Export</span>
					<svg-icon class="icon is-small" icon="export"></svg-icon>
				</b-button>
				<b-button type="is-primary create" rounded @click="createUser($event)">
					<svg-icon icon="add-user" class="icon is-small"></svg-icon>
					<span>Create</span>
				</b-button>
			</div>
			<Weather />
		</section>
		<section v-if="!errored" class="columns filter">
			<div class="column filter__wrapper">
				<b-field label="Order" v-model="order" :label-position="label">
					<b-select placeholder="Name">
						<option selected value="1">Name</option>
						<option value="2">E-mail</option>
						<option value="3">Role</option>
						<option value="4">Status</option>
					</b-select>
				</b-field>
				<b-field label="Role" v-model="role" :label-position="label">
					<b-select placeholder="All Roles">
						<option v-for="r in permission" :value="r._id" :key="r._id">{{ r.name }}</option>
					</b-select>
				</b-field>
				<b-field label="Status" v-model="status" :label-position="label">
					<b-select placeholder="Active">
						<option selected value="1">Active</option>
						<option value="2">Inactive</option>
					</b-select>
				</b-field>
				<b-field>
					<b-input placeholder="Search..." type="search" icon="magnify"></b-input>
				</b-field>
			</div>
			<div v-if="users.length > 0" class="column is-flex is-justify-content-flex-end">
				<b-pagination :current.sync="current" :total="total" :page="page" :per-page="pagination" :simple="true" :rounded="true" order="is-right" icon-prev="chevron-left" icon-next="chevron-right"></b-pagination>
			</div>
		</section>
		<Error v-if="errored" :icon="true" :back="true" />
		<section v-else>
			<div v-if="loading" class="columns is-multiline">
				<div v-for="n in pagination" :key="n" class="column is-12-mobile is-6-tablet is-4-desktop">
					<Placeholder />
				</div>
			</div>
			<div class="columns is-multiline">
				<div v-for="u in users" :key="u.id" class="column is-12-mobile is-6-tablet is-4-desktop">
					<article class="block">
						<!-- <b-tooltip label="Administrator" type="is-primary" position="is-right"> -->
						<div class="block__avatar image is-48x48">
							<span class="block__role">Administrator</span>
							<b-image ratio="1by1" :src="u.avatar" :alt="u.name" :rounded="true"></b-image>
						</div>
						<!-- </b-tooltip> -->
						<div class="block__content">
							<h3 class="block__name">{{ u.name }}</h3>
							<p class="block__email">{{ u.email }}</p>
						</div>
						<Trigger :id="u.id" :items="actions" />
					</article>
				</div>
			</div>
		</section>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Title from '@/components/Title'
import Icon from '@/components/Icon'
import Placeholder from '@/components/placeholders/User'
import Trigger from '@/components/Trigger'
import Error from '@/components/Error'
import Modal from '@/components/modals/User'
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
		Weather,
		'svg-icon': Icon
	},
	data() {
		return {
			// Pagination
			current: 1,
			page: 1,
			pagination: 15,
			data: [],
			loading: true,
			errored: false,
			// Filter
			order: 3,
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
			permission: []
		}
	},
	mounted() {
		this.getAllRoles()
		this.getAllUsers()
		eventHub.$off()
		eventHub.$on('reload-users', () => {
			this.getAllUsers()
		})
	},
	computed: {
		total() {
			return this.data.length
		},
		users() {
			let current = this.current - 1
			return this.data.slice(current * this.pagination, (current + 1) * this.pagination)
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
					this.loading = false
				}
			} catch (e) {
				console.log(e)
			} finally {
				this.loading = false
			}
		},
		exportUsers() {
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
		createUser() {
			this.$buefy.modal.open({
				parent: this,
				component: Modal,
				scroll: 'keep',
				customClass: 'is-user is-sm',
				trapFocus: true
			})
		},
		deleteUser() {
			this.$buefy.dialog.alert({
				size: 'is-delete',
				type: 'is-outlined is-primary',
				title: 'Attention',
				message: "<span>Do you really want <br>to <strong>delete</strong> this entry?</span> <small>This action can't be reversed.</small>",
				canCancel: true,
				focusOn: 'cancel',
				cancelText: 'No',
				confirmText: 'Yes',
				onConfirm: () =>
					this.$buefy.toast.open({
						type: 'is-success',
						message: 'This user was removed successfully',
						position: 'is-bottom',
						closable: true,
						duration: 5000
					})
			})
		}
	}
}
</script>
