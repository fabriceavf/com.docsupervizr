<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('code')" class="form-group">
          <label>code </label>
          <input v-model="form.code" class="form-control"
                 type="text">

          <div v-if="errors.code" class='div-error' show variant="danger">
            {{ errors.code }}
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


        <div v-if="canShowFilter('contrat')" class="form-group">
          <label>contrat </label>
          <input v-model="form.contrat" class="form-control"
                 type="text">

          <div v-if="errors.contrat" class='div-error' show variant="danger">
            {{ errors.contrat }}
          </div>
        </div>


        <div v-if="canShowFilter('nature')" class="form-group">
          <label>nature </label>
          <input v-model="form.nature" class="form-control"
                 type="text">

          <div v-if="errors.nature" class='div-error' show variant="danger">
            {{ errors.nature }}
          </div>
        </div>


        <div v-if="canShowFilter('coordonnees')" class="form-group">
          <label>coordonnees </label>
          <input v-model="form.coordonnees" class="form-control"
                 type="text">

          <div v-if="errors.coordonnees" class='div-error' show variant="danger">
            {{ errors.coordonnees }}
          </div>
        </div>


        <div class="form-group">
          <label>pointeuses </label>
          <v-select
              v-model="form.pointeuse_id"
              :options="pointeusesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>sites </label>
          <v-select
              v-model="form.site_id"
              :options="sitesData"
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
  name: 'FiltrePostes',
  components: {VSelect, Files},
  props: [
    'table',
    'pointeusesData',
    'sitesData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        code: "",

        libelle: "",

        contrat: "",

        nature: "",

        coordonnees: "",

        site_id: "",

        pointeuse_id: "",

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
