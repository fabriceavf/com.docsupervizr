<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('permission')" class="form-group">
          <label>permission </label>
          <input v-model="form.permission" class="form-control"
                 type="text">

          <div v-if="errors.permission" class='div-error' show variant="danger">
            {{ errors.permission }}
          </div>
        </div>


        <div v-if="canShowFilter('nom')" class="form-group">
          <label>nom </label>
          <input v-model="form.nom" class="form-control"
                 type="text">

          <div v-if="errors.nom" class='div-error' show variant="danger">
            {{ errors.nom }}
          </div>
        </div>


        <div v-if="canShowFilter('prenom')" class="form-group">
          <label>prenom </label>
          <input v-model="form.prenom" class="form-control"
                 type="text">

          <div v-if="errors.prenom" class='div-error' show variant="danger">
            {{ errors.prenom }}
          </div>
        </div>


        <div v-if="canShowFilter('type')" class="form-group">
          <label>type </label>
          <input v-model="form.type" class="form-control"
                 type="text">

          <div v-if="errors.type" class='div-error' show variant="danger">
            {{ errors.type }}
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
  name: 'FiltrePerms',
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

        permission: "",

        user_id: "",

        nom: "",

        prenom: "",

        type: "",
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
