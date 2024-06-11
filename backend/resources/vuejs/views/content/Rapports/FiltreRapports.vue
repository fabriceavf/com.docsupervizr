<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('mois')" class="form-group">
          <label>mois </label>
          <input v-model="form.mois" class="form-control"
                 type="text">

          <div v-if="errors.mois" class='div-error' show variant="danger">
            {{ errors.mois }}
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


        <div v-if="canShowFilter('matricule')" class="form-group">
          <label>matricule </label>
          <input v-model="form.matricule" class="form-control"
                 type="text">

          <div v-if="errors.matricule" class='div-error' show variant="danger">
            {{ errors.matricule }}
          </div>
        </div>


        <div v-if="canShowFilter('day_01')" class="form-group">
          <label>day_01 </label>
          <input v-model="form.day_01" class="form-control"
                 type="text">

          <div v-if="errors.day_01" class='div-error' show variant="danger">
            {{ errors.day_01 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_02')" class="form-group">
          <label>day_02 </label>
          <input v-model="form.day_02" class="form-control"
                 type="text">

          <div v-if="errors.day_02" class='div-error' show variant="danger">
            {{ errors.day_02 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_03')" class="form-group">
          <label>day_03 </label>
          <input v-model="form.day_03" class="form-control"
                 type="text">

          <div v-if="errors.day_03" class='div-error' show variant="danger">
            {{ errors.day_03 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_04')" class="form-group">
          <label>day_04 </label>
          <input v-model="form.day_04" class="form-control"
                 type="text">

          <div v-if="errors.day_04" class='div-error' show variant="danger">
            {{ errors.day_04 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_05')" class="form-group">
          <label>day_05 </label>
          <input v-model="form.day_05" class="form-control"
                 type="text">

          <div v-if="errors.day_05" class='div-error' show variant="danger">
            {{ errors.day_05 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_06')" class="form-group">
          <label>day_06 </label>
          <input v-model="form.day_06" class="form-control"
                 type="text">

          <div v-if="errors.day_06" class='div-error' show variant="danger">
            {{ errors.day_06 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_07')" class="form-group">
          <label>day_07 </label>
          <input v-model="form.day_07" class="form-control"
                 type="text">

          <div v-if="errors.day_07" class='div-error' show variant="danger">
            {{ errors.day_07 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_08')" class="form-group">
          <label>day_08 </label>
          <input v-model="form.day_08" class="form-control"
                 type="text">

          <div v-if="errors.day_08" class='div-error' show variant="danger">
            {{ errors.day_08 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_09')" class="form-group">
          <label>day_09 </label>
          <input v-model="form.day_09" class="form-control"
                 type="text">

          <div v-if="errors.day_09" class='div-error' show variant="danger">
            {{ errors.day_09 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_10')" class="form-group">
          <label>day_10 </label>
          <input v-model="form.day_10" class="form-control"
                 type="text">

          <div v-if="errors.day_10" class='div-error' show variant="danger">
            {{ errors.day_10 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_11')" class="form-group">
          <label>day_11 </label>
          <input v-model="form.day_11" class="form-control"
                 type="text">

          <div v-if="errors.day_11" class='div-error' show variant="danger">
            {{ errors.day_11 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_12')" class="form-group">
          <label>day_12 </label>
          <input v-model="form.day_12" class="form-control"
                 type="text">

          <div v-if="errors.day_12" class='div-error' show variant="danger">
            {{ errors.day_12 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_13')" class="form-group">
          <label>day_13 </label>
          <input v-model="form.day_13" class="form-control"
                 type="text">

          <div v-if="errors.day_13" class='div-error' show variant="danger">
            {{ errors.day_13 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_14')" class="form-group">
          <label>day_14 </label>
          <input v-model="form.day_14" class="form-control"
                 type="text">

          <div v-if="errors.day_14" class='div-error' show variant="danger">
            {{ errors.day_14 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_15')" class="form-group">
          <label>day_15 </label>
          <input v-model="form.day_15" class="form-control"
                 type="text">

          <div v-if="errors.day_15" class='div-error' show variant="danger">
            {{ errors.day_15 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_16')" class="form-group">
          <label>day_16 </label>
          <input v-model="form.day_16" class="form-control"
                 type="text">

          <div v-if="errors.day_16" class='div-error' show variant="danger">
            {{ errors.day_16 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_17')" class="form-group">
          <label>day_17 </label>
          <input v-model="form.day_17" class="form-control"
                 type="text">

          <div v-if="errors.day_17" class='div-error' show variant="danger">
            {{ errors.day_17 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_18')" class="form-group">
          <label>day_18 </label>
          <input v-model="form.day_18" class="form-control"
                 type="text">

          <div v-if="errors.day_18" class='div-error' show variant="danger">
            {{ errors.day_18 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_19')" class="form-group">
          <label>day_19 </label>
          <input v-model="form.day_19" class="form-control"
                 type="text">

          <div v-if="errors.day_19" class='div-error' show variant="danger">
            {{ errors.day_19 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_20')" class="form-group">
          <label>day_20 </label>
          <input v-model="form.day_20" class="form-control"
                 type="text">

          <div v-if="errors.day_20" class='div-error' show variant="danger">
            {{ errors.day_20 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_21')" class="form-group">
          <label>day_21 </label>
          <input v-model="form.day_21" class="form-control"
                 type="text">

          <div v-if="errors.day_21" class='div-error' show variant="danger">
            {{ errors.day_21 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_22')" class="form-group">
          <label>day_22 </label>
          <input v-model="form.day_22" class="form-control"
                 type="text">

          <div v-if="errors.day_22" class='div-error' show variant="danger">
            {{ errors.day_22 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_23')" class="form-group">
          <label>day_23 </label>
          <input v-model="form.day_23" class="form-control"
                 type="text">

          <div v-if="errors.day_23" class='div-error' show variant="danger">
            {{ errors.day_23 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_24')" class="form-group">
          <label>day_24 </label>
          <input v-model="form.day_24" class="form-control"
                 type="text">

          <div v-if="errors.day_24" class='div-error' show variant="danger">
            {{ errors.day_24 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_25')" class="form-group">
          <label>day_25 </label>
          <input v-model="form.day_25" class="form-control"
                 type="text">

          <div v-if="errors.day_25" class='div-error' show variant="danger">
            {{ errors.day_25 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_26')" class="form-group">
          <label>day_26 </label>
          <input v-model="form.day_26" class="form-control"
                 type="text">

          <div v-if="errors.day_26" class='div-error' show variant="danger">
            {{ errors.day_26 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_27')" class="form-group">
          <label>day_27 </label>
          <input v-model="form.day_27" class="form-control"
                 type="text">

          <div v-if="errors.day_27" class='div-error' show variant="danger">
            {{ errors.day_27 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_28')" class="form-group">
          <label>day_28 </label>
          <input v-model="form.day_28" class="form-control"
                 type="text">

          <div v-if="errors.day_28" class='div-error' show variant="danger">
            {{ errors.day_28 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_29')" class="form-group">
          <label>day_29 </label>
          <input v-model="form.day_29" class="form-control"
                 type="text">

          <div v-if="errors.day_29" class='div-error' show variant="danger">
            {{ errors.day_29 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_30')" class="form-group">
          <label>day_30 </label>
          <input v-model="form.day_30" class="form-control"
                 type="text">

          <div v-if="errors.day_30" class='div-error' show variant="danger">
            {{ errors.day_30 }}
          </div>
        </div>


        <div v-if="canShowFilter('day_31')" class="form-group">
          <label>day_31 </label>
          <input v-model="form.day_31" class="form-control"
                 type="text">

          <div v-if="errors.day_31" class='div-error' show variant="danger">
            {{ errors.day_31 }}
          </div>
        </div>


        <div v-if="canShowFilter('jour_abscences')" class="form-group">
          <label>jour_abscences </label>
          <input v-model="form.jour_abscences" class="form-control"
                 type="text">

          <div v-if="errors.jour_abscences" class='div-error' show variant="danger">
            {{ errors.jour_abscences }}
          </div>
        </div>


        <div v-if="canShowFilter('jour_presences')" class="form-group">
          <label>jour_presences </label>
          <input v-model="form.jour_presences" class="form-control"
                 type="text">

          <div v-if="errors.jour_presences" class='div-error' show variant="danger">
            {{ errors.jour_presences }}
          </div>
        </div>


        <div class="form-group">
          <label>clients </label>
          <v-select
              v-model="form.client_id"
              :options="clientsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>factions </label>
          <v-select
              v-model="form.faction_id"
              :options="factionsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>fonctions </label>
          <v-select
              v-model="form.fonction_id"
              :options="fonctionsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>postes </label>
          <v-select
              v-model="form.poste_id"
              :options="postesData"
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


        <div class="form-group">
          <label>types </label>
          <v-select
              v-model="form.type_id"
              :options="typesData"
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


        <div class="form-group">
          <label>villes </label>
          <v-select
              v-model="form.ville_id"
              :options="villesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>zones </label>
          <v-select
              v-model="form.zone_id"
              :options="zonesData"
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
  name: 'FiltreRapports',
  components: {VSelect, Files},
  props: [
    'table',
    'clientsData',
    'factionsData',
    'fonctionsData',
    'postesData',
    'sitesData',
    'typesData',
    'usersData',
    'villesData',
    'zonesData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        mois: "",

        nom: "",

        user_id: "",

        prenom: "",

        matricule: "",

        poste_id: "",

        ville_id: "",

        zone_id: "",

        fonction_id: "",

        type_id: "",

        faction_id: "",

        site_id: "",

        client_id: "",

        day_01: "",

        day_02: "",

        day_03: "",

        day_04: "",

        day_05: "",

        day_06: "",

        day_07: "",

        day_08: "",

        day_09: "",

        day_10: "",

        day_11: "",

        day_12: "",

        day_13: "",

        day_14: "",

        day_15: "",

        day_16: "",

        day_17: "",

        day_18: "",

        day_19: "",

        day_20: "",

        day_21: "",

        day_22: "",

        day_23: "",

        day_24: "",

        day_25: "",

        day_26: "",

        day_27: "",

        day_28: "",

        day_29: "",

        day_30: "",

        day_31: "",

        jour_abscences: "",

        jour_presences: "",

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
