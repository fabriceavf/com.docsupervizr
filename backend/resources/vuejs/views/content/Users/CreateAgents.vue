<template>
  <b-overlay :show="isLoading">
    <div v-for="erreur in Object.keys(errors)">
      <div v-for="message in Object.values(errors[erreur])">
        <b-alert show style="padding: 5px" variant="danger">{{ erreur }} : {{ message[0] }}</b-alert>

      </div>
    </div>
    <div>

      <div class="header-detail">

        <b-avatar v-if="form.photo"
                  :src="$store.getters['general/apiUrl']+'/'+form.photo"
                  size="70px"
        />
      </div>
      <form-wizard
          :subtitle="null"
          :title="null"
          back-button-text="Precedent"
          class="mb-3 formUsers"
          color="rgb(40, 167, 69)"
          finish-button-text="Soumettre"
          next-button-text="Suivant"
          shape="circle"
          stepSize="sm"
          @on-complete="createLine"
      >

        <tab-content
            :before-change="validationForm"
            title="Information personnel"
        >
          <div class="row">
            <div class="form-group col-sm-6">
              <label>nom </label>
              <input v-model="form.nom" :class="errors.nom?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.nom" class="invalid-feedback">
                <template v-for=" error in errors.nom"> {{ error[0] }}</template>

              </div>
            </div>


            <div class="form-group col-sm-6">
              <label>prenom </label>
              <input v-model="form.prenom" :class="errors.prenom?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.prenom" class="invalid-feedback">
                <template v-for=" error in errors.prenom"> {{ error[0] }}</template>

              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-3 ">
              <label>sexes </label>
              <v-select
                  v-model="form.sexe_id"
                  :options="sexesData"
                  :reduce="ele => ele.id"
                  label="Selectlabel"
              />
              <div v-if="errors.sexe_id" class="invalid-feedback">
                <template v-for=" error in errors.sexe_id"> {{ error[0] }}</template>

              </div>
            </div>

            <div class="form-group col-sm-3">
              <label>date_naissance </label>
              <input v-model="form.date_naissance"
                     :class="errors.date_naissance?'form-control is-invalid':'form-control'"
                     type="date">

              <div v-if="errors.date_naissance" class="invalid-feedback">
                <template v-for=" error in errors.date_naissance"> {{ error[0] }}</template>

              </div>
            </div>
            <div class="form-group col-sm-3">
              <label>nationalites </label>
              <v-select
                  v-model="form.nationalite_id"
                  :options="nationalitesData"
                  :reduce="ele => ele.id"
                  label="Selectlabel"
              />
              <div v-if="errors.nationalite_id" class="invalid-feedback">
                <template v-for=" error in errors.nationalite_id"> {{ error[0] }}</template>

              </div>
            </div>

            <div class="form-group col-sm-3">
              <label>telephone1 </label>
              <input v-model="form.telephone1" :class="errors.telephone1?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.telephone1" class="invalid-feedback">
                <template v-for=" error in errors.telephone1"> {{ error[0] }}</template>

              </div>
            </div>

          </div>
          <div class="row">

            <div class="form-group col-sm-3">
              <label>nombre_enfant </label>
              <input v-model="form.nombre_enfant" :class="errors.nombre_enfant?'form-control is-invalid':'form-control'"
                     type="number">

              <div v-if="errors.nombre_enfant" class="invalid-feedback">
                <template v-for=" error in errors.nombre_enfant"> {{ error[0] }}</template>

              </div>
            </div>
            <div class="form-group  col-sm-3">
              <label>matrimoniales </label>
              <v-select
                  v-model="form.matrimoniale_id"
                  :options="matrimonialesData"
                  :reduce="ele => ele.id"
                  label="Selectlabel"
              />
              <div v-if="errors.matrimoniale_id" class="invalid-feedback">
                <template v-for=" error in errors.matrimoniale_id"> {{ error[0] }}</template>

              </div>
            </div>


            <div class="form-group col-sm-3">
              <label>num_cnss </label>
              <input v-model="form.num_cnss" :class="errors.num_cnss?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.num_cnss" class="invalid-feedback">
                <template v-for=" error in errors.num_cnss"> {{ error[0] }}</template>

              </div>
            </div>


            <div class="form-group col-sm-3">
              <label>num_cnamgs </label>
              <input v-model="form.num_cnamgs" :class="errors.num_cnamgs?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.num_cnamgs" class="invalid-feedback">
                <template v-for=" error in errors.num_cnamgs"> {{ error[0] }}</template>

              </div>
            </div>

          </div>
        </tab-content>
        <tab-content
            :before-change="validationForm"
            title="Informations Agents"
        >

          <div class="row">

            <div class="form-group col-sm-6">
              <label>matricule </label>
              <input v-model="form.matricule" :class="errors.matricule?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.matricule" class="invalid-feedback">
                <template v-for=" error in errors.matricule"> {{ error[0] }}</template>

              </div>
            </div>
            <div class="form-group col-sm-3">
              <label>num_dossier </label>
              <input v-model="form.num_dossier" :class="errors.num_dossier?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.num_dossier" class="invalid-feedback">
                <template v-for=" error in errors.num_dossier"> {{ error[0] }}</template>

              </div>
            </div>
            <div class="form-group col-sm-3">
              <label>date_embauche </label>
              <input v-model="form.date_embauche" :class="errors.date_embauche?'form-control is-invalid':'form-control'"
                     type="date">

              <div v-if="errors.date_embauche" class="invalid-feedback">
                <template v-for=" error in errors.date_embauche"> {{ error[0] }}</template>

              </div>
            </div>
          </div>

          <div class="row">

            <div class="form-group col-sm-3">
              <label>contrats </label>
              <v-select
                  v-model="form.contrat_id"
                  :options="contratsData"
                  :reduce="ele => ele.id"
                  label="Selectlabel"
              />
              <div v-if="errors.contrat_id" class="invalid-feedback">
                <template v-for=" error in errors.contrat_id"> {{ error[0] }}</template>

              </div>
            </div>
            <div class="form-group col-sm-3">
              <label>directions </label>
              <v-select
                  v-model="form.direction_id"
                  :options="directionsData"
                  :reduce="ele => ele.id"
                  label="Selectlabel"
              />
              <div v-if="errors.direction_id" class="invalid-feedback">
                <template v-for=" error in errors.direction_id"> {{ error[0] }}</template>

              </div>
            </div>
            <div class="form-group col-sm-3">
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
            <div class="form-group col-sm-3">
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
          </div>
          <div class="row">
            <div class="form-group col-sm-6">
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
            <div class="form-group col-sm-3">
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
            <div class="form-group col-sm-3">
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

          <div class="row">
            <div class="form-group col-sm-3">
              <label>categories </label>
              <v-select
                  v-model="form.categorie_id"
                  :options="categoriesData"
                  :reduce="ele => ele.id"
                  label="Selectlabel"
              />
              <div v-if="errors.categorie_id" class="invalid-feedback">
                <template v-for=" error in errors.categorie_id"> {{ error[0] }}</template>

              </div>
            </div>
            <div class="form-group col-sm-3">
              <label>echelons </label>
              <v-select
                  v-model="form.echelon_id"
                  :options="echelonsData"
                  :reduce="ele => ele.id"
                  label="Selectlabel"
              />
              <div v-if="errors.echelon_id" class="invalid-feedback">
                <template v-for=" error in errors.echelon_id"> {{ error[0] }}</template>

              </div>
            </div>
            <div class="form-group col-sm-6">
              <label>num_badge </label>
              <input v-model="form.num_badge" :class="errors.num_badge?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.num_badge" class="invalid-feedback">
                <template v-for=" error in errors.num_badge"> {{ error[0] }}</template>

              </div>
            </div>
          </div>


        </tab-content>

        <tab-content
            :before-change="validationForm"
            title="Badge"
        >

          <div class="row">

            <div class="form-group col-sm-12">
              <label>photo </label>

              <PhotoSgs v-model="form.photo"></PhotoSgs>
              <div v-if="errors.photo" class="invalid-feedback">
                <template v-for=" error in errors.photo"> {{ error[0] }}</template>
              </div>
            </div>
          </div>

          <div class="blockBadge">
            <div style="text-align: center">

              <h5>Apercu du badge</h5>
            </div>

            <div class="row" style="display:flex;justify-content:center">
              <PrintBadge :agent="form"/>
            </div>

          </div>
        </tab-content>


      </form-wizard>
    </div>
  </b-overlay>
