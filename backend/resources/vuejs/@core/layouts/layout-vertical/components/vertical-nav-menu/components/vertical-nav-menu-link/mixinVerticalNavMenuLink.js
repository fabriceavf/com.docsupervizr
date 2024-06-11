export default {
  watch: {
    routeData: {
      immediate: true,
      handler() {
        this.updateIsActive()
      },
    },
  },
}
