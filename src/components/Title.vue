<template>
	<header class="column is-flex is-justify-content-flex-start is-align-items-center">
		<h1 class="title mb-0">{{ name }}</h1>
		<Breadcrumb v-if="name != 'Dashboard'" />
	</header>
</template>

<script>
import Breadcrumb from '@/components/Breadcrumb'
export default {
	name: 'Title',
	components: {
		Breadcrumb
	},
	computed: {
		name() {
			let r = this.$route
			// If route has father, preserve his name
			if (r.matched) {
				return r.matched[0].name
			}
			return r.name
		}
	}
}
</script>
