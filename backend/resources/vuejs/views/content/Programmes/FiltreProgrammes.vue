<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('dimanche')" class="form-group">
          <label>dimanche </label>
          <input v-model="form.dimanche" class="form-control"
                 type="text">

          <div v-if="errors.dimanche" class='div-error' show variant="danger">
            {{ errors.dimanche }}
          </div>
        </div>


        <div v-if="canShowFilter('lundi')" class="form-group">
          <label>lundi </label>
          <input v-model="form.lundi" class="form-control"
                 type="text">

          <div v-if="errors.lundi" class='div-error' show variant="danger">
            {{ errors.lundi }}
          </div>
        </div>


        <div v-if="canShowFilter('mardi')" class="form-group">
          <label>mardi </label>
          <input v-model="form.mardi" class="form-control"
                 type="text">

          <div v-if="errors.mardi" class='div-error' show variant="danger">
            {{ errors.mardi }}
          </div>
        </div>


        <div v-if="canShowFilter('mercredi')" class="form-group">
          <label>mercredi </label>
          <input v-model="form.mercredi" class="form-control"
                 type="text">

          <div v-if="errors.mercredi" class='div-error' show variant="danger">
            {{ errors.mercredi }}
          </div>
        </div>


        <div v-if="canShowFilter('jeudi')" class="form-group">
          <label>jeudi </label>
          <input v-model="form.jeudi" class="form-control"
                 type="text">

          <div v-if="errors.jeudi" class='div-error' show variant="danger">
            {{ errors.jeudi }}
          </div>
        </div>


        <div v-if="canShowFilter('vendredi')" class="form-group">
          <label>vendredi </label>
          <input v-model="form.vendredi" class="form-control"
                 type="text">

          <div v-if="errors.vendredi" class='div-error' show variant="danger">
            {{ errors.vendredi }}
          </div>
        </div>


        <div v-if="canShowFilter('samedi')" class="form-group">
          <label>samedi </label>
          <input v-model="form.samedi" class="form-control"
                 type="text">

          <div v-if="errors.samedi" class='div-error' show variant="danger">
            {{ errors.samedi }}
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


        <div v-if="canShowFilter('actif')" class="form-group">
          <label>actif </label>
          <input v-model="form.actif" class="form-control"
                 type="text">

          <div v-if="errors.actif" class='div-error' show variant="danger">
            {{ errors.actif }}
          </div>
        </div>


        <div class="form-group">
          <label>programmations </label>
          <v-select
              v-model="form.programmation_id"
              :options="programmationsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
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
  name: 'FiltreProgrammes',
  components: {VSelect, Files},
  props: [
    'table',
    'programmationsData',
    'tachesData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        dimanche: "",

        lundi: "",

        mardi: "",

        mercredi: "",

        jeudi: "",

        vendredi: "",

        samedi: "",

        statut: "",

        actif: "",

        tache_id: "",

        programmation_id: "",

        user_id: "",

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
