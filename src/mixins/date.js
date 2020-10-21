import Vue from 'vue'
import dayjs from 'dayjs'

let relativeTime = require('dayjs/plugin/relativeTime')

dayjs.extend(relativeTime)

Vue.mixin({
	methods: {
		format: date => dayjs(date).format('DD/MM/YYYY'),
		timeTo: date => dayjs().to(dayjs(date)),
		timeFrom: date => dayjs().from(dayjs(date))
	}
})
