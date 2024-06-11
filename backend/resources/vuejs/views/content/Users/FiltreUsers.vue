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


        <div v-if="canShowFilter('email')" class="form-group">
          <label>email </label>
          <input v-model="form.email" class="form-control"
                 type="text">

          <div v-if="errors.email" class='div-error' show variant="danger">
            {{ errors.email }}
          </div>
        </div>


        <div v-if="canShowFilter('password')" class="form-group">
          <label>password </label>
          <input v-model="form.password" class="form-control"
                 type="text">

          <div v-if="errors.password" class='div-error' show variant="danger">
            {{ errors.password }}
          </div>
        </div>


        <div v-if="canShowFilter('matricule')" class="form-group">
          <label>matricule </label>
          <input v-model="form.matricule" class="form-control"
                 type="text">

          <div v-if="errors.matricule" class='div-error' show variant="danger">
            {{ errors.matricule }}
          </div>
        </div>


        <div v-if="canShowFilter('emp_code')" class="form-group">
          <label>emp_code </label>
          <input v-model="form.emp_code" class="form-control"
                 type="text">

          <div v-if="errors.emp_code" class='div-error' show variant="danger">
            {{ errors.emp_code }}
          </div>
        </div>


        <div v-if="canShowFilter('nom')" class="form-group">
          <label>nom </label>
          <input v-model="form.nom" class="form-control"
                 type="text">

          <div v-if="errors.nom" class='div-error' show variant="danger">
            {{ errors.nom }}
          </div>
        </div>


        <div v-if="canShowFilter('prenom')" class="form-group">
          <label>prenom </label>
          <input v-model="form.prenom" class="form-control"
                 type="text">

          <div v-if="errors.prenom" class='div-error' show variant="danger">
            {{ errors.prenom }}
          </div>
        </div>


        <div v-if="canShowFilter('num_badge')" class="form-group">
          <label>num_badge </label>
          <input v-model="form.num_badge" class="form-control"
                 type="text">

          <div v-if="errors.num_badge" class='div-error' show variant="danger">
            {{ errors.num_badge }}
          </div>
        </div>


        <div v-if="canShowFilter('date_naissance')" class="form-group">
          <label>date_naissance </label>
          <input v-model="form.date_naissance" class="form-control"
                 type="date">

          <div v-if="errors.date_naissance" class='div-error' show variant="danger">
            {{ errors.date_naissance }}
          </div>
        </div>


        <div v-if="canShowFilter('num_cnss')" class="form-group">
          <label>num_cnss </label>
          <input v-model="form.num_cnss" class="form-control"
                 type="text">

          <div v-if="errors.num_cnss" class='div-error' show variant="danger">
            {{ errors.num_cnss }}
          </div>
        </div>


        <div v-if="canShowFilter('num_cnamgs')" class="form-group">
          <label>num_cnamgs </label>
          <input v-model="form.num_cnamgs" class="form-control"
                 type="text">

          <div v-if="errors.num_cnamgs" class='div-error' show variant="danger">
            {{ errors.num_cnamgs }}
          </div>
        </div>


        <div v-if="canShowFilter('telephone1')" class="form-group">
          <label>telephone1 </label>
          <input v-model="form.telephone1" class="form-control"
                 type="text">

          <div v-if="errors.telephone1" class='div-error' show variant="danger">
            {{ errors.telephone1 }}
          </div>
        </div>


        <div v-if="canShowFilter('telephone2')" class="form-group">
          <label>telephone2 </label>
          <input v-model="form.telephone2" class="form-control"
                 type="text">

          <div v-if="errors.telephone2" class='div-error' show variant="danger">
            {{ errors.telephone2 }}
          </div>
        </div>


        <div v-if="canShowFilter('nombre_enfant')" class="form-group">
          <label>nombre_enfant </label>
          <input v-model="form.nombre_enfant" class="form-control"
                 type="text">

          <div v-if="errors.nombre_enfant" class='div-error' show variant="danger">
            {{ errors.nombre_enfant }}
          </div>
        </div>


        <div v-if="canShowFilter('photo')" class="form-group">
          <label>photo </label>
          <input v-model="form.photo" class="form-control"
                 type="text">

          <div v-if="errors.photo" class='div-error' show variant="danger">
            {{ errors.photo }}
          </div>
        </div>


        <div v-if="canShowFilter('date_embauche')" class="form-group">
          <label>date_embauche </label>
          <input v-model="form.date_embauche" class="form-control"
                 type="date">

          <div v-if="errors.date_embauche" class='div-error' show variant="danger">
            {{ errors.date_embauche }}
          </div>
        </div>


        <div class="form-group">
          <label>actifs </label>
          <v-select
              v-model="form.actif_id"
              :options="actifsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>contrats </label>
          <v-select
              v-model="form.contrat_id"
              :options="contratsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>fonctions </label>
          <v-select
              v-model="form.fonction_id"
              :options="fonctionsData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>matrimoniales </label>
          <v-select
              v-model="form.matrimoniale_id"
              :options="matrimonialesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>nationalites </label>
          <v-select
              v-model="form.nationalite_id"
              :options="nationalitesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>onlines </label>
          <v-select
              v-model="form.online_id"
              :options="onlinesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>sexes </label>
          <v-select
              v-model="form.sexe_id"
              :options="sexesData"
              :reduce="ele => ele.id"
              label="Selectlabel"
              multiple
          />
        </div>


        <div class="form-group">
          <label>types </label>
          <v-select
              v-model="form.type_id"
              :options="typesData"
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
  name: 'FiltreUsers',
  components: {VSelect, Files},
  props: [
    'table',
    'actifsData',
    'contratsData',
    'fonctionsData',
    'matrimonialesData',
    'nationalitesData',
    'onlinesData',
    'sexesData',
    'typesData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        name: "",

        email: "",

        email_verified_at: "",

        password: "",

        matricule: "",

        emp_code: "",

        nom: "",

        prenom: "",

        num_badge: "",

        date_naissance: "",

        num_cnss: "",

        num_cnamgs: "",

        telephone1: "",

        telephone2: "",

        nationalite_id: "",

        nombre_enfant: "",

        photo: "",

        actif_id: "",

        online_id: "",

        date_embauche: "",

        sexe_id: "",

        type_id: "",

        contrat_id: "",

        matrimoniale_id: "",

        fonction_id: "",

        user_id: "",

        remember_token: "",

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
