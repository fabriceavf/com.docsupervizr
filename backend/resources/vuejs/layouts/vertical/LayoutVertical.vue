<template>
  <layout-vertical>

    <router-view />

<!--    <template #navbar>-->
<!--      <span>My custom content</span>-->
<!--    </template>-->

    <!-- <app-customizer
      v-if="showCustomizer"
      slot="customizer"
    /> -->
  </layout-vertical>
</template>

<script>
import LayoutVertical from '@core/layouts/layout-vertical/LayoutVertical.vue'
// import AppCustomizer from '@core/layouts/components/app-customizer/AppCustomizer.vue'
// import { $themeConfig } from '@themeConfig'
import Navbar from '../components/Navbar.vue'

export default {
  components: {
    // AppCustomizer,
    LayoutVertical,
    Navbar,
  },
  data() {
    return {
      // showCustomizer: $themeConfig.layout.customizer,
    }
  },
}
</script>

<style>
#app{
  height: 100% !important;
  display: block;
  align-items: center;
  justify-content: center;
}
</style>
