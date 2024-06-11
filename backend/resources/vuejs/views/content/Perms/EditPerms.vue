<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="EditLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>permission </label>
          <input v-model="form.permission" :class="errors.permission?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.permission" class="invalid-feedback">
            <template v-for=" error in errors.permission"> {{ error[0] }}</template>

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
          <label>type </label>
          <input v-model="form.type" :class="errors.type?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.type" class="invalid-feedback">
            <template v-for=" error in errors.type"> {{ error[0] }}</template>

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
  name: 'EditPerms',
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

        permission: "",

        user_id: "",

        nom: "",

        prenom: "",

        type: "",
      }
    }
  },

  mounted() {
    this.form = this.data
  },
  methods: {

    EditLine() {
      this.isLoading = true
      this.axios.post('/api/perms/' + this.form.id + '/update', this.form).then(response => {
        this.isLoading = false
        this.gridApi.applyServerSideTransaction({
          update: [
            response.data
          ],
        });
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
    DeleteLine() {
      this.isLoading = true
      this.axios.post('/api/perms/' + this.form.id + '/delete').then(response => {
        this.isLoading = false

        this.gridApi.applyServerSideTransaction({
          remove: [
            this.form
          ]
        });
        this.gridApi.refreshServerSide()
        this.$bvModal.hide(this.modalFormId)
        this.$toast.success('Operation effectuer avec succes')
        this.$emit('close')
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
