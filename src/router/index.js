import Vue from 'vue'
import VueRouter from 'vue-router'
import Menu from './Menu.js'
import Auth from './Auth.js'
import Static from './Static.js'
import Errors from './Errors.js'
import User from './User.js'

Vue.use(VueRouter)

const router = new VueRouter({
	routes: [...Auth, ...Menu, ...Static, ...Errors, ...User],
	mode: 'history',
	// linkExactActiveClass: 'is-active',
	linkActiveClass: 'is-active'
})

// router.beforeResolve((to, from, next) => {
// 	// If this isn't an initial page load.
// 	if (to.name) {
// 		// Start the route progress bar.
// 		// NProgress.start()
// 		console.log('before to', to)
// 		console.log('before from', from)
// 	}
// 	next()
// })

// router.afterEach((to, from) => {
// 	// Complete the animation of the route progress bar.
// 	// NProgress.done()
// 	console.log('after to', to)
// 	console.log('after from', from)
// })

export default router
