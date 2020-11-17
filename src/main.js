import Vue from 'vue'
import App from './App'
import Buefy from 'buefy'
import Tour from 'vue-tour'
import VueMask from 'v-mask'
import router from './router'
import i18n from './i18n'
import './validation'

Vue.config.productionTip = false

Vue.use(Buefy)
Vue.use(Tour)
Vue.use(VueMask)

new Vue({
	router,
	i18n,
	render: h => h(App)
}).$mount('#app')
