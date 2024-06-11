<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="EditLine()">
      <div class="form-group">
        <label>Employe <span class="text-danger">*</span></label>
        <select v-model="form.user_id" class="form-control">
          <option v-for="employe in this.employes" :key="employe.id" :value="employe.id">{{ employe.name }}</option>
        </select>
      </div>
      <div class="form-group">
        <label>Solder<span class="text-danger">*</span></label>
        <select v-model="form.solder" class="form-control">
          <option v-for="solde in this.soldable" :key="solde.id" :value="solde.value">{{ solde.label }}</option>
        </select>
      </div>
      <div class="form-group">
        <label>Raison <span class="text-danger"></span></label>

        <textarea v-model="form.raison" class="form-control" required type="date"></textarea>
      </div>
      <div class="form-row">
        <div class="form-group col-6">
          <label>Depart <span class="text-danger">*</span></label>
          <input v-model="form.debut" class="form-control" required type="date">
        </div>
        <div class="form-group col-6">
          <label>Retour <span class="text-danger">*</span></label>
          <input v-model="form.fin" class="form-control" required type="date">
        </div>
      </div>
      <div class="d-flex justify-content-between mt-2">
        <button class="btn btn-primary" type="submit">
          <i class="fas fa-floppy-disk"></i> Plannifier
        </button>
        <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
          <i class="fas fa-close"></i> Supprimer
        </button>
      </div>
    </form>
  </b-overlay>
</template>

<script>
import $ from 'jquery'

export default {
  name: 'Editabscence',
  props: ['formLine', 'employes', 'table'],
  data() {
    return {

      soldable: [
        {
          id: 1,
          value: 'avec',
          label: 'Avec solde'
        },
        {
          id: 1,
          value: 'sans',
          label: 'Sans solde'
        }
      ],
      errors: [],
      isLoading: false,
      form: {}
    }
  },
  mounted() {
    this.form = this.formLine[0]
  },
  methods: {
    EditLine() {
      this.isLoading = true
      let sendData = {}
      sendData.user_id = this.form.user_id
      sendData.debut = this.form.debut
      sendData.fin = this.form.fin
      sendData.raison = this.form.raison
      sendData.solder = this.form.solder
      this.axios.post('/api/abscences/' + this.formLine[0].id + '/update', this.form).then(response => {
        this.isLoading = false
        $('#close_modal_abscence' + this.formLine[0].id).click()
        $('#refresh' + this.table).click()
        this.$toast.success('abscence modifié')
        console.log(response.data)
      }).catch(error => {
        console.log(error.response.data)
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    DeleteLine() {
      this.isLoading = true
      this.axios.post('/api/abscences/' + this.formLine[0].id + '/delete').then(response => {
        this.isLoading = false
        $('#close_modal_abscence' + this.formLine[0].id).click()
        $('#refresh' + this.table).click()
        this.$toast.success('abscence supprimé')
        console.log(response.data)
      }).catch(error => {
        console.log(error.response.data)
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de la suppression')
      })
    }
  }
}
</script>
