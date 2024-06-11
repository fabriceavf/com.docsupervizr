<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('semaine')" class="form-group">
          <label>semaine </label>
          <input v-model="form.semaine" class="form-control"
                 type="text">

          <div v-if="errors.semaine" class='div-error' show variant="danger">
            {{ errors.semaine }}
          </div>
        </div>


        <div v-if="canShowFilter('date_debut')" class="form-group">
          <label>date_debut </label>
          <input v-model="form.date_debut" class="form-control"
                 type="date">

          <div v-if="errors.date_debut" class='div-error' show variant="danger">
            {{ errors.date_debut }}
          </div>
        </div>


        <div v-if="canShowFilter('date_fin')" class="form-group">
          <label>date_fin </label>
          <input v-model="form.date_fin" class="form-control"
                 type="date">

          <div v-if="errors.date_fin" class='div-error' show variant="danger">
            {{ errors.date_fin }}
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


        <div class="form-group">
          <label>taches </label>
          <v-select
              v-model="form.tache_id"
              :options="tachesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
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
  name: 'FiltreProgrammations',
  components: {VSelect, Files},
  props: [
    'table',
    'tachesData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        semaine: "",

        date_debut: "",

        date_fin: "",

        user_id: "",

        tache_id: "",

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
