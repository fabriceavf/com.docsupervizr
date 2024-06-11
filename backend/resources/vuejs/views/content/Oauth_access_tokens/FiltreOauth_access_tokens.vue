<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('name')" class="form-group">
          <label>name </label>
          <input v-model="form.name" class="form-control"
                 type="text">

          <div v-if="errors.name" class='div-error' show variant="danger">
            {{ errors.name }}
          </div>
        </div>


        <div v-if="canShowFilter('scopes')" class="form-group">
          <label>scopes </label>
          <input v-model="form.scopes" class="form-control"
                 type="text">

          <div v-if="errors.scopes" class='div-error' show variant="danger">
            {{ errors.scopes }}
          </div>
        </div>


        <div v-if="canShowFilter('revoked')" class="form-group">
          <label>revoked </label>
          <input v-model="form.revoked" class="form-control"
                 type="text">

          <div v-if="errors.revoked" class='div-error' show variant="danger">
            {{ errors.revoked }}
          </div>
        </div>


        <div v-if="canShowFilter('expires_at')" class="form-group">
          <label>expires_at </label>
          <input v-model="form.expires_at" class="form-control"
                 type="text">

          <div v-if="errors.expires_at" class='div-error' show variant="danger">
            {{ errors.expires_at }}
          </div>
        </div>


        <div class="form-group">
          <label>clients </label>
          <v-select
              v-model="form.client_id"
              :options="clientsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
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
  name: 'FiltreOauth_access_tokens',
  components: {VSelect, Files},
  props: [
    'table',
    'clientsData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        user_id: "",

        client_id: "",

        name: "",

        scopes: "",

        revoked: "",

        created_at: "",

        updated_at: "",

        expires_at: "",

        extra_attributes: "",

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
