<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
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


      </div>

      <button class="btn btn-primary" type="submit">
        <i class="fas fa-floppy-disk"></i> Créer
      </button>
    </form>
  </b-overlay>
</template>

<script>
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
  name: 'CreateJoursferies',
  components: {VSelect, Files},
  props: [
    'gridApi',
    'modalFormId',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        raison: "",

        debut: "",

        fin: "",

        etats: "",

        extra_attributes: "",

        created_at: "",

        updated_at: "",

        deleted_at: "",
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.axios.post('/api/joursferies', this.form).then(response => {
        this.isLoading = false
        this.resetForm()
        this.gridApi.applyServerSideTransaction({
          add: [
            response.data
          ],
        });
        this.gridApi.refreshServerSide()
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
    resetForm() {
      this.form = {
        id: "",
        raison: "",
        debut: "",
        fin: "",
        etats: "",
        extra_attributes: "",
        created_at: "",
        updated_at: "",
        deleted_at: "",
      }
    }
  }
}
</script>
