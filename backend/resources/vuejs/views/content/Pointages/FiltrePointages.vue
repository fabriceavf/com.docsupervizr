<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('pointeuse')" class="form-group">
          <label>pointeuse </label>
          <input v-model="form.pointeuse" class="form-control"
                 type="text">

          <div v-if="errors.pointeuse" class='div-error' show variant="danger">
            {{ errors.pointeuse }}
          </div>
        </div>


        <div v-if="canShowFilter('lieu')" class="form-group">
          <label>lieu </label>
          <input v-model="form.lieu" class="form-control"
                 type="text">

          <div v-if="errors.lieu" class='div-error' show variant="danger">
            {{ errors.lieu }}
          </div>
        </div>


        <div v-if="canShowFilter('debut_prevu')" class="form-group">
          <label>debut_prevu </label>
          <input v-model="form.debut_prevu" class="form-control"
                 type="text">

          <div v-if="errors.debut_prevu" class='div-error' show variant="danger">
            {{ errors.debut_prevu }}
          </div>
        </div>


        <div v-if="canShowFilter('fin_prevu')" class="form-group">
          <label>fin_prevu </label>
          <input v-model="form.fin_prevu" class="form-control"
                 type="text">

          <div v-if="errors.fin_prevu" class='div-error' show variant="danger">
            {{ errors.fin_prevu }}
          </div>
        </div>


        <div v-if="canShowFilter('faction_horaire')" class="form-group">
          <label>faction_horaire </label>
          <input v-model="form.faction_horaire" class="form-control"
                 type="text">

          <div v-if="errors.faction_horaire" class='div-error' show variant="danger">
            {{ errors.faction_horaire }}
          </div>
        </div>


        <div v-if="canShowFilter('debut_reel')" class="form-group">
          <label>debut_reel </label>
          <input v-model="form.debut_reel" class="form-control"
                 type="text">

          <div v-if="errors.debut_reel" class='div-error' show variant="danger">
            {{ errors.debut_reel }}
          </div>
        </div>


        <div v-if="canShowFilter('debut_realise')" class="form-group">
          <label>debut_realise </label>
          <input v-model="form.debut_realise" class="form-control"
                 type="text">

          <div v-if="errors.debut_realise" class='div-error' show variant="danger">
            {{ errors.debut_realise }}
          </div>
        </div>


        <div v-if="canShowFilter('fin_realise')" class="form-group">
          <label>fin_realise </label>
          <input v-model="form.fin_realise" class="form-control"
                 type="text">

          <div v-if="errors.fin_realise" class='div-error' show variant="danger">
            {{ errors.fin_realise }}
          </div>
        </div>


        <div v-if="canShowFilter('volume_realise')" class="form-group">
          <label>volume_realise </label>
          <input v-model="form.volume_realise" class="form-control"
                 type="text">

          <div v-if="errors.volume_realise" class='div-error' show variant="danger">
            {{ errors.volume_realise }}
          </div>
        </div>


        <div v-if="canShowFilter('emp_code')" class="form-group">
          <label>emp_code </label>
          <input v-model="form.emp_code" class="form-control"
                 type="text">

          <div v-if="errors.emp_code" class='div-error' show variant="danger">
            {{ errors.emp_code }}
          </div>
        </div>


        <div v-if="canShowFilter('motif')" class="form-group">
          <label>motif </label>
          <input v-model="form.motif" class="form-control"
                 type="text">

          <div v-if="errors.motif" class='div-error' show variant="danger">
            {{ errors.motif }}
          </div>
        </div>


        <div v-if="canShowFilter('volume_prevu')" class="form-group">
          <label>volume_prevu </label>
          <input v-model="form.volume_prevu" class="form-control"
                 type="text">

          <div v-if="errors.volume_prevu" class='div-error' show variant="danger">
            {{ errors.volume_prevu }}
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


        <div v-if="canShowFilter('est_valide')" class="form-group">
          <label>est_valide </label>
          <input v-model="form.est_valide" class="form-control"
                 type="text">

          <div v-if="errors.est_valide" class='div-error' show variant="danger">
            {{ errors.est_valide }}
          </div>
        </div>


        <div v-if="canShowFilter('tolerance')" class="form-group">
          <label>tolerance </label>
          <input v-model="form.tolerance" class="form-control"
                 type="text">

          <div v-if="errors.tolerance" class='div-error' show variant="danger">
            {{ errors.tolerance }}
          </div>
        </div>


        <div v-if="canShowFilter('est_attendu')" class="form-group">
          <label>est_attendu </label>
          <input v-model="form.est_attendu" class="form-control"
                 type="text">

          <div v-if="errors.est_attendu" class='div-error' show variant="danger">
            {{ errors.est_attendu }}
          </div>
        </div>


        <div v-if="canShowFilter('etats')" class="form-group">
          <label>etats </label>
          <input v-model="form.etats" class="form-control"
                 type="text">

          <div v-if="errors.etats" class='div-error' show variant="danger">
            {{ errors.etats }}
          </div>
        </div>


        <div class="form-group">
          <label>horaires </label>
          <v-select
              v-model="form.horaire_id"
              :options="horairesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>programmes </label>
          <v-select
              v-model="form.programme_id"
              :options="programmesData"
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
  name: 'FiltrePointages',
  components: {VSelect, Files},
  props: [
    'table',
    'horairesData',
    'programmesData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        pointeuse: "",

        lieu: "",

        debut_prevu: "",

        fin_prevu: "",

        faction_horaire: "",

        debut_reel: "",

        debut_realise: "",

        fin_realise: "",

        volume_realise: "",

        emp_code: "",

        motif: "",

        volume_prevu: "",

        actif: "",

        est_valide: "",

        horaire_id: "",

        programme_id: "",

        tolerance: "",

        est_attendu: "",

        etats: "",

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
