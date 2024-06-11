<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="form-group">
        <label>Code <span class="text-danger">*</span></label>
        <input v-model="form.code" class="form-control" required type="text">
      </div>
      <div class="form-group">
        <label>Libelle <span class="text-danger">*</span></label>
        <input v-model="form.libelle" class="form-control" required type="text">
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
  name: 'CreateService',
  props: ['services', 'table'],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {
        code: '',
        libelle: ''
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.axios.post('/api/services', this.form).then(response => {
        this.isLoading = false
        this.resetForm()
        $('#close_modal_new-service').click()
        $('#refresh' + this.table).click()
        this.$toast.success('Nouveau service ajouté')
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
        libelle: ''
      }
    }

  }
}
</script>
