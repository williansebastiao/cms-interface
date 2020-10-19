<template>
	<section class="auth">
		<div class="columns">
			<div v-if="!isMobile" class="auth__image column is-two-fifths is-hidden-mobile">
				<b-image :src="image" :placeholder="image" loading="lazy" ratio="2by3"></b-image>
				<!--
				<video autoplay muted>
				<source src="http://www.wallaceerick.com.br/world.mp4" type="video/mp4" />
				</video>
				-->
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
import image from '../assets/images/background/1.jpg'
import { responsive } from '@/mixins/responsive'

export default {
	name: 'Layout',
	mixins: [responsive],
	data() {
		return {
			image: image
		}
	}
}
</script>
