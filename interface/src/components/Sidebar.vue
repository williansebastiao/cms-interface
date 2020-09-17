<template>
	<aside class="sidebar">
		<span class="sidebar__top">
			<Logo width="70px" />
		</span>
		<nav class="navigation">
			<b-tooltip v-for="(r, i) in primary" :label="r.name" :key="i" type="is-primary" position="is-right">
				<router-link class="navigation__link" tag="a" :to="r">
					<svg-icon :icon="r.icon"></svg-icon>
				</router-link>
			</b-tooltip>
		</nav>
		<span class="sidebar__bottom">
			<router-link class="sidebar__profile" tag="a" :to="{ name: 'Dashboard' }">
				<img src="@/assets/images/profile.jpg" alt="Profile" />
			</router-link>
		</span>
	</aside>
</template>

<script>
import Menu from '@/router/Menu.js'
import Icon from '@/components/Icon'
import Logo from '@/components/Logo'

export default {
	name: 'Sidebar',
	components: {
		Logo,
		'svg-icon': Icon
	},
	data() {
		return {
			expandOnHover: false,
			mobile: 'reduce',
			reduce: false,
			open: true,
			overlay: false,
			fullheight: true
		}
	},
	computed: {
		primary() {
			return Menu
		}
	}
}
</script>

<style lang="sass" scoped>
.smile-icon
	font-size: 24px
	fill: #aaa
	&:hover
		fill: #666
</style>
