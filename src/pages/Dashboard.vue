<template>
	<Layout>
		<div class="columns">
			<Title dashboard-step="1" />
			<Weather />
		</div>
		<b-table dashboard-step="2" :bordered="bordered" :data="users" :columns="columns"></b-table>
		<v-tour name="dashboard" :steps="steps"></v-tour>
	</Layout>
</template>

<script>
import Layout from '@/layouts/Default'
import Title from '@/components/Title'
import Weather from '@/components/Weather'

export default {
	name: 'Dashboard',
	components: {
		Layout,
		Title,
		Weather
	},
	data() {
		return {
			bordered: true,
			columns: [
				{
					field: 'id',
					label: 'ID',
					width: '40',
					numeric: true
				},
				{
					field: 'name',
					label: 'Name'
				},
				{
					field: 'gender',
					label: 'Gender'
				}
			],
			users: [
				{ id: 1, name: 'Jesse Simmons', gender: 'Male' },
				{ id: 2, name: 'John Jacobs', gender: 'Male' },
				{ id: 3, name: 'Tina Gilbert', gender: 'Female' },
				{ id: 4, name: 'Clarence Flores', gender: 'Male' },
				{ id: 5, name: 'Anne Lee', gender: 'Female' }
			],
			steps: [
				{
					target: '[dashboard-step="1"]',
					header: {
						title: 'Hello!'
					},
					content: `You started our tour!`,
					params: {
						placement: 'left'
					}
				},
				{
					target: '[dashboard-step="2"]',
					content: 'Try it, you will love it!<br>You can put HTML in the steps and completely customize the DOM to suit your needs.',
					params: {
						placement: 'bottom'
					}
				}
			]
		}
	},
	mounted: function() {
		this.$tours['dashboard'].start()
	}
}
</script>
