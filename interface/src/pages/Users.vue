<template>
	<Layout>
		<section class="columns is-mobile">
			<Title :title="route" />
			<div class="column page__actions">
				<b-button type="is-secondary export" size="is-small" rounded outlined @click="generate($event)">
					<span>Export</span>
					<svg-icon class="icon is-small" icon="export"></svg-icon>
				</b-button>
				<b-button type="is-primary create" rounded @click="user($event)">
					<svg-icon icon="add-user" class="icon is-small"></svg-icon>
					<span>Create</span>
				</b-button>
			</div>
		</section>
		<section class="columns">
			<div class="column">
				<div class="filter is-flex">
					<b-field label="Order" v-model="order" :label-position="label">
						<b-select size="is-small" placeholder="A-Z">
							<option selected value="1">A-Z</option>
							<option value="2">Z-A</option>
							<option value="3">E-mail</option>
						</b-select>
					</b-field>
					<b-field label="Role" v-model="role" :label-position="label">
						<b-select size="is-small" placeholder="All Roles">
							<option value="2">User</option>
							<option value="3">Moderator</option>
							<option value="4">Administrator</option>
						</b-select>
					</b-field>
					<b-field label="Status" v-model="status" :label-position="label">
						<b-select size="is-small" placeholder="Active">
							<option selected value="1">Active</option>
							<option value="2">Inactive</option>
						</b-select>
					</b-field>
					<b-field>
						<b-input size="is-small"></b-input>
					</b-field>
				</div>
			</div>
			<div v-if="users.length > 0" class="column is-flex text-right">
				<p>Showing {{ size * page + 1 }} to {{ size * page + size }} of {{ users.length }} entries</p>
				<!-- <b-button type="is-outline-primary" v-on:click="previous()" :disabled="page == 0">&laquo;</b-button> -->
				<!-- <b-button type="is-outline-primary" v-on:click="next()" :disabled="page >= pageCount - 1">&raquo;</b-button> -->

				<b-pagination v-model="page" :total="total" :simple="true" :per-page="pagination">
					<b-pagination-button slot-scope="props" :page="props.page" :id="`page${props.page.number}`" tag="router-link" :to="`/users#${props.page.number}`"></b-pagination-button>

					<b-pagination-button slot="previous" slot-scope="props" :page="props.page" tag="router-link" :to="`/users#${props.page.number}`">Previous</b-pagination-button>

					<b-pagination-button slot="next" slot-scope="props" :page="props.page" tag="router-link" :to="`/users#${props.page.number}`">Next</b-pagination-button>
				</b-pagination>

				<!--
				<b-pagination
					:total="total"
					v-model="current"
					:size="size"
					:per-page="pagination"
					order="is-right"
					:simple="true"
					:rounded="true"
					icon-prev="chevron-left"
					icon-next="chevron-right"
					aria-next-label="Next"
					aria-previous-label="Previous"
					aria-page-label="Page"
					aria-current-label="Current">
				</b-pagination>
				-->
			</div>
		</section>
		<p v-if="errored">Ocorreu um erro ao carregar os usuários.</p>
		<section v-else>
			<div v-if="loading" class="columns is-multiline">
				<div v-for="n in size" :key="n" class="column is-12-mobile is-6-tablet is-4-desktop">
					<Placeholder />
				</div>
			</div>
			<div class="columns is-multiline">
				<div v-for="u in users" :key="u.id" class="column is-12-mobile is-6-tablet is-4-desktop">
					<article class="block">
						<div class="block__avatar image is-48x48">
							<span class="block__role">Administrator</span>
							<b-image ratio="1by1" :src="u.avatar" :alt="u.name" :rounded="true"></b-image>
						</div>
						<div class="block__content">
							<h3 class="block__name">{{ u.name }}</h3>
							<p class="block__email">{{ u.email }}</p>
						</div>
						<span class="block__state">Active</span>
						<b-dropdown class="block__dropdown" trigger="click" position="is-bottom-left">
							<svg-icon class="dots" slot="trigger" icon="dots"></svg-icon>
							<b-dropdown-item class="has-text-grey-light" @click="user(u.id)">
								<svg-icon icon="edit"></svg-icon>
								<span>Edit</span>
							</b-dropdown-item>
							<b-dropdown-item class="has-text-danger" @click="remove(u.id)">
								<svg-icon icon="trash"></svg-icon>
								<span>Delete</span>
							</b-dropdown-item>
						</b-dropdown>
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
import Placeholder from '@/components/placeholders/Users.vue'
import Modal from '@/components/modals/User'

export default {
	components: {
		Layout,
		Title,
		Placeholder,
		'svg-icon': Icon
	},
	data() {
		return {
			total: 0,
			size: 15,
			page: 0,
			current: 0,
			pagination: 12,
			data: [],
			loading: true,
			errored: false,
			order: 1,
			role: 1,
			status: 1,
			label: 'on-border'
		}
	},
	mounted() {
		let api = 'https://5f3b4721fff8550016ae51c9.mockapi.io/api/users',
			page = this.$route.query.page || 0

		axios
			.get(api)
			.then(response => {
				this.$nextTick(() => {
					this.current = page
				})
				setTimeout(() => {
					this.data = response.data
					this.total = response.data.length
					this.loading = false
				}, 1000)
			})
			.catch(error => {
				console.log('error', error)
				this.errored = true
			}) // .finally(() => (console.log(this.loading)))
	},
	watch: {
		$route: {
			immediate: true,
			handler(newVal, oldVal) {
				console.log('new', newVal)
				console.log('old', oldVal)
				if (newVal.hash) {
					this.page = parseInt(newVal.hash.replace('#', ''))
				}
			}
		}
	},
	computed: {
		pageCount() {
			let l = this.total,
				p = this.size

			return Math.ceil(l / p)
		},
		users() {
			let start = this.page * this.size,
				end = start + this.size

			return this.data.slice(start, end)
		},
		route() {
			return this.$route.name
		}
	},
	methods: {
		generate() {
			this.$buefy.toast.open({
				type: 'is-success',
				message: 'The file was generated successfully',
				position: 'is-bottom',
				closable: false,
				duration: 3000
			})
		},
		user(user) {
			console.log(user)
			this.$buefy.modal.open({
				parent: this,
				component: Modal,
				scroll: 'keep',
				customClass: 'is-user is-sm',
				trapFocus: true
			})
		},
		remove(user) {
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

<style lang="sass">
.users-enter-active,
.users-leave-active
	transition: all 1s

.users-enter,
.users-leave-to
	opacity: 0
	// transform: translateY(30px)
</style>
