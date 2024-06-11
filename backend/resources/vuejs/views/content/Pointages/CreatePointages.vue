<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>pointeuse </label>
          <input v-model="form.pointeuse" :class="errors.pointeuse?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.pointeuse" class="invalid-feedback">
            <template v-for=" error in errors.pointeuse"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lieu </label>
          <input v-model="form.lieu" :class="errors.lieu?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lieu" class="invalid-feedback">
            <template v-for=" error in errors.lieu"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>debut_prevu </label>
          <input v-model="form.debut_prevu" :class="errors.debut_prevu?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.debut_prevu" class="invalid-feedback">
            <template v-for=" error in errors.debut_prevu"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>fin_prevu </label>
          <input v-model="form.fin_prevu" :class="errors.fin_prevu?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.fin_prevu" class="invalid-feedback">
            <template v-for=" error in errors.fin_prevu"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>faction_horaire </label>
          <input v-model="form.faction_horaire" :class="errors.faction_horaire?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.faction_horaire" class="invalid-feedback">
            <template v-for=" error in errors.faction_horaire"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>debut_reel </label>
          <input v-model="form.debut_reel" :class="errors.debut_reel?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.debut_reel" class="invalid-feedback">
            <template v-for=" error in errors.debut_reel"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>debut_realise </label>
          <input v-model="form.debut_realise" :class="errors.debut_realise?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.debut_realise" class="invalid-feedback">
            <template v-for=" error in errors.debut_realise"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>fin_realise </label>
          <input v-model="form.fin_realise" :class="errors.fin_realise?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.fin_realise" class="invalid-feedback">
            <template v-for=" error in errors.fin_realise"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>volume_realise </label>
          <input v-model="form.volume_realise" :class="errors.volume_realise?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.volume_realise" class="invalid-feedback">
            <template v-for=" error in errors.volume_realise"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>emp_code </label>
          <input v-model="form.emp_code" :class="errors.emp_code?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.emp_code" class="invalid-feedback">
            <template v-for=" error in errors.emp_code"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>motif </label>
          <input v-model="form.motif" :class="errors.motif?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.motif" class="invalid-feedback">
            <template v-for=" error in errors.motif"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>volume_prevu </label>
          <input v-model="form.volume_prevu" :class="errors.volume_prevu?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.volume_prevu" class="invalid-feedback">
            <template v-for=" error in errors.volume_prevu"> {{ error[0] }}</template>

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
          <label>est_valide </label>
          <input v-model="form.est_valide" :class="errors.est_valide?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.est_valide" class="invalid-feedback">
            <template v-for=" error in errors.est_valide"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>tolerance </label>
          <input v-model="form.tolerance" :class="errors.tolerance?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.tolerance" class="invalid-feedback">
            <template v-for=" error in errors.tolerance"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>est_attendu </label>
          <input v-model="form.est_attendu" :class="errors.est_attendu?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.est_attendu" class="invalid-feedback">
            <template v-for=" error in errors.est_attendu"> {{ error[0] }}</template>

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
          <label>horaires </label>
          <v-select
              v-model="form.horaire_id"
              :options="horairesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.horaire_id" class="invalid-feedback">
            <template v-for=" error in errors.horaire_id"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>programmes </label>
          <v-select
              v-model="form.programme_id"
              :options="programmesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
          />
          <div v-if="errors.programme_id" class="invalid-feedback">
            <template v-for=" error in errors.programme_id"> {{ error[0] }}</template>

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
  name: 'CreatePointages',
  components: {VSelect, Files},
  props: [
    'gridApi',
    'modalFormId',
    'horairesData',
    'programmesData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        pointeuse: "",

        lieu: "",

        debut_prevu: "",

        fin_prevu: "",

        faction_horaire: "",

        debut_reel: "",

        debut_realise: "",

        fin_realise: "",

        volume_realise: "",

        emp_code: "",

        motif: "",

        volume_prevu: "",

        actif: "",

        est_valide: "",

        horaire_id: "",

        programme_id: "",

        tolerance: "",

        est_attendu: "",

        etats: "",

        user_id: "",

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
      this.axios.post('/api/pointages', this.form).then(response => {
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
        pointeuse: "",
        lieu: "",
        debut_prevu: "",
        fin_prevu: "",
        faction_horaire: "",
        debut_reel: "",
        debut_realise: "",
        fin_realise: "",
        volume_realise: "",
        emp_code: "",
        motif: "",
        volume_prevu: "",
        actif: "",
        est_valide: "",
        horaire_id: "",
        programme_id: "",
        tolerance: "",
        est_attendu: "",
        etats: "",
        user_id: "",
        extra_attributes: "",
        created_at: "",
        updated_at: "",
        deleted_at: "",
      }
    }
  }
}
</script>
