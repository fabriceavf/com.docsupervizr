import {$themeBreakpoints} from '@themeConfig'

export default {
    namespaced: true,
    state: {
        windowWidth: 0,
        shallShowOverlay: false,
        apiUrl: '',
    },
    getters: {
        currentBreakPoint: state => {
            const {windowWidth} = state
            if (windowWidth >= $themeBreakpoints.xl) return 'xl'
            if (windowWidth >= $themeBreakpoints.lg) return 'lg'
            if (windowWidth >= $themeBreakpoints.md) return 'md'
            if (windowWidth >= $themeBreakpoints.sm) return 'sm'
            return 'xs'
        },
        apiUrl(state) {
            return state.apiUrl
        },
    },
    mutations: {
        UPDATE_WINDOW_WIDTH(state, val) {
            state.windowWidth = val
        },
        TOGGLE_OVERLAY(state, val) {
            state.shallShowOverlay = val !== undefined ? val : !state.shallShowOverlay
        },
    },
    actions: {},
}
