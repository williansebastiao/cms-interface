<template>
	<main>
		<span>{{ name }}</span>
	</main>
</template>

<script>

import eventHub from "@/services/eventHub";

export default {
	name: "my-componet",
	data() {
		return {
			name: 'willians'
		}
	},
	methods: {

	},
	mounted() {
		eventHub.$on('change-name', obj => {
			this.name = obj.name;
		})
	}
}
</script>

<style scoped>

</style>
