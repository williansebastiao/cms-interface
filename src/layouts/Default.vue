<template>
	<div class="is-flex">
		<!-- <b-loading :is-full-page="true" v-model="isLoading"></b-loading> -->
		<Sidebar />
		<main class="page">
			<slot></slot>
		</main>
	</div>
</template>

<script>
import Sidebar from '@/components/Sidebar'
import eventHub from '@/services/eventHub'
import Api from '@/services/api'

export default {
	name: 'Layout',
	components: {
		Sidebar
	},
	data() {
		return {
			isLoading: true
		}
	},
	methods: {
		openLoading() {
			this.isLoading = false
		},
		async me() {
			try {
				const response = await Api.get('user/me')
				const { status } = response
				if (status === 200) {
					const { data } = response
					eventHub.$emit('me', data)
				}
			} catch (e) {
				console.log(e)
			}
		}
	},
	mounted() {
		this.me()
	}
}
</script>
