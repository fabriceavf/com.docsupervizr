<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>name </label>
          <input v-model="form.name" :class="errors.name?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.name" class="invalid-feedback">
            <template v-for=" error in errors.name"> {{ error[0] }}</template>

          </div>
        </div>


        <!--        <div class="form-group">-->
        <!--          <label>guard_name </label>-->
        <!--          <input v-model="form.guard_name" :class="errors.guard_name?'form-control is-invalid':'form-control'"-->
        <!--                 type="text">-->

        <!--          <div v-if="errors.guard_name" class="invalid-feedback">-->
        <!--            <template v-for=" error in errors.guard_name"> {{ error[0] }}</template>-->

        <!--          </div>-->
        <!--        </div>-->


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
  name: 'CreatePermissions',
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

        name: "",

        guard_name: "api",

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
      this.axios.post('/api/permissions', this.form).then(response => {
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
        name: "",
        guard_name: "",
        created_at: "",
        updated_at: "",
        deleted_at: "",
        extra_attributes: "",
      }
    }
  }
}
</script>
