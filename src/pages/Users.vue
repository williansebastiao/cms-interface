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
						<option value="1">User</option>
						<option value="2">Moderator</option>
						<option value="3">Administrator</option>
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
				<b-pagination
					:total="total"
					:page="page"
					:per-page="pagination"
					:simple="true"
					:rounded="true"
					order="is-right"
					icon-prev="chevron-left"
					icon-next="chevron-right"
				></b-pagination>
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
import axios from 'axios'
import Layout from '@/layouts/Default'
import Title from '@/components/Title'
import Icon from '@/components/Icon'
import Placeholder from '@/components/placeholders/User'
import Trigger from '@/components/Trigger'
import Error from '@/components/Error'
import Modal from '@/components/modals/User'
import Weather from '@/components/Weather'

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
			total: 0,
			page: 1,
			pagination: 15,
			data: [],
			loading: true,
			errored: false,
			// Filter
			order: 3,
			role: 1,
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
			]
		}
	},
	mounted() {
		let api = 'https://5f3b4721fff8550016ae51c9.mockapi.io/api/users'

		axios
			.get(api)
			.then(response => {
				setTimeout(() => {
					this.data = response.data
					this.total = response.data.length
					this.loading = false
				}, 1000)
			})
			.catch(error => {
				console.log('error', error)
				this.errored = true
			})
		// .finally(() => (console.log(this.loading)))
	},
	computed: {
		users() {
			let start = this.page * this.pagination,
				end = start + this.pagination

			return this.data.slice(start, end)
		}
	},
	methods: {
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
		createUser(user) {
			console.log(user)
			this.$buefy.modal.open({
				parent: this,
				component: Modal,
				scroll: 'keep',
				customClass: 'is-user is-sm',
				trapFocus: true
			})
		},
		deleteUser(user) {
			console.log(user)
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