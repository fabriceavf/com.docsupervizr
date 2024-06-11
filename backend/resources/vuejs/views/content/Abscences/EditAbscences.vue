<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="EditLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>raison </label>
          <input v-model="form.raison" :class="errors.raison?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.raison" class="invalid-feedback">
            <template v-for=" error in errors.raison"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>debut </label>
          <input v-model="form.debut" :class="errors.debut?'form-control is-invalid':'form-control'"
                 type="date">

          <div v-if="errors.debut" class="invalid-feedback">
            <template v-for=" error in errors.debut"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>fin </label>
          <input v-model="form.fin" :class="errors.fin?'form-control is-invalid':'form-control'"
                 type="date">

          <div v-if="errors.fin" class="invalid-feedback">
            <template v-for=" error in errors.fin"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>etats </label>
          <input v-model="form.etats" :class="errors.etats?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.etats" class="invalid-feedback">
            <template v-for=" error in errors.etats"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>typesabscences </label>
          <v-select
              v-model="form.typesabscence_id"
              :options="typesabscencesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.typesabscence_id" class="invalid-feedback">
            <template v-for=" error in errors.typesabscence_id"> {{ error[0] }}</template>

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
  name: 'EditAbscences',
  components: {VSelect, Files},
  props: ['data', 'gridApi', 'modalFormId',
    'typesabscencesData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        user_id: "",

        raison: "",

        debut: "",

        fin: "",

        etats: "",

        typesabscence_id: "",

        extra_attributes: "",

        created_at: "",

        updated_at: "",

        deleted_at: "",
      }
    }
  },

  mounted() {
    this.form = this.data
    this.form['debut'] = this.form['debut'].split(' ')[0]
    this.form['fin'] = this.form['fin'].split(' ')[0]
  },
  methods: {

    EditLine() {
      this.isLoading = true
      this.axios.post('/api/abscences/' + this.form.id + '/update', this.form).then(response => {
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
      this.axios.post('/api/abscences/' + this.form.id + '/delete').then(response => {
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
