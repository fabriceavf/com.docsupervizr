<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('avant')" class="form-group">
          <label>avant </label>
          <input v-model="form.avant" class="form-control"
                 type="text">

          <div v-if="errors.avant" class='div-error' show variant="danger">
            {{ errors.avant }}
          </div>
        </div>


        <div v-if="canShowFilter('apres')" class="form-group">
          <label>apres </label>
          <input v-model="form.apres" class="form-control"
                 type="text">

          <div v-if="errors.apres" class='div-error' show variant="danger">
            {{ errors.apres }}
          </div>
        </div>


        <div v-if="canShowFilter('attribut')" class="form-group">
          <label>attribut </label>
          <input v-model="form.attribut" class="form-control"
                 type="text">

          <div v-if="errors.attribut" class='div-error' show variant="danger">
            {{ errors.attribut }}
          </div>
        </div>


        <div class="form-group">
          <label>users </label>
          <v-select
              v-model="form.user_id"
              :options="usersData"
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
  name: 'FiltreEcouteurs',
  components: {VSelect, Files},
  props: [
    'table',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        avant: "",

        apres: "",

        attribut: "",

        created_at: "",

        updated_at: "",

        agent_id: "",

        user_id: "",

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
