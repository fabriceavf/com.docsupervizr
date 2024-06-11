<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="EditLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>cle </label>
          <input v-model="form.cle" :class="errors.cle?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.cle" class="invalid-feedback">
            <template v-for=" error in errors.cle"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>valeur </label>
          <input v-model="form.valeur" :class="errors.valeur?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.valeur" class="invalid-feedback">
            <template v-for=" error in errors.valeur"> {{ error[0] }}</template>

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
  name: 'EditExtrasdatas',
  components: {VSelect, Files},
  props: ['data', 'gridApi', 'modalFormId',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        cle: "",

        valeur: "",

        extra_attributes: "",

        created_at: "",

        updated_at: "",
      }
    }
  },

  mounted() {
    this.form = this.data
  },
  methods: {

    EditLine() {
      this.isLoading = true
      this.axios.post('/api/extrasdatas/' + this.form.id + '/update', this.form).then(response => {
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
      this.axios.post('/api/extrasdatas/' + this.form.id + '/delete').then(response => {
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
