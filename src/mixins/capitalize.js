import Vue from 'vue'

Vue.mixin({
	methods: {
		capitalizeFirstLetter: str => str.charAt(0).toUpperCase() + str.slice(1)
	}
})
