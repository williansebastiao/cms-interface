<template>
	<ValidationProvider class="is-block is-relative" :vid="vid" :name="$attrs.name || $attrs.label" :rules="rules" v-slot="{ errors, valid }">
		<slot></slot>
		<b-field v-bind="$attrs" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
			<b-input v-on:blur="blur" v-model="innerValue" :tabindex="tab" v-bind="$attrs"></b-input>
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
		blur: {
			type: Function
		},
		// must be included in props
		value: {
			type: null
		}
	},
	data() {
		return {
			innerValue: ''
		}
	},
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
		}
	}
}
</script>
