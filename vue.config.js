const path = require('path')

module.exports = {
	//env: env_config,
	assetsDir: 'assets',

	publicPath: undefined,
	outputDir: undefined,
	runtimeCompiler: undefined,
	productionSourceMap: undefined,
	parallel: undefined,

	// pluginOptions: {
	// 	'style-resources-loader': {
	// 		preProcessor: 'sass',
	// 		patterns: [path.resolve(__dirname, './src/assets/styles/_application.sass')]
	// 	}
	// }
	css: {
		sourceMap: true,
		loaderOptions: {
			sass: {
				// prependData: `@import "~@/assets/styles/application.sass"`
			}
		}
	},

	pluginOptions: {
		i18n: {
			locale: 'pt',
			fallbackLocale: 'en',
			localeDir: 'locales',
			enableInSFC: false
		}
	}
}
