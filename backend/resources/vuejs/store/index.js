import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersistence from 'vuex-persist'
import Cookies from 'js-cookie'
// Modules
import general from './general'

const vuexLocal = new VuexPersistence({
    storage: window.localStorage,
    saveState: (key, state, storage) =>
        Cookies.set(key, state, {
            expires: 3
        }),
})

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        general,
    },
    // strict: process.env.DEV,
})
