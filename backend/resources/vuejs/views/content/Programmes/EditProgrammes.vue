<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="EditLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>dimanche </label>
          <input v-model="form.dimanche" :class="errors.dimanche?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.dimanche" class="invalid-feedback">
            <template v-for=" error in errors.dimanche"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lundi </label>
          <input v-model="form.lundi" :class="errors.lundi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lundi" class="invalid-feedback">
            <template v-for=" error in errors.lundi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mardi </label>
          <input v-model="form.mardi" :class="errors.mardi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mardi" class="invalid-feedback">
            <template v-for=" error in errors.mardi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>mercredi </label>
          <input v-model="form.mercredi" :class="errors.mercredi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.mercredi" class="invalid-feedback">
            <template v-for=" error in errors.mercredi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>jeudi </label>
          <input v-model="form.jeudi" :class="errors.jeudi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.jeudi" class="invalid-feedback">
            <template v-for=" error in errors.jeudi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>vendredi </label>
          <input v-model="form.vendredi" :class="errors.vendredi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.vendredi" class="invalid-feedback">
            <template v-for=" error in errors.vendredi"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>samedi </label>
          <input v-model="form.samedi" :class="errors.samedi?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.samedi" class="invalid-feedback">
            <template v-for=" error in errors.samedi"> {{ error[0] }}</template>

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
          <label>actif </label>
          <input v-model="form.actif" :class="errors.actif?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.actif" class="invalid-feedback">
            <template v-for=" error in errors.actif"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>programmations </label>
          <v-select
              v-model="form.programmation_id"
              :options="programmationsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.programmation_id" class="invalid-feedback">
            <template v-for=" error in errors.programmation_id"> {{ error[0] }}</template>

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

      <div class="d-flex justify-content-between">
        <button class="btn btn-primary" type="submit">
          <i class="fas fa-floppy-disk"></i> Mettre à jour
        </button>
        <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
          <i class="fas fa-close"></i> Supprimer
        </button>
      </div>
    </form>
  </b-overlay>
</template>

<script>
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
  name: 'EditProgrammes',
  components: {VSelect, Files},
  props: ['data', 'gridApi', 'modalFormId',
    'programmationsData',
    'tachesData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        dimanche: "",

        lundi: "",

        mardi: "",

        mercredi: "",

        jeudi: "",

        vendredi: "",

        samedi: "",

        statut: "",

        actif: "",

        tache_id: "",

        programmation_id: "",

        user_id: "",

        extra_attributes: "",

        created_at: "",

        updated_at: "",

        deleted_at: "",
      }
    }
  },

  mounted() {
    this.form = this.data
  },
  methods: {

    EditLine() {
      this.isLoading = true
      this.axios.post('/api/programmes/' + this.form.id + '/update', this.form).then(response => {
        this.isLoading = false
        this.gridApi.applyServerSideTransaction({
          update: [
            response.data
          ],
        });
        this.$bvModal.hide(this.modalFormId)
        this.$toast.success('Operation effectuer avec succes')
        console.log(response.data)
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    DeleteLine() {
      this.isLoading = true
      this.axios.post('/api/programmes/' + this.form.id + '/delete').then(response => {
        this.isLoading = false

        this.gridApi.applyServerSideTransaction({
          remove: [
            this.form
          ]
        });
        this.gridApi.refreshServerSide()
        this.$bvModal.hide(this.modalFormId)
        this.$toast.success('Operation effectuer avec succes')
        console.log(response.data)
      }).catch(error => {
        console.log(error.response.data)
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de la suppression')
      })
    },
  }
}
</script>
