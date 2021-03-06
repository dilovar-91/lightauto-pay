require('dotenv').config()
import webpack from 'webpack'
const { join } = require('path')
const { copySync, removeSync } = require('fs-extra')

module.exports = {
  mode: 'spa', // Comment this for SSR

  srcDir: __dirname,

  server: {
    port: process.env.APP_PORT || 9000, // default: 3000
    //host: '0.0.0.0' // default: localhost
  },
  env: {
    apiUrl: process.env.API_URL || process.env.APP_URL + '/api',
    appName: process.env.APP_NAME || 'Laravel Nuxt',
    appLocale: process.env.APP_LOCALE || 'en',
    githubAuth: !!process.env.GITHUB_CLIENT_ID
  },

  head: {
    title: process.env.APP_NAME,
    titleTemplate: '%s - ' + process.env.APP_NAME,
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Nuxt.js project' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  loading: { color: '#007bff' },

  router: {
    middleware: ['locale', 'check-auth']
  },

  css: [
    { src: '~assets/sass/app.scss', lang: 'scss' }
  ],

  plugins: [
    '~components/global',
    '~plugins/i18n',
    '~plugins/vform',
    '~plugins/axios',
    '~plugins/fontawesome',
    '~plugins/nuxt-client-init', // Comment this for SSR
    { src: '~plugins/bootstrap', mode: 'client' },
    { src: '~plugins/element-ui', ssr: true },
    { src: '~plugins/dropzone', mode: 'client' },
    { src: '@/plugins/the-vue-mask', mode: 'client' }
  ],

  modules: [
    '@nuxtjs/router',
    '@nuxtjs/axios',
  ],

  axios: {
    // extra config e.g
    BaseURL: process.env.API_URL,
    requestInterceptor: (config, { store }) => {
      config.headers.common['Authorization'] = 'Bearer ' + store.state.token
      return config
    }
  },

  build: {
    extractCSS: true,
    plugins: [
      new webpack.ProvidePlugin({
        // global modules
        //$: 'jquery',
        _: 'lodash'
      })
    ]
  },

  hooks: {
    generate: {
      done(generator) {
        // Copy dist files to public/_nuxt
        if (generator.nuxt.options.dev === false && generator.nuxt.options.mode === 'spa') {
          const publicDir = join(generator.nuxt.options.rootDir, 'public', '_nuxt')
          removeSync(publicDir)
          copySync(join(generator.nuxt.options.generate.dir, '_nuxt'), publicDir)
          copySync(join(generator.nuxt.options.generate.dir, '200.html'), join(publicDir, 'index.html'))
          removeSync(generator.nuxt.options.generate.dir)
        }
      }
    }
  }
}
