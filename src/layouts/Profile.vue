<template>
	<Layout>
		<Header :bordered="false" />
		<section class="profile columns">
			<Sidebar :user="user" />
			<div class="column">
				<slot class="profile__column panel" v-bind:user="user">{{ user.first_name }}</slot>
			</div>
		</section>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Header from '@/components/Header'
import Sidebar from '@/pages/profile/Sidebar'
import Api from '@/services/api'
import eventHub from '@/services/eventHub'

export default {
	name: 'Profile',
	components: {
		Layout,
		Header,
		Sidebar
	},
	data() {
		return {
			user: {}
		}
	},
	methods: {
		async me() {
			try {
				const response = await Api.get('user/me')
				const { status } = response
				if (status === 200) {
					this.user = response.data
					if (!response.data.address) {
						this.user = {
							...this.user,
							address: {
								zipcode: '',
								address: '',
								number: '',
								neighborhood: '',
								state: '',
								city: ''
							}
						}
					}
				}
				eventHub.$emit('profile', {
					user: this.user
				})
			} catch (e) {
				console.log(e)
			}
		}
	},
	mounted() {
		this.me()
	}
}
</script>
