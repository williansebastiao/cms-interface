<template>
	<ValidationProvider class="is-block is-relative" :vid="vid" :name="$attrs.label" :rules="rules" v-slot="{ errors, valid }">
		<b-field v-bind="$attrs" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
			<b-select v-model="innerValue" :tabindex="tab" v-bind="$attrs" placeholder="Select a subject">
				<slot />
			</b-select>
		</b-field>
	</ValidationProvider>
</template>

<script>
import { ValidationProvider } from 'vee-validate'

export default {
	components: {
		ValidationProvider
	},
	props: {
		tab: {
			type: [String, Number],
			default: 1
		},
		vid: {
			type: String
		},
		rules: {
			type: [Object, String],
			default: ''
		},
		// must be included in props
		value: {
			type: null
		}
	},
	data: () => ({
		innerValue: ''
	}),
	watch: {
		// Handles internal model changes.
		innerValue(newVal) {
			this.$emit('input', newVal)
		},
		// Handles external model changes.
		value(newVal) {
			this.innerValue = newVal
		}
	},
	created() {
		if (this.value) {
			this.innerValue = this.value
			console.log(this.innerValue0)
		}
	}
}
</script>
