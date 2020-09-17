# Interface

> This project use [Buefy](https://buefy.org/documentation) components based on [Bulma](https://bulma.io/documentation/), see both documentations before create components or write new CSS files.

## Development

> We choose [yarn](https://yarnpkg.com/) as default package manager.

```js
yarn install    // to install project dependencies
```

```js
yarn run serve  // to start development with compiles and hot-reloads
```

```js
yarn run build  // to compiles and minifies for production
```

```js
yarn run test   // to run end-to-end tests
```

```js
yarn run lint   // to lint and fixes files
```

## Plugins

> A list with all installed plugins, check it before add new plugins.

- [Axios](https://github.com/axios/axios)
- [Buefy](https://buefy.org/documentation)
- [Content Placeholder](https://github.com/michalsnik/vue-content-placeholders)
- [Material Design Icons](https://materialdesignicons.com/)
- [Password Meter](https://miladd3.github.io/vue-simple-password-meter/)
- [Tour](https://github.com/pulsardev/vue-tour)
- [Vee Validade](https://logaretm.github.io/vee-validate/)


## Editor

> Required extensions and settings for your Editor, we always recommend [Visual Studio Code](https://code.visualstudio.com/).

### Extensions

> Install extensions below.

- [EditorConfig](https://marketplace.visualstudio.com/items?itemName=EditorConfig.EditorConfig)
- [Prettier](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode)
- [Vetur](https://marketplace.visualstudio.com/items?itemName=octref.vetur)

### Settings

> Edit your `settings.json` on `File > Preferences > Settings` or press `ctrl + ,` to open.

```js
// Javascript
"javascript.format.semicolons": "remove",
"typescript.format.semicolons": "remove"

// Prettier
// "prettier.useEditorConfig": false,
"prettier.singleQuote": true,
"prettier.configPath": ".prettierrc"

// Vetur
"vetur.format.defaultFormatter.html": "js-beautify-html",
"vetur.format.defaultFormatterOptions": {
	"prettier": {
		"singleQuote": true
	}
}
```

## Help

> Vue.js documentation help.

- [Transitions](https://vuejs.org/v2/guide/transitions.html#Transitions-on-Initial-Render)
