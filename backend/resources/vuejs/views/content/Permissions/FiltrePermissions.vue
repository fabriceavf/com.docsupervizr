<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('name')" class="form-group">
          <label>name </label>
          <input v-model="form.name" class="form-control"
                 type="text">

          <div v-if="errors.name" class='div-error' show variant="danger">
            {{ errors.name }}
          </div>
        </div>


        <div v-if="canShowFilter('guard_name')" class="form-group">
          <label>guard_name </label>
          <input v-model="form.guard_name" class="form-control"
                 type="text">

          <div v-if="errors.guard_name" class='div-error' show variant="danger">
            {{ errors.guard_name }}
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
  name: 'FiltrePermissions',
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

        name: "",

        guard_name: "",

        created_at: "",

        updated_at: "",

        deleted_at: "",

        extra_attributes: "",
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
