<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('ref')" class="form-group">
          <label>ref </label>
          <input v-model="form.ref" class="form-control"
                 type="text">

          <div v-if="errors.ref" class='div-error' show variant="danger">
            {{ errors.ref }}
          </div>
        </div>


        <div v-if="canShowFilter('libelle')" class="form-group">
          <label>libelle </label>
          <input v-model="form.libelle" class="form-control"
                 type="text">

          <div v-if="errors.libelle" class='div-error' show variant="danger">
            {{ errors.libelle }}
          </div>
        </div>


        <div v-if="canShowFilter('lat')" class="form-group">
          <label>lat </label>
          <input v-model="form.lat" class="form-control"
                 type="text">

          <div v-if="errors.lat" class='div-error' show variant="danger">
            {{ errors.lat }}
          </div>
        </div>


        <div v-if="canShowFilter('lng')" class="form-group">
          <label>lng </label>
          <input v-model="form.lng" class="form-control"
                 type="text">

          <div v-if="errors.lng" class='div-error' show variant="danger">
            {{ errors.lng }}
          </div>
        </div>


        <div v-if="canShowFilter('course')" class="form-group">
          <label>course </label>
          <input v-model="form.course" class="form-control"
                 type="text">

          <div v-if="errors.course" class='div-error' show variant="danger">
            {{ errors.course }}
          </div>
        </div>


        <div v-if="canShowFilter('speed')" class="form-group">
          <label>speed </label>
          <input v-model="form.speed" class="form-control"
                 type="text">

          <div v-if="errors.speed" class='div-error' show variant="danger">
            {{ errors.speed }}
          </div>
        </div>


        <div v-if="canShowFilter('icon_color')" class="form-group">
          <label>icon_color </label>
          <input v-model="form.icon_color" class="form-control"
                 type="text">

          <div v-if="errors.icon_color" class='div-error' show variant="danger">
            {{ errors.icon_color }}
          </div>
        </div>


        <div v-if="canShowFilter('imei')" class="form-group">
          <label>imei </label>
          <input v-model="form.imei" class="form-control"
                 type="text">

          <div v-if="errors.imei" class='div-error' show variant="danger">
            {{ errors.imei }}
          </div>
        </div>


        <div v-if="canShowFilter('heure')" class="form-group">
          <label>heure </label>
          <input v-model="form.heure" class="form-control"
                 type="text">

          <div v-if="errors.heure" class='div-error' show variant="danger">
            {{ errors.heure }}
          </div>
        </div>


      </div>

      <button class="btn btn-primary" type="submit">
        <i class="fas fas fa-search"></i> Appliquer
      </button>
    </form>
  </b-overlay>
</template>

<script>
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
  name: 'FiltreBalises',
  components: {VSelect, Files},
  props: [
    'table',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        ref: "",

        libelle: "",

        lat: "",

        lng: "",

        course: "",

        speed: "",

        icon_color: "",

        imei: "",

        heure: "",

        created_at: "",

        updated_at: "",

        extra_attributes: "",

        deleted_at: "",
      }
    }
  },
  methods: {
    createLine() {
      this.$emit('applyfilter', this.form)
    },
    canShowFilter(name) {
      let can = true
      const queryString = window.location.search
      const urlParams = new URLSearchParams(queryString);
      if (urlParams.has(`filter_${name}`)) {
        can = false
      }
      return can
    }
  }
}
</script>
