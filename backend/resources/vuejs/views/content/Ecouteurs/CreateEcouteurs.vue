<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div class="form-group">
          <label>avant </label>
          <input v-model="form.avant" :class="errors.avant?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.avant" class="invalid-feedback">
            <template v-for=" error in errors.avant"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>apres </label>
          <input v-model="form.apres" :class="errors.apres?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.apres" class="invalid-feedback">
            <template v-for=" error in errors.apres"> {{ error[0] }}</template>

          </div>
        </div>


        <div class="form-group">
          <label>attribut </label>
          <input v-model="form.attribut" :class="errors.attribut?'form-control is-invalid':'form-control'"
                 type="text">

          <div v-if="errors.attribut" class="invalid-feedback">
            <template v-for=" error in errors.attribut"> {{ error[0] }}</template>

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
  name: 'CreateEcouteurs',
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

        avant: "",

        apres: "",

        attribut: "",

        created_at: "",

        updated_at: "",

        agent_id: "",

        user_id: "",

        extra_attributes: "",

        deleted_at: "",
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      this.axios.post('/api/ecouteurs', this.form).then(response => {
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
        avant: "",
        apres: "",
        attribut: "",
        created_at: "",
        updated_at: "",
        agent_id: "",
        user_id: "",
        extra_attributes: "",
        deleted_at: "",
      }
    }
  }
}
</script>
