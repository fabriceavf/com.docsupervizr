<template>
  <b-overlay :show="isLoading">
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

      <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
        <i class="fas fa-close"></i> Supprimer l'users
      </button>
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
        @on-complete="EditLine"
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
          <div class="form-group col-sm-6">
            <label>email </label>
            <input v-model="form.email" :class="errors.email?'form-control is-invalid':'form-control'"
                   type="text">

            <div v-if="errors.email" class="invalid-feedback">
              <template v-for=" error in errors.email"> {{ error[0] }}</template>

            </div>
          </div>

          <div class="form-group col-sm-6">
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

        <div class="row">
          <div class="form-group col-sm-12">
            <label>Nouveau mot de passe </label></br>
            <span>Attention en renseignant ce champs le mot de passe l'utilisateur sera modifier</span>
            <input v-model="newPassword" :class="errors.newPassword?'form-control is-invalid':'form-control'"
                   type="text">

            <div v-if="errors.newPassword" class="invalid-feedback">
              <template v-for=" error in errors.newPassword"> {{ error[0] }}</template>

            </div>
          </div>
        </div>
      </tab-content>
      <!--      <tab-content-->
      <!--          :before-change="validationForm"-->
      <!--          title="Permissions"-->
      <!--      >-->
      <!--        <Permissions-->
      <!--            :key="form.id"-->
      <!--            :user-select="form.id"-->
      <!--        ></Permissions>-->

      <!--      </tab-content>-->
      <tab-content
          :before-change="validationForm"
          title="Activites Recente"
      >
        <Activitesrecentes
            :key="form.id"
            :user-select="form.id"
        ></Activitesrecentes>

      </tab-content>


    </form-wizard>


  </b-overlay>
</template>

<script>
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import PhotoSgs from "@/components/PhotoSgs.vue";
import {FormWizard, TabContent} from "vue-form-wizard";
import {ValidationObserver, ValidationProvider} from "vee-validate";
import PrintBadge from "@/components/PrintBadge.vue";
import Permissions from "@/views/content/Users/Permissions.vue";
import Activitesrecentes from "@/views/content/Users/Activitesrecentes.vue";

export default {
  name: 'EditAgents',
  components: {
    VSelect,
    Files,
    PhotoSgs,
    FormWizard,
    TabContent,
    ValidationProvider,
    ValidationObserver,
    PrintBadge,
    Permissions,
    Activitesrecentes
  },
  props: ['data', 'gridApi', 'modalFormId',
    'actifsData',
    'contratsData',
    'fonctionsData',
    'matrimonialesData',
    'nationalitesData',
    'onlinesData',
    'sexesData',
    'typesData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      newPassword: '',
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
    }
  },

  mounted() {
    this.form = this.data
    this.form['date_naissance'] = this.form['date_naissance'].split(' ')[0]
    this.form['date_embauche'] = this.form['date_embauche'].split(' ')[0]
  },
  methods: {

    EditLine() {
      this.isLoading = true
      if (this.newPassword != '') {
        this.form.password = this.newPassword
      }
      this.axios.post('/api/users/' + this.form.id + '/update', this.form).then(response => {
        this.isLoading = false
        this.gridApi.applyServerSideTransaction({
          update: [
            response.data
          ],
        });
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
    DeleteLine() {
      this.isLoading = true
      this.axios.post('/api/users/' + this.form.id + '/delete').then(response => {
        this.isLoading = false

        this.gridApi.applyServerSideTransaction({
          remove: [
            this.form
          ]
        });
        this.gridApi.refreshServerSide()
        this.$bvModal.hide(this.modalFormId)
        this.$emit('close')
        this.$toast.success('Operation effectuer avec succes')
        console.log(response.data)
      }).catch(error => {
        console.log(error.response.data)
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de la suppression')
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
