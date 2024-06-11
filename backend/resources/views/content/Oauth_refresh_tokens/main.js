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
import App from './Oauth_refresh_tokensView.vue'
import '@/libs/toastification'
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

LicenseManager.setLicenseKey(import.meta.env.VITE_AGGRID_LICENCE_KEY)

let pusherConfig = {
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: false,
    wsHost: import.meta.env.VITE_PUSHER_APP_PUBLIC_SERVER,
    wsPort: import.meta.env.VITE_PUSHER_APP_PUBLIC_PORT
}
window.Pusher = Pusher;
window.Echo = new Echo(pusherConfig);

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
