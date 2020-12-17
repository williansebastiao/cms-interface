<template>
	<aside class="sidebar">
		<router-link class="sidebar__top" tag="a" :to="{ name: 'Dashboard' }">
			<Logo width="70px" />
		</router-link>
		<nav v-if="visible" class="navigation navigation--primary">
			<b-tooltip v-for="(r, i) in primary" :label="r.name" :key="i" type="is-primary" position="is-right" v-show="showSidebarMenu(r.name)">
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
import Pusher from 'pusher-js'

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
			id: '',
			visible: false
		}
	},
	methods: {
		async me() {
			try {
				if (!localStorage.getItem('@stup:sidebar')) {
					const response = await Api.get('user/me')
					const { permission } = response.data
					const routes = permission.route
					const dashboard = routes.find(e => e.slug === 'dashboard')
					const roles = routes.find(e => e.slug === 'roles')
					const users = routes.find(e => e.slug === 'users')
					localStorage.setItem('@stup:dashboard', dashboard.role.read)
					localStorage.setItem('@stup:roles', roles.role.read)
					localStorage.setItem('@stup:users', users.role.read)
					localStorage.setItem('@stup:sidebar', 'yes')
				}
			} catch (e) {
				console.log(e)
			} finally {
				this.visible = true
			}
		},
		showSidebarMenu(el) {
			const name = el.toLowerCase()
			return JSON.parse(localStorage.getItem(`@stup:${name}`))
		},
		async subscriber() {
			const response = await Api.get('user/me')
			const { _id } = response.data
			this.id = _id
			Pusher.logToConsole = false
			const pusher = new Pusher('53cbf8c7c95b4a051597', {
				cluster: 'mt1'
			})
			const channel = pusher.subscribe('permission')
			channel.bind(`user_${this.id}`, () => {
				if (localStorage.getItem('@stup:sidebar')) {
					localStorage.removeItem('@stup:sidebar')
				}
			})
		},
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
					localStorage.removeItem('@stup:sidebar')
					await this.$router.push('/')
				}
			} catch (e) {
				console.log(e)
			}
		}
	},
	mounted() {
		this.me()
		this.subscriber()
	},
	computed: {
		primary() {
			return Menu
		}
	}
}
</script>
