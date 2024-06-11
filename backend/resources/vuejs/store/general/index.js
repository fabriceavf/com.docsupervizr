export default {
    namespaced: true,
    state: {

            isLoading: false,
            authenticated: false,
            token: '',
            userData: {},
            apiFirstheberg: 'http://vps-77244.fhnet.fr/zkbiotime/api',
            // api_url: 'https://sgs.supervizr.net',
            // api_url: 'https://sgs.supervizr.app',
            // api_url: 'https://cleanafrica.supervizr.app',w
            api_url: 'http://127.0.0.1:8000',
            _pointages: {},



    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        userData(state) {
            return JSON.parse(localStorage.getItem('userData'))
        },
        apiUrl(state) {
            let  host = window.location.protocol + "//" + window.location.host;
            if(!host){
                host=state.api_url
            }
            return host
        },
        pointages(state) {
            return state._pointages
        },
        getToken(state) {
            return state.api_url
        },
        hs(state, programme_id) {
            let point = Object.values(state._pointages)
            return point.filter(data => parseInt(data.programme_id) == parseInt(programme_id))
        }
    },
    mutations: {
        setAuthenticated(state, value) {
            state.authenticated = true
            state.userData = value
            localStorage.setItem('user', JSON.stringify(value))
        },
        setPointage(state, pointage) {
            let id = pointage.id
            let data = {...pointage}
            console.log('on met a jour le pointage depuis le store', pointage.id, '===>', data)

            state._pointages[id] = data

        },
        setToken(state, value) {
            state.token = value
            // this.axios.defaults.headers.common.Authorization = `Bearer ${value}`
        },
        setIsLoading(state, value) {
            state.isLoading = value
        },
        setUserData(state, value) {
            localStorage.setItem('userData', JSON.stringify(value))
            state.userData = value
        },
        clearUserData(state) {
            state.authenticated = false
            state.userData = {}
            localStorage.removeItem('user')
            location.reload()
        }
    },
    actions: {},
    modules: {},
}
