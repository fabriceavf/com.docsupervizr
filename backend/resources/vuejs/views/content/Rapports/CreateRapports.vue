<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>mois </label>
          <input v-model="form.mois" :class="errors.mois?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mois" class="invalid-feedback">
            <template v-for=" error in errors.mois"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>nom </label>
          <input v-model="form.nom" :class="errors.nom?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.nom" class="invalid-feedback">
            <template v-for=" error in errors.nom"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>prenom </label>
          <input v-model="form.prenom" :class="errors.prenom?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.prenom" class="invalid-feedback">
            <template v-for=" error in errors.prenom"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>matricule </label>
          <input v-model="form.matricule" :class="errors.matricule?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.matricule" class="invalid-feedback">
            <template v-for=" error in errors.matricule"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_01 </label>
          <input v-model="form.day_01" :class="errors.day_01?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_01" class="invalid-feedback">
            <template v-for=" error in errors.day_01"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_02 </label>
          <input v-model="form.day_02" :class="errors.day_02?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_02" class="invalid-feedback">
            <template v-for=" error in errors.day_02"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_03 </label>
          <input v-model="form.day_03" :class="errors.day_03?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_03" class="invalid-feedback">
            <template v-for=" error in errors.day_03"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_04 </label>
          <input v-model="form.day_04" :class="errors.day_04?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_04" class="invalid-feedback">
            <template v-for=" error in errors.day_04"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_05 </label>
          <input v-model="form.day_05" :class="errors.day_05?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_05" class="invalid-feedback">
            <template v-for=" error in errors.day_05"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_06 </label>
          <input v-model="form.day_06" :class="errors.day_06?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_06" class="invalid-feedback">
            <template v-for=" error in errors.day_06"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_07 </label>
          <input v-model="form.day_07" :class="errors.day_07?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_07" class="invalid-feedback">
            <template v-for=" error in errors.day_07"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_08 </label>
          <input v-model="form.day_08" :class="errors.day_08?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_08" class="invalid-feedback">
            <template v-for=" error in errors.day_08"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_09 </label>
          <input v-model="form.day_09" :class="errors.day_09?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_09" class="invalid-feedback">
            <template v-for=" error in errors.day_09"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_10 </label>
          <input v-model="form.day_10" :class="errors.day_10?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_10" class="invalid-feedback">
            <template v-for=" error in errors.day_10"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_11 </label>
          <input v-model="form.day_11" :class="errors.day_11?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_11" class="invalid-feedback">
            <template v-for=" error in errors.day_11"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_12 </label>
          <input v-model="form.day_12" :class="errors.day_12?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_12" class="invalid-feedback">
            <template v-for=" error in errors.day_12"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_13 </label>
          <input v-model="form.day_13" :class="errors.day_13?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_13" class="invalid-feedback">
            <template v-for=" error in errors.day_13"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_14 </label>
          <input v-model="form.day_14" :class="errors.day_14?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_14" class="invalid-feedback">
            <template v-for=" error in errors.day_14"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_15 </label>
          <input v-model="form.day_15" :class="errors.day_15?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_15" class="invalid-feedback">
            <template v-for=" error in errors.day_15"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_16 </label>
          <input v-model="form.day_16" :class="errors.day_16?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_16" class="invalid-feedback">
            <template v-for=" error in errors.day_16"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_17 </label>
          <input v-model="form.day_17" :class="errors.day_17?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_17" class="invalid-feedback">
            <template v-for=" error in errors.day_17"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_18 </label>
          <input v-model="form.day_18" :class="errors.day_18?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_18" class="invalid-feedback">
            <template v-for=" error in errors.day_18"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_19 </label>
          <input v-model="form.day_19" :class="errors.day_19?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_19" class="invalid-feedback">
            <template v-for=" error in errors.day_19"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_20 </label>
          <input v-model="form.day_20" :class="errors.day_20?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_20" class="invalid-feedback">
            <template v-for=" error in errors.day_20"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_21 </label>
          <input v-model="form.day_21" :class="errors.day_21?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_21" class="invalid-feedback">
            <template v-for=" error in errors.day_21"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_22 </label>
          <input v-model="form.day_22" :class="errors.day_22?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_22" class="invalid-feedback">
            <template v-for=" error in errors.day_22"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_23 </label>
          <input v-model="form.day_23" :class="errors.day_23?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_23" class="invalid-feedback">
            <template v-for=" error in errors.day_23"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_24 </label>
          <input v-model="form.day_24" :class="errors.day_24?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_24" class="invalid-feedback">
            <template v-for=" error in errors.day_24"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_25 </label>
          <input v-model="form.day_25" :class="errors.day_25?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_25" class="invalid-feedback">
            <template v-for=" error in errors.day_25"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_26 </label>
          <input v-model="form.day_26" :class="errors.day_26?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_26" class="invalid-feedback">
            <template v-for=" error in errors.day_26"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_27 </label>
          <input v-model="form.day_27" :class="errors.day_27?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_27" class="invalid-feedback">
            <template v-for=" error in errors.day_27"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_28 </label>
          <input v-model="form.day_28" :class="errors.day_28?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_28" class="invalid-feedback">
            <template v-for=" error in errors.day_28"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_29 </label>
          <input v-model="form.day_29" :class="errors.day_29?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_29" class="invalid-feedback">
            <template v-for=" error in errors.day_29"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_30 </label>
          <input v-model="form.day_30" :class="errors.day_30?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_30" class="invalid-feedback">
            <template v-for=" error in errors.day_30"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>day_31 </label>
          <input v-model="form.day_31" :class="errors.day_31?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.day_31" class="invalid-feedback">
            <template v-for=" error in errors.day_31"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jour_abscences </label>
          <input v-model="form.jour_abscences" :class="errors.jour_abscences?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jour_abscences" class="invalid-feedback">
            <template v-for=" error in errors.jour_abscences"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jour_presences </label>
          <input v-model="form.jour_presences" :class="errors.jour_presences?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jour_presences" class="invalid-feedback">
            <template v-for=" error in errors.jour_presences"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>clients </label>
          <v-select
              v-model="form.client_id"
              :options="clientsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.client_id" class="invalid-feedback">
            <template v-for=" error in errors.client_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>factions </label>
          <v-select
              v-model="form.faction_id"
              :options="factionsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.faction_id" class="invalid-feedback">
            <template v-for=" error in errors.faction_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>fonctions </label>
          <v-select
              v-model="form.fonction_id"
              :options="fonctionsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.fonction_id" class="invalid-feedback">
            <template v-for=" error in errors.fonction_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>postes </label>
          <v-select
              v-model="form.poste_id"
              :options="postesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.poste_id" class="invalid-feedback">
            <template v-for=" error in errors.poste_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>sites </label>
          <v-select
              v-model="form.site_id"
              :options="sitesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.site_id" class="invalid-feedback">
            <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>types </label>
          <v-select
              v-model="form.type_id"
              :options="typesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.type_id" class="invalid-feedback">
            <template v-for=" error in errors.type_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>users </label>
          <v-select
              v-model="form.user_id"
              :options="usersData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.user_id" class="invalid-feedback">
            <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>villes </label>
          <v-select
              v-model="form.ville_id"
              :options="villesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.ville_id" class="invalid-feedback">
            <template v-for=" error in errors.ville_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>zones </label>
          <v-select
              v-model="form.zone_id"
              :options="zonesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.zone_id" class="invalid-feedback">
            <template v-for=" error in errors.zone_id"> {{ error[0] }}</template>

          </div>
        </div>

      </div>

      <button class="btn btn-primary" type="submit">
        <i class="fas fa-floppy-disk"></i> Créer
      </button>
    </form>
  </b-overlay>
</template>

<script>
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
  name: 'CreateRapports',
  components: {VSelect, Files},
  props: [
    'gridApi',
    'modalFormId',
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
      this.isLoading = true
      this.axios.post('/api/rapports', this.form).then(response => {
        this.isLoading = false
        this.resetForm()
        this.gridApi.applyServerSideTransaction({
          add: [
            response.data
          ],
        });
        this.gridApi.refreshServerSide()
        this.$bvModal.hide(this.modalFormId)
        this.$toast.success('Operation effectuer avec succes')
        this.$emit('close')
        console.log(response.data)
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    resetForm() {
      this.form = {
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
  }
}
</script>
