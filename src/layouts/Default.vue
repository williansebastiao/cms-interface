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
		}
	}
}
</script>
