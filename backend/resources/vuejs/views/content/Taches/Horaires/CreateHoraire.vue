<template>
  <b-overlay :show="isLoading">
    <form class="mb-3" @submit.prevent="createLine()">
      <div class="form-group ">
        <label>Libelle <span class="text-danger">*</span></label>
        <input v-model="form.libelle" class="form-control" required type="text">
      </div>

      <div class="row ">
        <div class="form-group col-4">
          <label>Debut <span class="text-danger">*</span></label>
          <input v-model="form.debut" class="form-control" required type="time">
        </div>
        <div class="form-group col-4">
          <label>Fin <span class="text-danger">*</span></label>
          <input v-model="form.fin" class="form-control" required type="time">
        </div>
        <div class="form-group col-4">
          <label>Tolérance <span class="text-danger">*</span></label>
          <input v-model="form.tolerance" class="form-control" required type="number">
        </div>
      </div>

      <button class="btn btn-primary btn-sm float-right" type="submit">
        <i class="fas fa-floppy-disk"></i> Ajouter
      </button>
    </form>
  </b-overlay>
</template>

<script>

export default {
  name: 'CreateHoraire',
  props: ['tache_id'],
  mounted() {
  },
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {
        user_id: 0,
        debut: '',
        fin: '',
        libelle: '',
        type: '',
        tolerance: '0',
        tache_id: this.tache_id
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.form['tache_id'] = this.tache_id
      this.axios.post('/api/horaires', this.form).then(response => {
        this.isLoading = false
        this.$emit('refreshHoraire', response.data)
        this.resetForm()
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    resetForm() {
      this.form = {
        user_id: 0,
        debut: '',
        fin: '',
        libelle: '',
        type: '',
        tolerance: '0',
        tache_id: this.tache_id
      }
    }
  }
}
</script>
