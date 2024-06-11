<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>code </label>
          <input v-model="form.code" :class="errors.code?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.code" class="invalid-feedback">
            <template v-for=" error in errors.code"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>libelle </label>
          <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.libelle" class="invalid-feedback">
            <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>contrat </label>
          <input v-model="form.contrat" :class="errors.contrat?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.contrat" class="invalid-feedback">
            <template v-for=" error in errors.contrat"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>nature </label>
          <input v-model="form.nature" :class="errors.nature?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.nature" class="invalid-feedback">
            <template v-for=" error in errors.nature"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>coordonnees </label>
          <input v-model="form.coordonnees" :class="errors.coordonnees?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.coordonnees" class="invalid-feedback">
            <template v-for=" error in errors.coordonnees"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>pointeuses </label>
          <v-select
              v-model="form.pointeuse_id"
              :options="pointeusesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.pointeuse_id" class="invalid-feedback">
            <template v-for=" error in errors.pointeuse_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>sites </label>
          <v-select
              v-model="form.site_id"
              :options="sitesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.site_id" class="invalid-feedback">
            <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

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
  name: 'CreatePostes',
  components: {VSelect, Files},
  props: [
    'gridApi',
    'modalFormId',
    'pointeusesData',
    'sitesData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        code: "",

        libelle: "",

        contrat: "",

        nature: "",

        coordonnees: "",

        site_id: "",

        pointeuse_id: "",

        created_at: "",

        updated_at: "",

        extra_attributes: "",

        deleted_at: "",
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.axios.post('/api/postes', this.form).then(response => {
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
        code: "",
        libelle: "",
        contrat: "",
        nature: "",
        coordonnees: "",
        site_id: "",
        pointeuse_id: "",
        created_at: "",
        updated_at: "",
        extra_attributes: "",
        deleted_at: "",
      }
    }
  }
}
</script>
