const path = require('path')

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
	}
	// pluginOptions: {
	// 	'style-resources-loader': {
	// 		preProcessor: 'sass',
	// 		patterns: [path.resolve(__dirname, './src/assets/styles/_application.sass')]
	// 	}
	// }
}
