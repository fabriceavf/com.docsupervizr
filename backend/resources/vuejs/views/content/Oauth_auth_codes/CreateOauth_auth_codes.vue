<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


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
  name: 'CreateOauth_auth_codes',
  components: {VSelect, Files},
  props: [
    'gridApi',
    'modalFormId',
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

        scopes: "",

        revoked: "",

        expires_at: "",

        extra_attributes: "",

        deleted_at: "",
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.axios.post('/api/oauth_auth_codes', this.form).then(response => {
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
        user_id: "",
        client_id: "",
        scopes: "",
        revoked: "",
        expires_at: "",
        extra_attributes: "",
        deleted_at: "",
      }
    }
  }
}
</script>
