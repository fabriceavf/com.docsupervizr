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
          <label>scopes </label>
          <input v-model="form.scopes" :class="errors.scopes?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.scopes" class="invalid-feedback">
            <template v-for=" error in errors.scopes"> {{ error[0] }}</template>

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
          <label>expires_at </label>
          <input v-model="form.expires_at" :class="errors.expires_at?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.expires_at" class="invalid-feedback">
            <template v-for=" error in errors.expires_at"> {{ error[0] }}</template>

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
  name: 'EditOauth_access_tokens',
  components: {VSelect, Files},
  props: ['data', 'gridApi', 'modalFormId',
    'clientsData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        user_id: "",

        client_id: "",

        name: "",

        scopes: "",

        revoked: "",

        created_at: "",

        updated_at: "",

        expires_at: "",

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
      this.axios.post('/api/oauth_access_tokens/' + this.form.id + '/update', this.form).then(response => {
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
      this.axios.post('/api/oauth_access_tokens/' + this.form.id + '/delete').then(response => {
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
