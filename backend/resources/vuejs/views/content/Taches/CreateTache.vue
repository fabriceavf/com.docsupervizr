<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">
        <div class="form-group ">
          <label>Libelle</label>
          <input v-model="form.libelle" class="form-control" type="text">
        </div>

        <div class="form-group">
          <div class="form-check">
            <input id="1" v-model="form.type" checked class="form-check-input" type="radio" value="Collecte">
            <label class="form-check-label" for="1">
              Collecte
            </label>
          </div>
          <div class="form-check">
            <input id="2" v-model="form.type" class="form-check-input" type="radio" value="Atelier">
            <label class="form-check-label" for="2">
              Atelier
            </label>
          </div>
          <div class="form-check">
            <input id="3" v-model="form.type" class="form-check-input" type="radio" value="Administratif">
            <label class="form-check-label" for="3">
              Administratif
            </label>
          </div>
        </div>

        <div class="form-group">
          <label>Ville</label>
          <select v-model="form.ville_id" class="form-control">
            <option v-for="ville in this.villes" :key="ville.id" :value="ville.id">{{ ville.libelle }}</option>
          </select>
        </div>
      </div>

      <button class="btn btn-primary" type="submit">
        <i class="fas fa-floppy-disk"></i> Créer
      </button>
    </form>
  </b-overlay>
</template>

<script>
import $ from 'jquery'

export default {
  name: 'CreateTache',
  props: ['villes', 'table'],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {
        code: '',
        libelle: '',
        service_id: ''
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.axios.post('/api/taches', this.form).then(response => {
        this.isLoading = false
        this.resetForm()
        $('#close_modal_new-tache').click()
        $('#refresh' + this.table).click()
        this.$toast.success('Nouvelle tache ajouté')
        console.log(response.data)
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    resetForm() {
      this.form = {
        code: '',
        libelle: '',
        service_id: ''
      }
    }
  }
}
</script>
