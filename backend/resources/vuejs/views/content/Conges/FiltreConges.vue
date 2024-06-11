<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('raison')" class="form-group">
          <label>raison </label>
          <input v-model="form.raison" class="form-control"
                 type="text">

          <div v-if="errors.raison" class='div-error' show variant="danger">
            {{ errors.raison }}
          </div>
        </div>


        <div v-if="canShowFilter('debut')" class="form-group">
          <label>debut </label>
          <input v-model="form.debut" class="form-control"
                 type="date">

          <div v-if="errors.debut" class='div-error' show variant="danger">
            {{ errors.debut }}
          </div>
        </div>


        <div v-if="canShowFilter('fin')" class="form-group">
          <label>fin </label>
          <input v-model="form.fin" class="form-control"
                 type="date">

          <div v-if="errors.fin" class='div-error' show variant="danger">
            {{ errors.fin }}
          </div>
        </div>


        <div v-if="canShowFilter('etats')" class="form-group">
          <label>etats </label>
          <input v-model="form.etats" class="form-control"
                 type="text">

          <div v-if="errors.etats" class='div-error' show variant="danger">
            {{ errors.etats }}
          </div>
        </div>


        <div class="form-group">
          <label>users </label>
          <v-select
              v-model="form.user_id"
              :options="usersData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>

      </div>

      <button class="btn btn-primary" type="submit">
        <i class="fas fas fa-search"></i> Appliquer
      </button>
    </form>
  </b-overlay>
</template>

<script>
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
  name: 'FiltreConges',
  components: {VSelect, Files},
  props: [
    'table',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        user_id: "",

        raison: "",

        debut: "",

        fin: "",

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
      this.$emit('applyfilter', this.form)
    },
    canShowFilter(name) {
      let can = true
      const queryString = window.location.search
      const urlParams = new URLSearchParams(queryString);
      if (urlParams.has(`filter_${name}`)) {
        can = false
      }
      return can
    }
  }
}
</script>
