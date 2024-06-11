import { $themeBreakpoints } from '@themeConfig'

export default {
  watch: {
    routeData() {
      if (this.$store.state.app.windowWidth < $themeBreakpoints.xl) {
        this.isVerticalMenuActive = false
      }
    },
  },
}
