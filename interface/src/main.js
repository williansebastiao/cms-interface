import Vue from 'vue'
import App from './App'
import Buefy from 'buefy'
import Tour from 'vue-tour'
import router from './router'
import './validation'

Vue.config.productionTip = false

Vue.use(Buefy)
Vue.use(Tour)

new Vue({
	router,
	render: h => h(App)
}).$mount('#app')
