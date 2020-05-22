// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.

import { ApolloClient } from 'apollo-client'
import { HttpLink } from 'apollo-link-http'
import { InMemoryCache } from 'apollo-cache-inmemory'
import VueApollo from 'vue-apollo'

import Vue from 'vue'
import App from './App'
import router from './router'
import { i18n } from '@/plugins/i18n'
import { Trans } from './plugins/Translation'
import vuetify from '@/plugins/vuetify' // path to vuetify expor
// import Vuetify from 'vuetify'
// import LoadScript from 'vue-plugin-load-script'
import VueYoutube from 'vue-youtube'
// import './stylus/main.styl'
import 'vuetify/dist/vuetify.min.css'

import 'material-design-icons-iconfont/dist/material-design-icons.css'
// import colors from 'vuetify/es5/util/colors'
import { Icon } from 'leaflet'
import 'leaflet/dist/leaflet.css'
import VueAnalytics from 'vue-analytics'

import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'

import Vuex from 'vuex'
import ReactiveSearch from '@appbaseio/reactivesearch-vue'

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)

// import GlossaryDialog from '@/components/GlossaryDialog'

// Vue.component('glossary-dialog', GlossaryDialog)

Vue.use(Vuex)

Vue.use(ReactiveSearch)

const store = new Vuex.Store({
  state: {
    woa_list_view: false,
    archive: {
      url: 'p!1'
    }
  },
  mutations: {
    setArchiveUrl (state, value) {
      state.archive.url = value
    }
  }
})

// this part resolve an issue where the markers would not appear
delete Icon.Default.prototype._getIconUrl

Icon.Default.mergeOptions({
  iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
  iconUrl: require('leaflet/dist/images/marker-icon.png'),
  shadowUrl: require('leaflet/dist/images/marker-shadow.png')
})

/*
Vue.mixin({
  methods: {
    isValidFilename: function (str) {
      if (typeof str === 'undefined') return false
      str = String(str)
      str = str.trim()
      if (str === '') return false
      if (str === null) return false
      if (str === 'null') return false
      if (str === 'n/a') return false
      return true
    }
  }
})
*/

Vue.use(VueYoutube)
// Vue.use(LoadScript)
// Vue.loadScript('https://w.soundcloud.com/player/api.js')

Vue.prototype.$i18nRoute = Trans.i18nRoute.bind(Trans)

Vue.config.productionTip = false
/*
Vue.use(WebFontLoader)
WebFontLoader.load({
  custom: {
    families: ['Rubik:300,400,500,700:latin-ext']
  }
})
*/
// console.log(process.env.NODE_ENV)
// console.log('weserv: ' + process.env.VUE_APP_USE_WESERV)

if (process.env.VUE_APP_GA !== '0') {
  Vue.use(VueAnalytics, {
    id: process.env.VUE_APP_GA
  })
}

const httpLink = new HttpLink({
  uri: process.env.VUE_APP_GQL_API_ENDPOINT
})

// console.log(NODE_ENV)
// console.log(process.env.VUE_APP_GQL_API_ENDPOINT)

const apolloClient = new ApolloClient({
  link: httpLink,
  cache: new InMemoryCache(),
  connectToDevTools: true
})

Vue.use(VueApollo)

const apolloProvider = new VueApollo({
  defaultClient: apolloClient,
  defaultOptions: {
    $loadingKey: 'loading'
  }
})

/* eslint-disable no-new */
new Vue({
  // mixins: [mixin],
  el: '#app',
  store,
  provide: apolloProvider.provide(),
  router,
  i18n,
  vuetify,
  render: (h) => h(App)
})
