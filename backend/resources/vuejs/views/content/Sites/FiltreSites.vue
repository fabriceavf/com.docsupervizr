<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('libelle')" class="form-group">
          <label>libelle </label>
          <input v-model="form.libelle" class="form-control"
                 type="text">

          <div v-if="errors.libelle" class='div-error' show variant="danger">
            {{ errors.libelle }}
          </div>
        </div>


        <div class="form-group">
          <label>clients </label>
          <v-select
              v-model="form.client_id"
              :options="clientsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>zones </label>
          <v-select
              v-model="form.zone_id"
              :options="zonesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
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
  name: 'FiltreSites',
  components: {VSelect, Files},
  props: [
    'table',
    'clientsData',
    'zonesData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        libelle: "",

        client_id: "",

        zone_id: "",

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
