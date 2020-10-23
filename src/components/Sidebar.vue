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
			<b-tooltip label="Logout" type="is-primary" position="is-right">
				<a @click="logout" class="navigation__link" href="#">
					<svg-icon icon="logout"></svg-icon>
				</a>
			</b-tooltip>
		</nav>
	</aside>
</template>

<script>
import Menu from '@/router/menu'
import Icon from '@/components/Icon'
import Logo from '@/components/Logo'
import Api from '@/services/api'

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
	methods: {
		async logout(event) {
			try {
				event.preventDefault()
				const response = await Api.post('client/logout')
				const { status } = response
				if (status === 200) {
					localStorage.removeItem('@stup:token')
					await this.$router.push('/')
				}
			} catch (e) {
				console.log(e)
			}
		}
	},
	computed: {
		primary() {
			return Menu
		}
	}
}
</script>