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
          <label>typestaches </label>
          <v-select
              v-model="form.typestache_id"
              :options="typestachesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.typestache_id" class="invalid-feedback">
            <template v-for=" error in errors.typestache_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>villes </label>
          <v-select
              v-model="form.ville_id"
              :options="villesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.ville_id" class="invalid-feedback">
            <template v-for=" error in errors.ville_id"> {{ error[0] }}</template>

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
  name: 'CreateTaches',
  components: {VSelect, Files},
  props: [
    'gridApi',
    'modalFormId',
    'typestachesData',
    'villesData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        typestache_id: "",

        libelle: "",

        ville_id: "",

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
      this.axios.post('/api/taches', this.form).then(response => {
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
        typestache_id: "",
        libelle: "",
        ville_id: "",
        extra_attributes: "",
        created_at: "",
        updated_at: "",
        deleted_at: "",
      }
    }
  }
}
</script>
