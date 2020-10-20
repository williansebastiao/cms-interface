<template>
	<nav class="breadcrumb is-small has -arrow  has-dot-separator" aria-label="breadcrumbs">
		<ul>
			<li>
				<router-link tag="a" :to="{ name: 'Dashboard' }">Dashboard</router-link>
			</li>
			<li class="is-active is-regular">
				<a href="#" aria-current="page">{{ current }}</a>
			</li>
		</ul>
	</nav>
</template>

<script>
export default {
	name: 'Breadcrumb',
	props: {
		links: {
			type: [Array, Object]
		}
	},
	computed: {
		current() {
			return this.$route.name
		}
	}
}
</script>