</template>

<script>

import {FormWizard, TabContent} from 'vue-form-wizard'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import PhotoSgs from "@/components/PhotoSgs.vue";
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import PrintBadge from "@/components/PrintBadge.vue";

export default {
  name: 'CreateAgents',
  components: {
    VSelect, Files, PhotoSgs, FormWizard,
    TabContent, ValidationProvider, ValidationObserver, PrintBadge
  },
  props: [
    'gridApi',
    'modalFormId',
    'actifsData',
    'balisesData',
    'categoriesData',
    'contratsData',
    'directionsData',
    'echelonsData',
    'factionsData',
    'fonctionsData',
    'matrimonialesData',
    'nationalitesData',
    'onlinesData',
    'postesData',
    'sexesData',
    'sitesData',
    'situationsData',
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

        name: "",

        nom: "",

        prenom: "",

        matricule: "",

        num_badge: "",

        date_naissance: "",

        num_cnss: "",

        num_cnamgs: "",

        telephone1: "",

        telephone2: "",

        photo: "",

        date_embauche: "",

        download_date: "",

        actif_id: 2,

        nationalite_id: "",

        contrat_id: "",

        direction_id: "",

        categorie_id: "",

        echelon_id: "",

        sexe_id: "",

        matrimoniale_id: "",

        poste_id: "",

        ville_id: "",

        zone_id: "",

        site_id: "",

        situation_id: "",

        balise_id: "",

        fonction_id: "",

        user_id: "",

        email: "",

        email_verified_at: "",

        password: "",

        emp_code: "",

        nombre_enfant: "",

        num_dossier: "",

        online_id: "",

        type_id: 2,

        faction_id: "",

        remember_token: "",

        extra_attributes: "",

        created_at: "",

        updated_at: "",

        deleted_at: "",
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      if(this.routeData.meta.isOne){
        this.form.type_id=3
      }
      this.axios.post('/api/users', this.form).then(response => {
        this.isLoading = false
        this.resetForm()
        this.gridApi.applyServerSideTransaction({
          add: [
            response.data
          ],
        });
        this.gridApi.refreshServerSide()
        this.$bvModal.hide(this.modalFormId)
        this.$emit('close')
        this.$toast.success('Operation effectuer avec succes')
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
        name: "",
        nom: "",
        prenom: "",
        matricule: "",
        num_badge: "",
        date_naissance: "",
        num_cnss: "",
        num_cnamgs: "",
        telephone1: "",
        telephone2: "",
        photo: "",
        date_embauche: "",
        download_date: "",
        actif_id: "",
        nationalite_id: "",
        contrat_id: "",
        direction_id: "",
        categorie_id: "",
        echelon_id: "",
        sexe_id: "",
        matrimoniale_id: "",
        poste_id: "",
        ville_id: "",
        zone_id: "",
        site_id: "",
        situation_id: "",
        balise_id: "",
        fonction_id: "",
        user_id: "",
        email: "",
        email_verified_at: "",
        password: "",
        emp_code: "",
        nombre_enfant: "",
        num_dossier: "",
        online_id: "",
        type_id: "",
        faction_id: "",
        remember_token: "",
        extra_attributes: "",
        created_at: "",
        updated_at: "",
        deleted_at: "",
      }
    },
    validationForm() {
      return new Promise((resolve, reject) => {
        resolve(true)
        // this.$refs.accountRules.validate().then(success => {
        //   if (success) {
        //     resolve(true)
        //   } else {
        //     reject()
        //   }
        // })
      })
    },
    validationFormInfo() {
      return new Promise((resolve, reject) => {
        this.$refs.infoRules.validate().then(success => {
          if (success) {
            resolve(true)
          } else {
            reject()
          }
        })
      })
    },
    validationFormAddress() {
      return new Promise((resolve, reject) => {
        this.$refs.addressRules.validate().then(success => {
          if (success) {
            resolve(true)
          } else {
            reject()
          }
        })
      })
    },
    validationFormSocial() {
      return new Promise((resolve, reject) => {
        this.$refs.socialRules.validate().then(success => {
          if (success) {
            resolve(true)
          } else {
            reject()
          }
        })
      })
    },
  },

}
</script>
<style>
.blockBadge {
  padding: 10px;
  border: dashed;
  border-radius: 5px;
}
</style>
