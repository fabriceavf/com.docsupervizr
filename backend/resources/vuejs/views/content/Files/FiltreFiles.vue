<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('old_name')" class="form-group">
          <label>old_name </label>
          <input v-model="form.old_name" class="form-control"
                 type="text">

          <div v-if="errors.old_name" class='div-error' show variant="danger">
            {{ errors.old_name }}
          </div>
        </div>


        <div v-if="canShowFilter('new_name')" class="form-group">
          <label>new_name </label>
          <input v-model="form.new_name" class="form-control"
                 type="text">

          <div v-if="errors.new_name" class='div-error' show variant="danger">
            {{ errors.new_name }}
          </div>
        </div>


        <div v-if="canShowFilter('descriptions')" class="form-group">
          <label>descriptions </label>
          <input v-model="form.descriptions" class="form-control"
                 type="text">

          <div v-if="errors.descriptions" class='div-error' show variant="danger">
            {{ errors.descriptions }}
          </div>
        </div>


        <div v-if="canShowFilter('extensions')" class="form-group">
          <label>extensions </label>
          <input v-model="form.extensions" class="form-control"
                 type="text">

          <div v-if="errors.extensions" class='div-error' show variant="danger">
            {{ errors.extensions }}
          </div>
        </div>


        <div v-if="canShowFilter('size')" class="form-group">
          <label>size </label>
          <input v-model="form.size" class="form-control"
                 type="text">

          <div v-if="errors.size" class='div-error' show variant="danger">
            {{ errors.size }}
          </div>
        </div>


        <div v-if="canShowFilter('path')" class="form-group">
          <label>path </label>
          <input v-model="form.path" class="form-control"
                 type="text">

          <div v-if="errors.path" class='div-error' show variant="danger">
            {{ errors.path }}
          </div>
        </div>


        <div v-if="canShowFilter('web_path')" class="form-group">
          <label>web_path </label>
          <input v-model="form.web_path" class="form-control"
                 type="text">

          <div v-if="errors.web_path" class='div-error' show variant="danger">
            {{ errors.web_path }}
          </div>
        </div>


        <div v-if="canShowFilter('statut')" class="form-group">
          <label>statut </label>
          <input v-model="form.statut" class="form-control"
                 type="text">

          <div v-if="errors.statut" class='div-error' show variant="danger">
            {{ errors.statut }}
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
  name: 'FiltreFiles',
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

        old_name: "",

        new_name: "",

        descriptions: "",

        extensions: "",

        size: "",

        path: "",

        web_path: "",

        statut: "",

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
