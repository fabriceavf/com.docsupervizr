<template>
  <b-overlay :show="isLoading">
    <form class="pb-5" @submit.prevent="createLine()">
      <div class="row">
        <div class="form-group col-md-4">
          <label>Semaine <span class="text-danger">*</span></label>
          <input v-model="form.semaine" class="form-control" required type="week">
        </div>

        <div class="form-group col-md-8">
          <label>Superviseur <span class="text-danger">*</span></label>
          <v-select :options="employes" label="name" @input="setSuperviseur"/>
        </div>

        <div class="form-group col-md-12">
          <label>Tache <span class="text-danger">*</span></label>
          <v-select :options="taches" label="libelle" @input="setTache"/>
        </div>
      </div>

      <button class="btn btn-primary mt-3 mb-5" type="submit">
        <i class="fas fa-floppy-disk"></i> Créer
      </button>
    </form>
  </b-overlay>
</template>

<script>
import $ from 'jquery'
import VSelect from 'vue-select'

export default {
  name: 'CreateProgrammation',
  components: {VSelect},
  props: ['table'],
  data() {
    return {
      errors: [],
      isLoading: false,
      employes: [],
      taches: [],
      form: {
        semaine: '',
        tache_id: '',
        superviseur: ''
      }
    }
  },
  mounted() {
    this.getEmployes()
    this.getTaches()
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.axios.post('/api/programmations', this.form).then(response => {
        this.isLoading = false
        this.resetForm()
        $('#close_modal_new-programmation').click()
        $('#refresh' + this.table).click()
        this.$toast.success('Nouvelle programmation ajouté')
        console.log(response.data)
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

