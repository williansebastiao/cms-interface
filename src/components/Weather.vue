<template>
	<div :class="{ weather: show, 'no-border': !bordered }" v-if="show">
		<Placeholder v-if="loading" />
		<div class="weather__temperature" v-else>
			<p class="title is-4">{{ temperature }}</p>
			<p class="subtitle is-7 is-regular">{{ city }}</p>
		</div>
	</div>
</template>

<script>
import axios from 'axios'
import Placeholder from '@/components/placeholders/Weather'

export default {
	name: 'Weather',
	components: {
		Placeholder
	},
	props: {
		bordered: {
			type: Boolean,
			default: true
		}
	},
	data() {
		return {
			show: true,
			loading: true,
			temperature: 0,
			city: 'São Paulo',
			image: ''
		}
	},
	mounted() {
		let sc = '@stup:city',
			st = '@stup:temperature'

		// If these values was storage on session
		if (sessionStorage.getItem(sc) && sessionStorage.getItem(st)) {
			this.city = sessionStorage.getItem(sc)
			this.temperature = sessionStorage.getItem(st)
			this.loading = false
		} else {
			if (window.navigator.geolocation) {
				// Get user city based on his geolocation
				const getUserCity = position => {
					const { latitude, longitude } = position.coords
					axios
						.get(`https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=1151dcbe57f947b0917cea8841719fef`)
						.then(response => {
							let city = response.data.results[0].components.city
							this.city = city
							sessionStorage.setItem(sc, city)
							getTemperature(city)
						})
						.catch(error => {
							console.log('error', error)
						})
				}

				// Get the temperature based on user city
				const getTemperature = city => {
					axios
						.get(`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=1e6f8463d6167f6260033ee062b48507`)
						.then(response => {
							let data = response.data,
								temperature = (data.main.temp - 273.15).toFixed(0) + 'º'
							this.image = 'http://openweathermap.org/img/wn/' + data.weather[0].icon + '@2x.png'
							this.temperature = temperature
							this.loading = false
							sessionStorage.setItem(st, temperature)
						})
						.catch(error => {
							console.log('error', error)
						})
				}

				// Hide component if user disallow your gelocation
				const notAllowed = error => {
					if (error.code == error.PERMISSION_DENIED) {
						this.show = false
						console.log('error', error)
					}
				}

				// Get user geolocation
				window.navigator.geolocation.getCurrentPosition(getUserCity, notAllowed)
			}
		}
		/*
		cloudy
		cloudy-alert
		cloudy-arrow-right
		fog
		hail
		hazy
		hurricane
		lightning
		lightning-rainy
		night
		night-partly-cloudy
		partly-cloudy
		partly-lightning
		partly-rainy
		partly-snowy
		partly-snowy-rainy
		pouring
		rainy
		snowy
		snowy-heavy
		snowy-rainy
		sunny
		sunny-alert
		sunny-off
		sunset
		sunset-down
		sunset-up
		tornado
		windy
		windy-variant
		*/
	}
}
</script>
