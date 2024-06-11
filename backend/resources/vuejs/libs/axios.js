import store from "@/store"
import axios from 'axios'
import $ from 'jquery'

let code=$("meta[name='csrf-token']").attr('content')
let testApiCode=$("meta[name='test-api-token']").attr('content')
const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  baseURL: store.getters['general/apiUrl'],
  // timeout: 1000,
  headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': code,
      'Authorization'  :'Bearer '+testApiCode
  }
})
console.log('voici le store',testApiCode)
// Vue.prototype.$http = axiosIns
// axiosIns.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// axiosIns.defaults.headers.common['X-CSRF-TOKEN'] = code;
// axiosIns.defaults.headers.common['Accept'] = 'application/json';
// axiosIns.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// axiosIns.defaults.withCredentials = true;
export default axiosIns
