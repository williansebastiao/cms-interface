const path = require('path')

/*const conf = {
	local: {
		base_api: 'http://localhost:8080/api/'
	}
}*/

//const env_config = conf['local']

module.exports = {
	//env: env_config,
	assetsDir: 'assets',
	publicPath: undefined,
	outputDir: undefined,
	runtimeCompiler: undefined,
	productionSourceMap: undefined,
	parallel: undefined,
	css: {
		sourceMap: true,
		loaderOptions: {
			sass: {
				// prependData: `@import "~@/assets/styles/application.sass"`
			}
		}
	},
	// pluginOptions: {
	// 	'style-resources-loader': {
	// 		preProcessor: 'sass',
	// 		patterns: [path.resolve(__dirname, './src/assets/styles/_application.sass')]
	// 	}
	// }
}
