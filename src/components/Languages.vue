<template>
	<div>
		<b-field>
			<b-select placeholder="Languages" icon="earth" v-model="$i18n.locale" @change.native="setLanguage($i18n.locale)">
				<option v-for="l in languages" :key="l.code" :value="l.code">{{ l.name }}</option>
			</b-select>
		</b-field>
	</div>
</template>

<script>
export default {
	name: 'Languages',
	data() {
		return {
			languages: [
				{
					code: 'pt',
					name: 'Português'
				},
				{
					code: 'en',
					name: 'English'
				}
			]
		}
	},
	mounted() {
		let locale = localStorage.getItem('@stup:language')
		if (locale) {
			this.$i18n.locale = locale
		}
	},
	methods: {
		setLanguage(locale) {
			localStorage.setItem('@stup:language', locale)
		}
	}
}
</script>
