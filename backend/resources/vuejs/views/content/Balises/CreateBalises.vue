<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>ref </label>
          <input v-model="form.ref" :class="errors.ref?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.ref" class="invalid-feedback">
            <template v-for=" error in errors.ref"> {{ error[0] }}</template>

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
          <label>lat </label>
          <input v-model="form.lat" :class="errors.lat?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lat" class="invalid-feedback">
            <template v-for=" error in errors.lat"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>lng </label>
          <input v-model="form.lng" :class="errors.lng?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.lng" class="invalid-feedback">
            <template v-for=" error in errors.lng"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>course </label>
          <input v-model="form.course" :class="errors.course?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.course" class="invalid-feedback">
            <template v-for=" error in errors.course"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>speed </label>
          <input v-model="form.speed" :class="errors.speed?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.speed" class="invalid-feedback">
            <template v-for=" error in errors.speed"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>icon_color </label>
          <input v-model="form.icon_color" :class="errors.icon_color?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.icon_color" class="invalid-feedback">
            <template v-for=" error in errors.icon_color"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>imei </label>
          <input v-model="form.imei" :class="errors.imei?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.imei" class="invalid-feedback">
            <template v-for=" error in errors.imei"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>heure </label>
          <input v-model="form.heure" :class="errors.heure?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.heure" class="invalid-feedback">
            <template v-for=" error in errors.heure"> {{ error[0] }}</template>

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
  name: 'CreateBalises',
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

        ref: "",

        libelle: "",

        lat: "",

        lng: "",

        course: "",

        speed: "",

        icon_color: "",

        imei: "",

        heure: "",

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
      this.axios.post('/api/balises', this.form).then(response => {
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
        ref: "",
        libelle: "",
        lat: "",
        lng: "",
        course: "",
        speed: "",
        icon_color: "",
        imei: "",
        heure: "",
        created_at: "",
        updated_at: "",
        extra_attributes: "",
        deleted_at: "",
      }
    }
  }
}
</script>
