<template>
	<aside class="sidebar">
		<router-link class="sidebar__top" tag="a" :to="{ name: 'Dashboard' }">
			<Logo width="70px" />
		</router-link>
		<nav class="navigation navigation--primary">
			<b-tooltip v-for="(r, i) in primary" :label="r.name" :key="i" type="is-primary" position="is-right">
				<router-link class="navigation__link" tag="a" :to="r">
					<svg-icon :icon="r.icon"></svg-icon>
				</router-link>
			</b-tooltip>
		</nav>
		<nav class="navigation navigation--primary">
			<b-tooltip v-for="(r, i) in secondary" :label="r.name" :key="i" type="is-primary" position="is-right">
				<router-link class="navigation__link" tag="a" :to="r">
					<svg-icon :icon="r.icon"></svg-icon>
				</router-link>
			</b-tooltip>
		</nav>
	</aside>
</template>

<script>
import Menu from '@/router/Menu.js'
import User from '@/router/User.js'
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
		},
		secondary() {
			return User
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
