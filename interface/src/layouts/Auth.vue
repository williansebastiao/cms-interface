<template>
	<section class="auth">
		<div class="columns">
			<div class="auth__image column is-two-fifths is-hidden-mobile">
				<!--
					<b-image
						src="../assets/images/background/1.jpg"
						placeholder="../assets/images/background/placeholder/1.jpg"
						loading="lazy"
						ratio="2by3">
					</b-image>
				-->
				<video autoplay muted>
					<source src="http://www.wallaceerick.com.br/world.mp4" type="video/mp4" />
				</video>
			</div>
			<div class="column auth__content">
				<slot>
					<router-view />
				</slot>
			</div>
		</div>
	</section>
</template>

<script>
export default {
	name: 'Layout',
	props: {
		video: {
			type: String
		},
		image: {
			type: String
		}
	}
}
</script>
