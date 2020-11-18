<template>
	<Layout>
		<ValidationObserver class="column" ref="observer" v-slot="{ handleSubmit }">
			<form @submit.prevent="handleSubmit(updateProfile)">
				<article class="profile__column panel">
					<div class="panel__header">
						<span class="is-flex is-flex-direction-column is-justify-content-center">
							<h3 class="profile__name pt-0 is-semibold is-size-6">Personal Information</h3>
							<p class="is-size-7">Update your personal informaiton</p>
						</span>
						<b-button tabindex="6" native-type="submit" type="is-primary save" :loading="loading" rounded>Save</b-button>
					</div>
					<div class="panel__body">
						<h3 class="profile__section has-text-primary is-semibold is-size-5">User Data</h3>
						<InputWithValidation class="profile__field" tab="1" rules="required" type="text" label="First Name" size="is-medium" />

						<!-- <InputWithValidation class="profile__field" tab="2" rules="required" type="text" label="Last Name" size="is-medium" v-model="user.last_name" /> -->
					</div>
					<hr />
					<div class="panel__body">
						<h3 class="profile__section has-text-primary is-semibold is-size-5">Contact Info</h3>

						<!-- <InputWithValidation class="profile__field" tab="3" type="text" label="Phone" size="is-medium" v-model="user.phone" /> -->

						<!-- <InputWithValidation class="profile__field" tab="4" rules="required|email" type="email" label="Email" size="is-medium" v-model="user.email" /> -->

						<!-- <InputWithValidation class="profile__field" tab="5" type="text" label="Site" size="is-medium" v-model="user.site" /> -->
					</div>
				</article>
			</form>
		</ValidationObserver>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Profile'
import InputWithValidation from '@/components/inputs/InputWithValidation'
import { ValidationObserver } from 'vee-validate'

export default {
	name: 'Personal',
	components: {
		Layout,
		InputWithValidation,
		ValidationObserver
	},
	props: {
		user: {
			type: Object,
			default: () => {}
		}
	},
	data() {
		return {
			loading: false,
			bordered: true,
			onAccept(e) {
				const maskRef = e.detail
				this.value = maskRef.value
				console.log('accept', maskRef.value)
			}
		}
	}
}
</script>
