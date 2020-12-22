<template>
	<aside class="column profile__sidebar">
		<div class="profile__column ">
			<div class="columns mb-0">
				<div class="column is-one-third profile__image">
					<b-button native-type="button" class="avatar__edit" @click="openAvatar">
						<svg-icon icon="edit"></svg-icon>
					</b-button>
					<img :src="user.avatar" :alt="user.full_name" />
				</div>
				<div class="column">
					<h3 class="profile__name is-semibold is-size-5">{{ user.full_name }}</h3>
					<p v-if="user.permission" class="profile__role">{{ user.permission.name }}</p>
				</div>
			</div>
			<ul class="profile__list">
				<li v-if="user.phone">
					<span class="profile__list__key">Phone:</span>
					<a href="#" class="profile__list__value">{{ user.phone }}</a>
				</li>
				<li v-if="user.email">
					<span class="profile__list__key">Email:</span>
					<a href="#" class="profile__list__value">{{ user.email }}</a>
				</li>
				<li v-if="user.address">
					<span class="profile__list__key">Location:</span>
					<span class="profile__list__value">{{ user.address.city }}/{{ user.address.state }}</span>
				</li>
			</ul>
			<ul class="profile__navigation">
				<li v-for="(m, i) in navigation" :key="i">
					<router-link tag="a" :to="m.path">
						<svg-icon :icon="m.icon"></svg-icon>
						<span>{{ m.name }}</span>
					</router-link>
				</li>
			</ul>
		</div>
	</aside>
</template>

<script>
import Menu from '@/router/user'
import Icon from '@/components/Icon'
import Modal from '@/components/modals/Avatar'
import eventHub from '@/services/eventHub'

export default {
	name: 'Sidebar',
	components: {
		'svg-icon': Icon
	},
	props: {
		user: {
			type: Object,
			required: true,
			default: () => {}
		}
	},
	methods: {
		openAvatar() {
			this.$buefy.modal.open({
				parent: this,
				component: Modal,
				scroll: 'clip',
				customClass: 'is-avatar',
				trapFocus: true
			})
		}
	},
	created() {
		eventHub.$on('avatar', obj => {
			this.$props.user.avatar = obj.avatar
		})
	},
	computed: {
		navigation() {
			return Menu
		}
	}
}
</script>
