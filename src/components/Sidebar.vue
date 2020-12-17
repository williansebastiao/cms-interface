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
		<nav class="navigation navigation--secondary">
			<b-tooltip label="Profile" type="is-primary" position="is-right">
				<router-link class="navigation__link" tag="a" :to="{ name: 'Profile' }">
					<svg-icon icon="profile"></svg-icon>
				</router-link>
			</b-tooltip>
			<b-tooltip label="Logout" type="is-primary" position="is-right">
				<a href="#" class="navigation__link navigation__link--logout" @click="logout">
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
			fullheight: true,
			user: {},
			visible: true
		}
	},
	methods: {
		async logout(event) {
			try {
				event.preventDefault()
				const response = await Api.post('user/logout')
				const { status } = response
				if (status === 200) {
					localStorage.removeItem('@stup:token')
					localStorage.removeItem('@stup:counter')
					localStorage.removeItem('@stup:dashboard')
					localStorage.removeItem('@stup:roles')
					localStorage.removeItem('@stup:users')
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
