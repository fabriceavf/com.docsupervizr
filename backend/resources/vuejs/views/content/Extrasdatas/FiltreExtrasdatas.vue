<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('cle')" class="form-group">
          <label>cle </label>
          <input v-model="form.cle" class="form-control"
                 type="text">

          <div v-if="errors.cle" class='div-error' show variant="danger">
            {{ errors.cle }}
          </div>
        </div>


        <div v-if="canShowFilter('valeur')" class="form-group">
          <label>valeur </label>
          <input v-model="form.valeur" class="form-control"
                 type="text">

          <div v-if="errors.valeur" class='div-error' show variant="danger">
            {{ errors.valeur }}
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
  name: 'FiltreExtrasdatas',
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

        cle: "",

        valeur: "",

        extra_attributes: "",

        created_at: "",

        updated_at: "",
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
