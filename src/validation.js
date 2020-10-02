// https://logaretm.github.io/vee-validate/guide/rules.html
import { required, confirmed, length, email, digits, min, max } from 'vee-validate/dist/rules'
import { extend } from 'vee-validate'

extend('required', {
	...required,
	message: 'This field is required'
})

extend('email', {
	...email,
	message: 'This field must be a valid email'
})

extend('confirmed', {
	...confirmed,
	message: 'This field confirmation does not match'
})

// extend('name', {
//   ...length,
//   message: 'Your name must have {length} characters'
// })

extend('length', {
	...length,
	message: 'This field must have 2 options'
})

extend('min', {
	...min,
	message: '{_field_} must have at a least of {length} characters'
})

extend('max', {
	...max,
	message: 'bbbb'
})

extend('digits', {
	...digits,
	message: 'sss'
})
