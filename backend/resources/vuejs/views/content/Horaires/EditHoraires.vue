<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="EditLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>libelle </label>
          <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.libelle" class="invalid-feedback">
            <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>debut </label>
          <input v-model="form.debut" :class="errors.debut?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.debut" class="invalid-feedback">
            <template v-for=" error in errors.debut"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>fin </label>
          <input v-model="form.fin" :class="errors.fin?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.fin" class="invalid-feedback">
            <template v-for=" error in errors.fin"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>tolerance </label>
          <input v-model="form.tolerance" :class="errors.tolerance?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.tolerance" class="invalid-feedback">
            <template v-for=" error in errors.tolerance"> {{ error[0] }}</template>

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
          <label>taches </label>
          <v-select
              v-model="form.tache_id"
              :options="tachesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.tache_id" class="invalid-feedback">
            <template v-for=" error in errors.tache_id"> {{ error[0] }}</template>

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
  name: 'EditHoraires',
  components: {VSelect, Files},
  props: ['data', 'gridApi', 'modalFormId',
    'tachesData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        libelle: "",

        debut: "",

        fin: "",

        tolerance: "",

        type: "",

        tache_id: "",

        extra_attributes: "",

        created_at: "",

        updated_at: "",

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
      this.axios.post('/api/horaires/' + this.form.id + '/update', this.form).then(response => {
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
      this.axios.post('/api/horaires/' + this.form.id + '/delete').then(response => {
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
