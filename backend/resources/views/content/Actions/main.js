import Vue from 'vue'
import {BootstrapVue, IconsPlugin, ModalPlugin, ToastPlugin} from 'bootstrap-vue'
import VueCompositionAPI from '@vue/composition-api'
import {LicenseManager} from 'ag-grid-enterprise'
import axios from '@/libs/axios'
import VueAxios from 'vue-axios'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'vue-toast-notification/dist/theme-sugar.css'
import "vue-select/dist/vue-select.css"
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
import store from '@/store'
import App from './ActionsView.vue'

import '@/libs/toastification'

LicenseManager.setLicenseKey('For_Production-Valid_Until-22_May_2024_[v29]_MTYyMTYzODAwMDAwMA==edd463c08734ce415741e4c2b8ade1f5')


// BSV Plugin Registration
Vue.use(ModalPlugin)
// Composition API
Vue.use(VueCompositionAPI)
Vue.use(ToastPlugin)
Vue.config.productionTip = false
Vue.use(VueAxios, axios)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.config.productionTip = false

new Vue({
    store,
    render: h => h(App),
}).$mount('#app')
