<template>
	<form>
		<header class="modal-card-head">
			<h4 class="modal-card-title">
				Editar
				<strong>Avatar</strong>
			</h4>
		</header>
		<div class="modal-card-body">
			<div class="modal-card">
				<div class="avatar">
					<cropper :src="image" @change="change" />
					<input type="file" id="avatar" hidden accept="image/*" @change="onFileChange" />
					<b-button native-type="button" class="avatar__edit" v-if="!add" @click="choosePhoto">
						<svg-icon icon="edit"></svg-icon>
					</b-button>
					<b-button native-type="button" class="avatar__add" v-if="add" @click="choosePhoto">
						<svg-icon icon="upload"></svg-icon>
					</b-button>
				</div>
			</div>
		</div>
		<footer class="modal-card-foot">
			<b-button class="is-rounded is-outlined is-danger" @click="$emit('close')">Close</b-button>
			<b-button native-type="button" class="is-rounded is-primary" :loading="loading" @click="update">Save</b-button>
		</footer>
	</form>
</template>

<script>
import Icon from '@/components/Icon'
import { Cropper } from 'vue-advanced-cropper'
import { ToastProgrammatic as Toast } from 'buefy'
import Api from '@/services/api'

export default {
	name: 'Avatar',
	components: {
		'svg-icon': Icon,
		Cropper
	},
	data() {
		return {
			add: true,
			edit: false,
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
	methods: {
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
			this.add = false
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
	}
}
</script>
