<template>
	<div class="weather" v-if="show">
		<!-- <img :src="image" :alt="city"> -->
		<Placeholder v-if="loading" />
		<div class="weather__temperature" v-else>
			<p class="title is-4">{{ temperature }}</p>
			<p class="subtitle is-7 is-regular">{{ city }}</p>
		</div>
	</div>
</template>

<script>
// import axios from 'axios'
import Placeholder from '@/components/placeholders/Weather'

export default {
	name: 'Weather',
	components: {
		Placeholder
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
		/*if (window.navigator.geolocation) {
			// Get user city based on his geolocation
			const getUserCity = position => {
				const { latitude, longitude } = position.coords
				axios
					.get(`https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=1151dcbe57f947b0917cea8841719fef`)
					.then(response => {
						let city = response.data.results[0].components.city
						this.city = city
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
						let data = response.data
						this.temperature = (data.main.temp - 273.15).toFixed(0) + 'º'
						this.image = 'http://openweathermap.org/img/wn/' + data.weather[0].icon + '@2x.png'
						this.loading = false
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
		}*/
	}
}
</script>