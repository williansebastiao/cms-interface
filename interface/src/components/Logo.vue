<template>
	<h1 class="logo text-center" v-bind="$attrs">
		<img src="@/assets/images/logo-blue.png" :width="width" :alt="title" />
	</h1>
</template>

<script>
export default {
	name: 'Logo',
	props: {
		width: {
			type: String,
			default: '120px'
		},
		title: {
			type: String,
			default: 'Stup'
		}
	}
}
</script>
