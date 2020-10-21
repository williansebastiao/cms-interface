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
			return this.$route.name
		}
	}
}
</script>
