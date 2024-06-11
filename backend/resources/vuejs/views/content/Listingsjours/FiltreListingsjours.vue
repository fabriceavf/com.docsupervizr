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


        <div v-if="canShowFilter('date')" class="form-group">
          <label>date </label>
          <input v-model="form.date" class="form-control"
                 type="date">

          <div v-if="errors.date" class='div-error' show variant="danger">
            {{ errors.date }}
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
  name: 'FiltreListingsjours',
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

        libelle: "",

        date: "",

        extra_attributes: "",

        created_at: "",

        updated_at: "",

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
