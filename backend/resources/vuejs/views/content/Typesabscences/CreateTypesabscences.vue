<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>libelle </label>
          <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.libelle" class="invalid-feedback">
            <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>nombrejours </label>
          <input v-model="form.nombrejours" :class="errors.nombrejours?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.nombrejours" class="invalid-feedback">
            <template v-for=" error in errors.nombrejours"> {{ error[0] }}</template>

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
          <label>soldables </label>
          <v-select
              v-model="form.soldable_id"
              :options="soldablesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.soldable_id" class="invalid-feedback">
            <template v-for=" error in errors.soldable_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>temps modifiable </label>
          <v-select
              v-model="form.variable_id"
              :options="variablesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.variable_id" class="invalid-feedback">
            <template v-for=" error in errors.variable_id"> {{ error[0] }}</template>

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
  name: 'CreateTypesabscences',
  components: {VSelect, Files},
  props: [
    'gridApi',
    'modalFormId',
    'soldablesData',
    'variablesData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        libelle: "",

        soldable_id: "",

        variable_id: "",

        nombrejours: "",

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
      this.axios.post('/api/typesabscences', this.form).then(response => {
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
        libelle: "",
        soldable_id: "",
        variable_id: "",
        nombrejours: "",
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
