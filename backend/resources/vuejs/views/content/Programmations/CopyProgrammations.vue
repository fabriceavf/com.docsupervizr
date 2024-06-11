<template>
  <b-overlay :show="isLoading">

    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>semaine </label>
          <input v-model="form.semaine" :class="errors.semaine?'form-control is-invalid':'form-control'"
                 type="week">

          <div v-if="errors.semaine" class="invalid-feedback">
            <template v-for=" error in errors.semaine"> {{ error[0] }}</template>

          </div>
        </div>
        <div class="form-group">
          <label>superviseur </label>
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
          <i class="fas fa-floppy-disk"></i> Creer
        </button>
      </div>
    </form>
  </b-overlay>
</template>

<script>
import VSelect from 'vue-select'

export default {
  name: 'CopyProgrammations',
  props: ['data', 'gridApi', 'modalFormId', 'usersData', 'tachesData'],
  components: {VSelect},
  data() {
    return {
      errors: [],
      isLoading: false,
      employes: [],
      taches: [],
      programmation_id: 0,
      form: {
        programmation_id: '',
        semaine: '',
        superviseur: '',
        user_id: ''
      }
    }
  },
  mounted() {
    this.getEmployes()
    this.getTaches()
    this.programmation_id = this.data.id
    this.form.programmation_id = this.data.id
    this.form.superviseur = this.data.user_id
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.axios.post('/api/programmationsActionDupliquer', this.form).then(response => {
    //   this.axios.post('/api/programmations/action?action=dupliquer', this.form).then(response => {
        this.isLoading = false
        this.gridApi.refreshServerSide()
        this.$bvModal.hide(this.modalFormId)
        this.$emit('close')
        this.$toast.success('Operation effectuer avec succes')
        this.$toast.success('Programmation ajouté à partir d\'une autre')
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    getEmployes() {
      this.isLoading = true
      this.axios.get('/api/employes').then((response) => {
        this.employes = response.data
        this.isLoading = false
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },
    getTaches() {
      this.isLoading = true
      this.axios.get('/api/taches').then((response) => {
        this.taches = response.data
        this.isLoading = false
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },
    resetForm() {
      this.form = {
        semaine: '',
        tache_id: '',
        superviseur: ''
      }
    },
    setSuperviseur(value) {
      if (value) this.form.superviseur = value.name
    },
    setTache(value) {
      if (value) this.form.tache_id = value.id
    }
  }
}
</script>
