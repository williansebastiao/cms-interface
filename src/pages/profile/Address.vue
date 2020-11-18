<template>
	<ValidationObserver ref="observer" v-slot="{ handleSubmit }">
		<form class="column" @submit.prevent="handleSubmit(updateProfile)">
			<article class="profile__column panel">
				<div class="panel__header">
					<span class="is-flex is-flex-direction-column is-justify-content-center">
						<h3 class="profile__name pt-0 is-semibold is-size-6">Personal Information</h3>
						<p class="is-size-7">Update your informations</p>
					</span>
					<b-button tabindex="6" native-type="submit" type="is-primary save" :loading="loading" rounded>Save</b-button>
				</div>
				<div class="panel__body">
					<h3 class="profile__section has-text-primary is-semibold is-size-5">User Data</h3>
					<InputWithValidation class="profile__field" tab="1" rules="required" type="text" label="Site" size="is-medium" v-model="user.site" />
					<InputWithValidation class="profile__field" tab="2" rules="required|min:15" type="text" label="Phone" size="is-medium" v-mask="'(##) #####-####'" v-model="user.phone" />
					<InputWithValidation class="profile__field" tab="3" type="text" label="Zipcode" size="is-medium" v-mask="'#####-###'" v-model="user.address.zipcode" :blur="findAddress" />
					<InputWithValidation class="profile__field" tab="4" rules="required|min:2" type="text" label="Address" size="is-medium" v-model="user.address.street" />
					<InputWithValidation class="profile__field" tab="5" rules="required|min:1" type="text" label="Number" size="is-medium" ref="number" v-model="user.address.number" />
					<InputWithValidation class="profile__field" tab="6" rules="required|min:4" type="text" label="Neighborhood" size="is-medium" v-model="user.address.neighborhood" />
					<InputWithValidation class="profile__field" tab="7" rules="required|min:2" type="text" label="State" size="is-medium" v-model="user.address.state" />
					<InputWithValidation class="profile__field" tab="8" rules="required|min:4" type="text" label="City" size="is-medium" v-model="user.address.city" />
				</div>
			</article>
		</form>
	</ValidationObserver>
</template>

<script>
import InputWithValidation from '@/components/inputs/InputWithValidation'
import { ValidationObserver } from 'vee-validate'

export default {
	name: 'Address',
	components: {
		InputWithValidation,
		ValidationObserver
	},
	data() {
		return {
			loading: false,
			bordered: true,
			onAccept(e) {
				const maskRef = e.detail
				this.value = maskRef.value
				console.log('accept', maskRef.value)
			},
			user: {}
		}
	}
}
</script>
