<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="EditLine()">
      <div class="form-group">
        <label>Raison <span class="text-danger">*</span></label>
        <input v-model="form.raison" class="form-control" required type="text">
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
      <button class="btn btn-primary" type="submit">
        <i class="fas fa-floppy-disk"></i> Plannifier
      </button>
    </form>
  </b-overlay>
</template>

<script>
import $ from 'jquery'

export default {
  name: 'EditJoursferie',
  props: ['formLine', 'employes'],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {
        raison: '',
        debut: '',
        fin: ''
      }
    }
  },
  mounted() {
    this.form = this.formLine[0]
  },
  methods: {
    EditLine() {
      this.isLoading = true
      this.axios.post('/api/joursferies/' + this.formLine[0].id, this.form).then(response => {
        this.isLoading = false
        $('#Joursferies' + this.formLine[0].id).modal('hide')
        $('#refresh').click()
      }).catch(error => {
        console.log(error.response.data)
        this.isLoading = false
      })
    }
  }
}
</script>
