<template>
	<Layout>
		<Header :bordered="false" />
		<section class="profile columns">
			<Sidebar :user="user"/>
			<slot :user="user"></slot>
		</section>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Header from '@/components/Header'
import Sidebar from '@/pages/profile/Sidebar'
import Api from '@/services/api'

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
				}
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
