import Vue from 'vue'
import { ToastPlugin, ModalPlugin, BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueCompositionAPI from '@vue/composition-api'
import { LicenseManager } from 'ag-grid-enterprise'
LicenseManager.setLicenseKey('For_Production-Valid_Until-22_May_2024_[v29]_MTYyMTYzODAwMDAwMA==edd463c08734ce415741e4c2b8ade1f5')
import axios from '@/libs/axios'
import VueAxios from 'vue-axios'
import VueToast from 'vue-toast-notification'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'vue-toast-notification/dist/theme-sugar.css'
import "vue-select/dist/vue-select.css"
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
import router from './router'
import store from './store'
import App from './App.vue'
import i18n from '@/libs/i18n'
import '@/libs/acl'
import '@/libs/portal-vue'
import '@/libs/clipboard'
import '@/libs/toastification'
import '@/libs/sweet-alerts'
import '@/libs/vue-select'
import '@/libs/tour'

// Global Components
import './global-components'
// 3rd party plugins
import '@/libs/portal-vue'
import '@/libs/toastification'

// BSV Plugin Registration
Vue.use(ToastPlugin)
Vue.use(ModalPlugin)

// Composition API
Vue.use(VueCompositionAPI)

// axios.defaults.baseURL = store.getters.apiUrl

// axios.defaults.baseURL = 'https://backend.cleanafrica.supervizr.net'

Vue.use(ToastPlugin)
Vue.config.productionTip = false
Vue.use(VueAxios, axios)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueToast, {
  position: 'bottom-right',
  duration: 6000
})


// import core styles
require('@core/scss/core.scss')

// import assets styles
require('@/assets/scss/style.scss')

Vue.config.productionTip = false

new Vue({
  router,
  store,i18n,
  render: h => h(App),
}).$mount('#app')
