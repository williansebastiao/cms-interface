# Interface

> Esse projeto utiliza os componentes do [Buefy](https://buefy.org/documentation), framework para Vue.js baseado no [Bulma](https://bulma.io/documentation/), verifique a documentação de ambos antes de criar novos componentes ou escrever CSS.

## Desenvolvimento

> Utilize o [yarn](https://yarnpkg.com/) como package manager padrão.

```js
yarn install // to install project dependencies
```

cp .env.example .env

```js
yarn run serve
// to start development with compiles and hot-reloads
```

```js
yarn run build
// to compiles and minifies for production
```

## Testes

> Executar os testes da aplicação

```js
yarn run test // Executar os testes
```

```js
yarn run lint // Testar e corrigir os arquivos
```

## Plugins

> Lista com todos os plugins e dependências externas instaladas no projeto.
> Antes de instalar novas dependências, verifique se é necessário.

-   [Axios](https://github.com/axios/axios)
-   [Buefy](https://buefy.org/documentation)
-   [MD Icons](https://materialdesignicons.com/)
-   [Password Meter](https://miladd3.github.io/vue-simple-password-meter/)
-   [Vue Tour](https://github.com/pulsardev/vue-tour)
-   [Vee Validade](https://logaretm.github.io/vee-validate/)

## Editor

> Extensões e configurações necessárias para inserir em seu editor e manter a qualidade do código. Nós usamos e recomendamos sempre o [Visual Studio Code](https://code.visualstudio.com/).

### Extensões

> Instale as extensões abaixo.

-   [EditorConfig](https://marketplace.visualstudio.com/items?itemName=EditorConfig.EditorConfig)
-   [Prettier](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode)
-   [Vetur](https://marketplace.visualstudio.com/items?itemName=octref.vetur)

### Configurações

> Edite o seu `settings.json` onem `File > Preferences > Settings` ou pressione `ctrl + ,` para abrir e atualize o arquivo com essas configurações.

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

> Documentações do Vue.js e outros módulos úteis.

-   [Vue.js](https://v3.vuejs.org/guide/introduction.html#what-is-vue-js)
-   [Transitions](https://vuejs.org/v2/guide/transitions.html#Transitions-on-Initial-Render)
