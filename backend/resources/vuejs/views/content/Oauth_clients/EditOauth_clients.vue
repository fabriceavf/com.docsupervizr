<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="EditLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>name </label>
          <input v-model="form.name" :class="errors.name?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.name" class="invalid-feedback">
            <template v-for=" error in errors.name"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>secret </label>
          <input v-model="form.secret" :class="errors.secret?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.secret" class="invalid-feedback">
            <template v-for=" error in errors.secret"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>provider </label>
          <input v-model="form.provider" :class="errors.provider?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.provider" class="invalid-feedback">
            <template v-for=" error in errors.provider"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>redirect </label>
          <input v-model="form.redirect" :class="errors.redirect?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.redirect" class="invalid-feedback">
            <template v-for=" error in errors.redirect"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>personal_access_client </label>
          <input v-model="form.personal_access_client"
                 :class="errors.personal_access_client?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.personal_access_client" class="invalid-feedback">
            <template v-for=" error in errors.personal_access_client"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>password_client </label>
          <input v-model="form.password_client" :class="errors.password_client?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.password_client" class="invalid-feedback">
            <template v-for=" error in errors.password_client"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>revoked </label>
          <input v-model="form.revoked" :class="errors.revoked?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.revoked" class="invalid-feedback">
            <template v-for=" error in errors.revoked"> {{ error[0] }}</template>

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

      </div>

      <div class="d-flex justify-content-between">
        <button class="btn btn-primary" type="submit">
          <i class="fas fa-floppy-disk"></i> Mettre à jour
        </button>
        <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
          <i class="fas fa-close"></i> Supprimer
        </button>
      </div>
    </form>
  </b-overlay>
</template>

<script>
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
  name: 'EditOauth_clients',
  components: {VSelect, Files},
  props: ['data', 'gridApi', 'modalFormId',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        user_id: "",

        name: "",

        secret: "",

        provider: "",

        redirect: "",

        personal_access_client: "",

        password_client: "",

        revoked: "",

        created_at: "",

        updated_at: "",

        extra_attributes: "",

        deleted_at: "",
      }
    }
  },

  mounted() {
    this.form = this.data
  },
  methods: {

    EditLine() {
      this.isLoading = true
      this.axios.post('/api/oauth_clients/' + this.form.id + '/update', this.form).then(response => {
        this.isLoading = false
        this.gridApi.applyServerSideTransaction({
          update: [
            response.data
          ],
        });
        this.$bvModal.hide(this.modalFormId)
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
      this.axios.post('/api/oauth_clients/' + this.form.id + '/delete').then(response => {
        this.isLoading = false

        this.gridApi.applyServerSideTransaction({
          remove: [
            this.form
          ]
        });
        this.gridApi.refreshServerSide()
        this.$bvModal.hide(this.modalFormId)
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
