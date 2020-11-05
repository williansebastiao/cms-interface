import Vue from 'vue'
import VueRouter from 'vue-router'
import Menu from './menu.js'
import Auth from './auth.js'
import Static from './static.js'
import Errors from './errors.js'
import User from './user.js'

Vue.use(VueRouter)

const router = new VueRouter({
	routes: [...Auth, ...Menu, ...Static, ...Errors, ...User],
	mode: 'history',
	// linkExactActiveClass: 'is-active',
	linkActiveClass: 'is-active'
})

export default router
