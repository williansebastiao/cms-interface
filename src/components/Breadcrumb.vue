<template>
	<nav class="breadcrumb is-small has-dot-separator" aria-label="breadcrumbs">
		<ul>
			<li>
				<router-link tag="a" :to="{ name: 'Dashboard' }">Dashboard</router-link>
			</li>
			<li v-if="parent">
				<a :href="parent.path">{{ parent.name }}</a>
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
		parent() {
			let r = this.$route
			if (r.matched.length > 1) {
				return r.matched[0]
			}
			return false
		},
		current() {
			let r = this.$route
			return r.name
		}
	}
}
</script>
