<template>
  <b-overlay :show="isLoading">
    <div>
      <div v-for="erreur in Object.keys(errors)">
        <div v-for="message in Object.values(errors[erreur])">
          <b-alert show style="padding: 5px" variant="danger">{{ erreur }} : {{ message[0] }}</b-alert>

        </div>
      </div>
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
            <div class="form-group col-sm-12">
              <label>email </label>
              <input v-model="form.email" :class="errors.email?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.email" class="invalid-feedback">
                <template v-for=" error in errors.email"> {{ error[0] }}</template>

              </div>
            </div>


          </div>
          <div class="row">

            <div class="form-group col-sm-6 ">
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

            <div class="form-group col-sm-6">
              <label>password </label>
              <input v-model="form.password" :class="errors.password?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.password" class="invalid-feedback">
                <template v-for=" error in errors.password"> {{ error[0] }}</template>

              </div>
            </div>


          </div>

          <div class="row">

            <div class="form-group col-sm-6">
              <label>code sur la pointeuse </label>
              <input v-model="form.emp_code" :class="errors.emp_code?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.emp_code" class="invalid-feedback">
                <template v-for=" error in errors.emp_code"> {{ error[0] }}</template>

              </div>
            </div>

            <div class="form-group col-sm-6">
              <label>numero de badge </label>
              <input v-model="form.num_badge" :class="errors.num_badge?'form-control is-invalid':'form-control'"
                     type="text">

              <div v-if="errors.num_badge" class="invalid-feedback">
                <template v-for=" error in errors.num_badge"> {{ error[0] }}</template>

              </div>
            </div>
          </div>

          <!--          <div class="row">-->
          <!--            <div class="form-group col-sm-12">-->
          <!--              <label>photo </label>-->
          <!--              <PhotoSgs v-model="form.photo"></PhotoSgs>-->
          <!--              <div v-if="errors.photo" class="invalid-feedback">-->
          <!--                <template v-for=" error in errors.photo"> {{ error[0] }}</template>-->
          <!--              </div>-->
          <!--            </div>-->
          <!--          </div>-->
        </tab-content>

        <!--        <tab-content-->
        <!--            :before-change="validationForm"-->
        <!--            title="Identification"-->
        <!--        >-->

        <!--          <div class="row">-->

        <!--            <div class="form-group col-sm-6">-->
        <!--              <label>code sur la pointeuse </label>-->
        <!--              <input v-model="form.emp_code" :class="errors.emp_code?'form-control is-invalid':'form-control'"-->
        <!--                     type="text">-->

        <!--              <div v-if="errors.emp_code" class="invalid-feedback">-->
        <!--                <template v-for=" error in errors.emp_code"> {{ error[0] }}</template>-->

        <!--              </div>-->
        <!--            </div>-->

        <!--            <div class="form-group col-sm-6">-->
        <!--              <label>numero de badge </label>-->
        <!--              <input v-model="form.num_badge" :class="errors.num_badge?'form-control is-invalid':'form-control'"-->
        <!--                     type="text">-->

        <!--              <div v-if="errors.num_badge" class="invalid-feedback">-->
        <!--                <template v-for=" error in errors.num_badge"> {{ error[0] }}</template>-->

        <!--              </div>-->
        <!--            </div>-->
        <!--          </div>-->

        <!--        </tab-content>-->


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

export default {
  name: 'CreateUsers',
  components: {
    VSelect, Files, PhotoSgs, FormWizard,
    TabContent, ValidationProvider, ValidationObserver
  },
  props: [
    'gridApi',
    'modalFormId',
    'actifsData',
    'contratsData',
    'fonctionsData',
    'matrimonialesData',
    'nationalitesData',
    'onlinesData',
    'sexesData',
    'typesData',
    'usersData',
    "typeCreation"

  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        name: "",

        email: "",

        email_verified_at: "",

        password: "",

        matricule: "",

        emp_code: "",

        nom: "",

        prenom: "",

        num_badge: "",

        date_naissance: "",

        num_cnss: "",

        num_cnamgs: "",

        telephone1: "",

        telephone2: "",

        nationalite_id: "",

        nombre_enfant: "",

        photo: "",

        actif_id: 1,

        online_id: 1,

        date_embauche: "",

        sexe_id: "",

        type_id: 1,

        contrat_id: "",

        matrimoniale_id: "",

        fonction_id: "",

        user_id: 0,

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
        email: "",
        email_verified_at: "",
        password: "",
        matricule: "",
        emp_code: "",
        nom: "",
        prenom: "",
        num_badge: "",
        date_naissance: "",
        num_cnss: "",
        num_cnamgs: "",
        telephone1: "",
        telephone2: "",
        nationalite_id: "",
        nombre_enfant: "",
        photo: "",
        actif_id: "",
        online_id: "",
        date_embauche: "",
        sexe_id: "",
        type_id: "",
        contrat_id: "",
        matrimoniale_id: "",
        fonction_id: "",
        user_id: "",
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
  }
}
</script>
<style>
.header-detail {
  display: flex;
  justify-content: space-between;
}
</style>
