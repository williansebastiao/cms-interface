<template>
	<router-view />
</template>

<script>
let vh = window.innerHeight * 0.01
document.documentElement.style.setProperty('--vh', `${vh}px`)
</script>

<style lang="sass">
@import 'assets/styles/application.sass'
</style>
