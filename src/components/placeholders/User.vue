<template>
	<article class="block placeholder">
		<div class="block__avatar image is-48x48">
			<b-skeleton circle width="50px" height="50px"></b-skeleton>
		</div>
		<div class="block__content">
			<span class="block__name">
				<b-skeleton height="15"></b-skeleton>
				<b-skeleton height="10"></b-skeleton>
			</span>
		</div>
	</article>
</template>

<script>
export default {
	name: 'Placeholder'
}
</script>
