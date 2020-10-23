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
					<b-input placeholder="Search..." type="search" icon="magnify"></b-input>
				</b-field>
			</div>
		</section>
		<Error v-if="errored" :icon="true" :back="true" />
		<section v-else>
			<div v-if="loading" class="columns is-multiline">
				<div v-for="r in placeholder" :key="r" class="column is-12-mobile is-6-tablet is-4-desktop">
					<Placeholder />
				</div>
			</div>
			<div class="columns is-multiline">
				<div v-for="r in permission" :key="r.id" class="column is-12-mobile is-6-tablet is-4-desktop">
					<article class="block" :style="{ 'border-left-color': r.color }">
						<div class="block__content">
							<h3 class="block__name">{{ r.name }}</h3>
							<p class="block__email">{{ format(r.created_at) }} • {{ timeTo(r.created_at) }}</p>
						</div>
						<Trigger :id="r._id" :items="actions" />
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
import Placeholder from '@/components/placeholders/Role'
import Trigger from '@/components/Trigger'
import Error from '@/components/Error'
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
		Weather,
		'svg-icon': Icon
	},
	data() {
		return {
			placeholder: 5,
			roles: [],
			loading: true,
			errored: false,
			// Filter
			order: 1,
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
		createRole(user) {
			console.log(user)
			this.$buefy.modal.open({
				parent: this,
				component: Modal,
				scroll: 'clip',
				customClass: 'is-role is-lg',
				trapFocus: true
			})
		},
		deleteRole(user) {
			console.log(user)
			this.$buefy.dialog.alert({
				size: 'is-delete',
				type: 'is-outlined is-primary',
				title: 'Attention',
				message: '<span>Do you really want <br>to <strong>delete</strong> this role?</span> <small>All users with this role will will lose access.</small>',
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
		eventHub.$on('reload-roles', () => {
			this.getAllRoles()
		})
	}
}
</script>
