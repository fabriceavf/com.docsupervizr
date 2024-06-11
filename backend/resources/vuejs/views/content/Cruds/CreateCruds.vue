<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>action </label>
          <input v-model="form.action" :class="errors.action?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.action" class="invalid-feedback">
            <template v-for=" error in errors.action"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>entite </label>
          <input v-model="form.entite" :class="errors.entite?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.entite" class="invalid-feedback">
            <template v-for=" error in errors.entite"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>entite_cle </label>
          <input v-model="form.entite_cle" :class="errors.entite_cle?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.entite_cle" class="invalid-feedback">
            <template v-for=" error in errors.entite_cle"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>ancien </label>
          <input v-model="form.ancien" :class="errors.ancien?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.ancien" class="invalid-feedback">
            <template v-for=" error in errors.ancien"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>nouveau </label>
          <input v-model="form.nouveau" :class="errors.nouveau?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.nouveau" class="invalid-feedback">
            <template v-for=" error in errors.nouveau"> {{ error[0] }}</template>

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
  name: 'CreateCruds',
  components: {VSelect, Files},
  props: [
    'gridApi',
    'modalFormId',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        action: "",

        entite: "",

        entite_cle: "",

        ancien: "",

        nouveau: "",

        user_id: "",

        created_at: "",

        updated_at: "",

        deleted_at: "",

        extra_attributes: "",
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.axios.post('/api/cruds', this.form).then(response => {
        this.isLoading = false
        this.resetForm()
        this.gridApi.applyServerSideTransaction({
          add: [
            response.data
          ],
        });
        this.gridApi.refreshServerSide()
        this.$bvModal.hide(this.modalFormId)
        this.$toast.success('Operation effectuer avec succes')
        this.$emit('close')
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
        action: "",
        entite: "",
        entite_cle: "",
        ancien: "",
        nouveau: "",
        user_id: "",
        created_at: "",
        updated_at: "",
        deleted_at: "",
        extra_attributes: "",
      }
    }
  }
}
</script>
