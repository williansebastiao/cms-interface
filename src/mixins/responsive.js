export const responsive = {
	data() {
		return {
			isMobile: false
		}
	},
	created() {
		this.isMobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) ? true : false
	}
}
