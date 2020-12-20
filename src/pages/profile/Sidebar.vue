<template>
	<aside class="column profile__sidebar">
		<div class="profile__column ">
			<div class="columns mb-0">
				<div class="column is-one-third profile__image">
					<img :src="user.avatar" :alt="user.full_name" @click="openAvatar" />
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
		<b-modal v-model="visible">
			<form>
				<header class="modal-card-head">
					<h4 class="modal-card-title">
						Editar
						<strong>Avatar</strong>
					</h4>
				</header>
				<div class="modal-card-body">
					<div class="modal-card">
						<div class="columns mb-2">
							<cropper :src="image" @change="change" />
						</div>
					</div>
				</div>
				<footer class="modal-card-foot">
					<b-button class="is-rounded is-outlined is-danger" @click="visible = false">Close</b-button>
					<b-button native-type="button" class="is-rounded is-primary" @click="choosePhoto">Choose a photo</b-button>
					<b-button native-type="button" class="is-rounded is-primary" :loading="loading" @click="update">Save</b-button>
					<input type="file" id="avatar" hidden accept="image/*" @change="onFileChange" />
				</footer>
			</form>
		</b-modal>
	</aside>
</template>

<script>
import Menu from '@/router/user'
import Icon from '@/components/Icon'
import { Cropper } from 'vue-advanced-cropper'
import { ToastProgrammatic as Toast } from 'buefy'
import Api from '@/services/api'

export default {
	name: 'Sidebar',
	components: {
		'svg-icon': Icon,
		Cropper
	},
	data() {
		return {
			loading: false,
			visible: false,
			image: '',
			file: {
				avatar: '',
				width: '',
				height: '',
				x: '',
				y: ''
			}
		}
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
			this.visible = true
		},
		choosePhoto() {
			document.getElementById('avatar').click()
		},
		async onFileChange(e) {
			const file = e.target.files[0]
			this.file.avatar = file
			this.image = await this.readFile(file)
		},
		readFile(file) {
			return new Promise(resolve => {
				const reader = new FileReader()
				reader.addEventListener('load', () => resolve(reader.result), false)
				reader.readAsDataURL(file)
			})
		},
		change({ coordinates }) {
			this.file.width = coordinates.width
			this.file.height = coordinates.height
			this.file.x = coordinates.left
			this.file.y = coordinates.top
		},
		async update() {
			try {
				this.loading = true
				const formData = new FormData()
				const config = {
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				}

				formData.append('avatar', this.file.avatar)
				formData.append('width', this.file.width)
				formData.append('height', this.file.height)
				formData.append('x', this.file.x)
				formData.append('y', this.file.y)

				const response = await Api.post('user/avatar', formData, config)
				const { status } = response
				if (status === 200) {
					const { message, src } = response.data
					this.$props.user.avatar = src
					this.visible = false
					this.image = ''
					Toast.open({
						message,
						type: 'is-success',
						position: 'is-bottom'
					})
				}
			} catch (e) {
				const { status } = e
				if (status === 422) {
					const { message } = e.data
					this.visible = false
					this.image = ''
					Toast.open({
						message,
						type: 'is-danger',
						position: 'is-bottom'
					})
				}
			} finally {
				this.loading = false
			}
		}
	},
	computed: {
		navigation() {
			return Menu
		}
	}
}
</script>
