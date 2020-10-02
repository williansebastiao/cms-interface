<template>
	<div class="is-flex">
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
	}
}
</script>
