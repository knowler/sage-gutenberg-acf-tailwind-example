const mix = require('laravel-mix')

/**
 * Plugins
 */
require('laravel-mix-purgecss')

/**
 * Helpers
 */

// Public path helper
const publicPath = path => `${mix.config.publicPath}/${path}`

// Source path helper
const src = path => `resources/assets/${path}`

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Sage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

mix
  .setPublicPath('./dist')
  .setResourceRoot(`/app/themes/sage/${mix.config.publicPath}/`)
  .webpackConfig({
    output: { publicPath: mix.config.resourceRoot },
  })
  .browserSync('sage-block-builder-example.test')

/**
 * Styles
 */

// Common PostCSS plugins
const postCssPlugins = [
  require('postcss-import')(),
  require('tailwindcss')(),
  require('postcss-preset-env')({ stage: 0 }),
]

// CSS configuration
mix
  .postCss(src`styles/app.css`, 'styles', postCssPlugins)
  .postCss(src`styles/editor.css`, 'styles', [
    ...postCssPlugins,
    require('postcss-wrap')({
      selector: '.acf-block-preview',
      skip: /acf-block-preview/,
    }),
  ])
  .purgeCss({
    content: [
      './resources/assets/**/*.js',
      './resources/views/**/*.php',
      './resources/fields/controls/**/*.php',
    ],
    defaultExtractor: content => content.match(/[A-Za-z0-9-_:/]+/g || []),
    whitelistPatterns: [
      /acf-block-preview/,
    ],
  })
  .options({ processCssUrls: false })

/**
 * Scripts
 */
mix
  .js(src`scripts/app.js`, 'scripts')
  .extract()

/**
 * Assets
 */
mix
  .copyDirectory(src`images`, publicPath`images`)
  .copyDirectory(src`fonts`, publicPath`fonts`)

/**
 * Environment specifics
 */

// Source maps when not in production.
mix.sourceMaps(false, 'source-map')

// Hash and version files in production.
mix.version()
