<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>semaine </label>
          <input v-model="form.semaine" :class="errors.semaine?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.semaine" class="invalid-feedback">
            <template v-for=" error in errors.semaine"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>date_debut </label>
          <input v-model="form.date_debut" :class="errors.date_debut?'form-control is-invalid':'form-control'"
                 type="date">

          <div v-if="errors.date_debut" class="invalid-feedback">
            <template v-for=" error in errors.date_debut"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>date_fin </label>
          <input v-model="form.date_fin" :class="errors.date_fin?'form-control is-invalid':'form-control'"
                 type="date">

          <div v-if="errors.date_fin" class="invalid-feedback">
            <template v-for=" error in errors.date_fin"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>statut </label>
          <input v-model="form.statut" :class="errors.statut?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.statut" class="invalid-feedback">
            <template v-for=" error in errors.statut"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>taches </label>
          <v-select
              v-model="form.tache_id"
              :options="tachesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.tache_id" class="invalid-feedback">
            <template v-for=" error in errors.tache_id"> {{ error[0] }}</template>

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
  name: 'CreateProgrammations',
  components: {VSelect, Files},
  props: [
    'gridApi',
    'modalFormId',
    'tachesData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        semaine: "",

        date_debut: "",

        date_fin: "",

        user_id: "",

        tache_id: "",

        statut: "",

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
      this.axios.post('/api/programmations', this.form).then(response => {
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
        semaine: "",
        date_debut: "",
        date_fin: "",
        user_id: "",
        tache_id: "",
        statut: "",
        extra_attributes: "",
        created_at: "",
        updated_at: "",
        deleted_at: "",
      }
    }
  }
}
</script>
