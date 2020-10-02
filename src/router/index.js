import Vue from 'vue'
import VueRouter from 'vue-router'
import Menu from './Menu.js'
import Auth from './Auth.js'
import Static from './Static.js'
import Errors from './Errors.js'

Vue.use(VueRouter)

const router = new VueRouter({
	routes: [...Auth, ...Menu, ...Static, ...Errors],
	mode: 'history',
	// linkExactActiveClass: 'is-active',
	linkActiveClass: 'is-active'
})

export default router
