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
	mounted() {
		eventHub.$on('me', obj => {
			this.user = obj
		})
	},
	created() {
		//eventHub.$off()
	}
}
</script>
