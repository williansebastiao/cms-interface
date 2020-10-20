<template>
	<header class="column is-flex is-justify-content-flex-start is-align-items-center">
		<h1 class="title mb-0">{{ title }}</h1>
		<Breadcrumb />
	</header>
</template>

<script>
import Breadcrumb from '@/components/Breadcrumb'
export default {
	name: 'Title',
	components: {
		Breadcrumb
	},
	props: {
		title: {
			type: String,
			required: true
		},
		subtitle: String
	}
}
</script>
