<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">


        <div v-if="canShowFilter('semaine')" class="form-group">
          <label>semaine </label>
          <input v-model="form.semaine" class="form-control"
                 type="text">

          <div v-if="errors.semaine" class='div-error' show variant="danger">
            {{ errors.semaine }}
          </div>
        </div>


        <div v-if="canShowFilter('dimanche_date')" class="form-group">
          <label>dimanche_date </label>
          <input v-model="form.dimanche_date" class="form-control"
                 type="text">

          <div v-if="errors.dimanche_date" class='div-error' show variant="danger">
            {{ errors.dimanche_date }}
          </div>
        </div>


        <div v-if="canShowFilter('lundi_date')" class="form-group">
          <label>lundi_date </label>
          <input v-model="form.lundi_date" class="form-control"
                 type="text">

          <div v-if="errors.lundi_date" class='div-error' show variant="danger">
            {{ errors.lundi_date }}
          </div>
        </div>


        <div v-if="canShowFilter('mardi_date')" class="form-group">
          <label>mardi_date </label>
          <input v-model="form.mardi_date" class="form-control"
                 type="text">

          <div v-if="errors.mardi_date" class='div-error' show variant="danger">
            {{ errors.mardi_date }}
          </div>
        </div>


        <div v-if="canShowFilter('mercredi_date')" class="form-group">
          <label>mercredi_date </label>
          <input v-model="form.mercredi_date" class="form-control"
                 type="text">

          <div v-if="errors.mercredi_date" class='div-error' show variant="danger">
            {{ errors.mercredi_date }}
          </div>
        </div>


        <div v-if="canShowFilter('jeudi_date')" class="form-group">
          <label>jeudi_date </label>
          <input v-model="form.jeudi_date" class="form-control"
                 type="text">

          <div v-if="errors.jeudi_date" class='div-error' show variant="danger">
            {{ errors.jeudi_date }}
          </div>
        </div>


        <div v-if="canShowFilter('vendredi_date')" class="form-group">
          <label>vendredi_date </label>
          <input v-model="form.vendredi_date" class="form-control"
                 type="text">

          <div v-if="errors.vendredi_date" class='div-error' show variant="danger">
            {{ errors.vendredi_date }}
          </div>
        </div>


        <div v-if="canShowFilter('samedi_date')" class="form-group">
          <label>samedi_date </label>
          <input v-model="form.samedi_date" class="form-control"
                 type="text">

          <div v-if="errors.samedi_date" class='div-error' show variant="danger">
            {{ errors.samedi_date }}
          </div>
        </div>


        <div v-if="canShowFilter('dimanche_horaire')" class="form-group">
          <label>dimanche_horaire </label>
          <input v-model="form.dimanche_horaire" class="form-control"
                 type="text">

          <div v-if="errors.dimanche_horaire" class='div-error' show variant="danger">
            {{ errors.dimanche_horaire }}
          </div>
        </div>


        <div v-if="canShowFilter('lundi_horaire')" class="form-group">
          <label>lundi_horaire </label>
          <input v-model="form.lundi_horaire" class="form-control"
                 type="text">

          <div v-if="errors.lundi_horaire" class='div-error' show variant="danger">
            {{ errors.lundi_horaire }}
          </div>
        </div>


        <div v-if="canShowFilter('mardi_horaire')" class="form-group">
          <label>mardi_horaire </label>
          <input v-model="form.mardi_horaire" class="form-control"
                 type="text">

          <div v-if="errors.mardi_horaire" class='div-error' show variant="danger">
            {{ errors.mardi_horaire }}
          </div>
        </div>


        <div v-if="canShowFilter('mercredi_horaire')" class="form-group">
          <label>mercredi_horaire </label>
          <input v-model="form.mercredi_horaire" class="form-control"
                 type="text">

          <div v-if="errors.mercredi_horaire" class='div-error' show variant="danger">
            {{ errors.mercredi_horaire }}
          </div>
        </div>


        <div v-if="canShowFilter('jeudi_horaire')" class="form-group">
          <label>jeudi_horaire </label>
          <input v-model="form.jeudi_horaire" class="form-control"
                 type="text">

          <div v-if="errors.jeudi_horaire" class='div-error' show variant="danger">
            {{ errors.jeudi_horaire }}
          </div>
        </div>


        <div v-if="canShowFilter('vendredi_horaire')" class="form-group">
          <label>vendredi_horaire </label>
          <input v-model="form.vendredi_horaire" class="form-control"
                 type="text">

          <div v-if="errors.vendredi_horaire" class='div-error' show variant="danger">
            {{ errors.vendredi_horaire }}
          </div>
        </div>


        <div v-if="canShowFilter('samedi_horaire')" class="form-group">
          <label>samedi_horaire </label>
          <input v-model="form.samedi_horaire" class="form-control"
                 type="text">

          <div v-if="errors.samedi_horaire" class='div-error' show variant="danger">
            {{ errors.samedi_horaire }}
          </div>
        </div>


        <div v-if="canShowFilter('dimanche')" class="form-group">
          <label>dimanche </label>
          <input v-model="form.dimanche" class="form-control"
                 type="text">

          <div v-if="errors.dimanche" class='div-error' show variant="danger">
            {{ errors.dimanche }}
          </div>
        </div>


        <div v-if="canShowFilter('lundi')" class="form-group">
          <label>lundi </label>
          <input v-model="form.lundi" class="form-control"
                 type="text">

          <div v-if="errors.lundi" class='div-error' show variant="danger">
            {{ errors.lundi }}
          </div>
        </div>


        <div v-if="canShowFilter('mardi')" class="form-group">
          <label>mardi </label>
          <input v-model="form.mardi" class="form-control"
                 type="text">

          <div v-if="errors.mardi" class='div-error' show variant="danger">
            {{ errors.mardi }}
          </div>
        </div>


        <div v-if="canShowFilter('mercredi')" class="form-group">
          <label>mercredi </label>
          <input v-model="form.mercredi" class="form-control"
                 type="text">

          <div v-if="errors.mercredi" class='div-error' show variant="danger">
            {{ errors.mercredi }}
          </div>
        </div>


        <div v-if="canShowFilter('jeudi')" class="form-group">
          <label>jeudi </label>
          <input v-model="form.jeudi" class="form-control"
                 type="text">

          <div v-if="errors.jeudi" class='div-error' show variant="danger">
            {{ errors.jeudi }}
          </div>
        </div>


        <div v-if="canShowFilter('vendredi')" class="form-group">
          <label>vendredi </label>
          <input v-model="form.vendredi" class="form-control"
                 type="text">

          <div v-if="errors.vendredi" class='div-error' show variant="danger">
            {{ errors.vendredi }}
          </div>
        </div>


        <div v-if="canShowFilter('samedi')" class="form-group">
          <label>samedi </label>
          <input v-model="form.samedi" class="form-control"
                 type="text">

          <div v-if="errors.samedi" class='div-error' show variant="danger">
            {{ errors.samedi }}
          </div>
        </div>


        <div v-if="canShowFilter('dimanche_pointage')" class="form-group">
          <label>dimanche_pointage </label>
          <input v-model="form.dimanche_pointage" class="form-control"
                 type="text">

          <div v-if="errors.dimanche_pointage" class='div-error' show variant="danger">
            {{ errors.dimanche_pointage }}
          </div>
        </div>


        <div v-if="canShowFilter('lundi_pointage')" class="form-group">
          <label>lundi_pointage </label>
          <input v-model="form.lundi_pointage" class="form-control"
                 type="text">

          <div v-if="errors.lundi_pointage" class='div-error' show variant="danger">
            {{ errors.lundi_pointage }}
          </div>
        </div>


        <div v-if="canShowFilter('mardi_pointage')" class="form-group">
          <label>mardi_pointage </label>
          <input v-model="form.mardi_pointage" class="form-control"
                 type="text">

          <div v-if="errors.mardi_pointage" class='div-error' show variant="danger">
            {{ errors.mardi_pointage }}
          </div>
        </div>


        <div v-if="canShowFilter('mercredi_pointage')" class="form-group">
          <label>mercredi_pointage </label>
          <input v-model="form.mercredi_pointage" class="form-control"
                 type="text">

          <div v-if="errors.mercredi_pointage" class='div-error' show variant="danger">
            {{ errors.mercredi_pointage }}
          </div>
        </div>


        <div v-if="canShowFilter('jeudi_pointage')" class="form-group">
          <label>jeudi_pointage </label>
          <input v-model="form.jeudi_pointage" class="form-control"
                 type="text">

          <div v-if="errors.jeudi_pointage" class='div-error' show variant="danger">
            {{ errors.jeudi_pointage }}
          </div>
        </div>


        <div v-if="canShowFilter('vendredi_pointage')" class="form-group">
          <label>vendredi_pointage </label>
          <input v-model="form.vendredi_pointage" class="form-control"
                 type="text">

          <div v-if="errors.vendredi_pointage" class='div-error' show variant="danger">
            {{ errors.vendredi_pointage }}
          </div>
        </div>


        <div v-if="canShowFilter('samedi_pointage')" class="form-group">
          <label>samedi_pointage </label>
          <input v-model="form.samedi_pointage" class="form-control"
                 type="text">

          <div v-if="errors.samedi_pointage" class='div-error' show variant="danger">
            {{ errors.samedi_pointage }}
          </div>
        </div>


        <div v-if="canShowFilter('dimanche_collecter')" class="form-group">
          <label>dimanche_collecter </label>
          <input v-model="form.dimanche_collecter" class="form-control"
                 type="text">

          <div v-if="errors.dimanche_collecter" class='div-error' show variant="danger">
            {{ errors.dimanche_collecter }}
          </div>
        </div>


        <div v-if="canShowFilter('lundi_collecter')" class="form-group">
          <label>lundi_collecter </label>
          <input v-model="form.lundi_collecter" class="form-control"
                 type="text">

          <div v-if="errors.lundi_collecter" class='div-error' show variant="danger">
            {{ errors.lundi_collecter }}
          </div>
        </div>


        <div v-if="canShowFilter('mardi_collecter')" class="form-group">
          <label>mardi_collecter </label>
          <input v-model="form.mardi_collecter" class="form-control"
                 type="text">

          <div v-if="errors.mardi_collecter" class='div-error' show variant="danger">
            {{ errors.mardi_collecter }}
          </div>
        </div>


        <div v-if="canShowFilter('mercredi_collecter')" class="form-group">
          <label>mercredi_collecter </label>
          <input v-model="form.mercredi_collecter" class="form-control"
                 type="text">

          <div v-if="errors.mercredi_collecter" class='div-error' show variant="danger">
            {{ errors.mercredi_collecter }}
          </div>
        </div>


        <div v-if="canShowFilter('jeudi_collecter')" class="form-group">
          <label>jeudi_collecter </label>
          <input v-model="form.jeudi_collecter" class="form-control"
                 type="text">

          <div v-if="errors.jeudi_collecter" class='div-error' show variant="danger">
            {{ errors.jeudi_collecter }}
          </div>
        </div>


        <div v-if="canShowFilter('vendredi_collecter')" class="form-group">
          <label>vendredi_collecter </label>
          <input v-model="form.vendredi_collecter" class="form-control"
                 type="text">

          <div v-if="errors.vendredi_collecter" class='div-error' show variant="danger">
            {{ errors.vendredi_collecter }}
          </div>
        </div>


        <div v-if="canShowFilter('samedi_collecter')" class="form-group">
          <label>samedi_collecter </label>
          <input v-model="form.samedi_collecter" class="form-control"
                 type="text">

          <div v-if="errors.samedi_collecter" class='div-error' show variant="danger">
            {{ errors.samedi_collecter }}
          </div>
        </div>


        <div v-if="canShowFilter('dimanche_depassement')" class="form-group">
          <label>dimanche_depassement </label>
          <input v-model="form.dimanche_depassement" class="form-control"
                 type="text">

          <div v-if="errors.dimanche_depassement" class='div-error' show variant="danger">
            {{ errors.dimanche_depassement }}
          </div>
        </div>


        <div v-if="canShowFilter('lundi_depassement')" class="form-group">
          <label>lundi_depassement </label>
          <input v-model="form.lundi_depassement" class="form-control"
                 type="text">

          <div v-if="errors.lundi_depassement" class='div-error' show variant="danger">
            {{ errors.lundi_depassement }}
          </div>
        </div>


        <div v-if="canShowFilter('mardi_depassement')" class="form-group">
          <label>mardi_depassement </label>
          <input v-model="form.mardi_depassement" class="form-control"
                 type="text">

          <div v-if="errors.mardi_depassement" class='div-error' show variant="danger">
            {{ errors.mardi_depassement }}
          </div>
        </div>


        <div v-if="canShowFilter('mercredi_depassement')" class="form-group">
          <label>mercredi_depassement </label>
          <input v-model="form.mercredi_depassement" class="form-control"
                 type="text">

          <div v-if="errors.mercredi_depassement" class='div-error' show variant="danger">
            {{ errors.mercredi_depassement }}
          </div>
        </div>


        <div v-if="canShowFilter('jeudi_depassement')" class="form-group">
          <label>jeudi_depassement </label>
          <input v-model="form.jeudi_depassement" class="form-control"
                 type="text">

          <div v-if="errors.jeudi_depassement" class='div-error' show variant="danger">
            {{ errors.jeudi_depassement }}
          </div>
        </div>


        <div v-if="canShowFilter('vendredi_depassement')" class="form-group">
          <label>vendredi_depassement </label>
          <input v-model="form.vendredi_depassement" class="form-control"
                 type="text">

          <div v-if="errors.vendredi_depassement" class='div-error' show variant="danger">
            {{ errors.vendredi_depassement }}
          </div>
        </div>


        <div v-if="canShowFilter('samedi_depassement')" class="form-group">
          <label>samedi_depassement </label>
          <input v-model="form.samedi_depassement" class="form-control"
                 type="text">

          <div v-if="errors.samedi_depassement" class='div-error' show variant="danger">
            {{ errors.samedi_depassement }}
          </div>
        </div>


        <div v-if="canShowFilter('dimanche_programmer')" class="form-group">
          <label>dimanche_programmer </label>
          <input v-model="form.dimanche_programmer" class="form-control"
                 type="text">

          <div v-if="errors.dimanche_programmer" class='div-error' show variant="danger">
            {{ errors.dimanche_programmer }}
          </div>
        </div>


        <div v-if="canShowFilter('lundi_programmer')" class="form-group">
          <label>lundi_programmer </label>
          <input v-model="form.lundi_programmer" class="form-control"
                 type="text">

          <div v-if="errors.lundi_programmer" class='div-error' show variant="danger">
            {{ errors.lundi_programmer }}
          </div>
        </div>


        <div v-if="canShowFilter('mardi_programmer')" class="form-group">
          <label>mardi_programmer </label>
          <input v-model="form.mardi_programmer" class="form-control"
                 type="text">

          <div v-if="errors.mardi_programmer" class='div-error' show variant="danger">
            {{ errors.mardi_programmer }}
          </div>
        </div>


        <div v-if="canShowFilter('mercredi_programmer')" class="form-group">
          <label>mercredi_programmer </label>
          <input v-model="form.mercredi_programmer" class="form-control"
                 type="text">

          <div v-if="errors.mercredi_programmer" class='div-error' show variant="danger">
            {{ errors.mercredi_programmer }}
          </div>
        </div>


        <div v-if="canShowFilter('jeudi_programmer')" class="form-group">
          <label>jeudi_programmer </label>
          <input v-model="form.jeudi_programmer" class="form-control"
                 type="text">

          <div v-if="errors.jeudi_programmer" class='div-error' show variant="danger">
            {{ errors.jeudi_programmer }}
          </div>
        </div>


        <div v-if="canShowFilter('vendredi_programmer')" class="form-group">
          <label>vendredi_programmer </label>
          <input v-model="form.vendredi_programmer" class="form-control"
                 type="text">

          <div v-if="errors.vendredi_programmer" class='div-error' show variant="danger">
            {{ errors.vendredi_programmer }}
          </div>
        </div>


        <div v-if="canShowFilter('samedi_programmer')" class="form-group">
          <label>samedi_programmer </label>
          <input v-model="form.samedi_programmer" class="form-control"
                 type="text">

          <div v-if="errors.samedi_programmer" class='div-error' show variant="danger">
            {{ errors.samedi_programmer }}
          </div>
        </div>


        <div v-if="canShowFilter('dimanche_retard')" class="form-group">
          <label>dimanche_retard </label>
          <input v-model="form.dimanche_retard" class="form-control"
                 type="text">

          <div v-if="errors.dimanche_retard" class='div-error' show variant="danger">
            {{ errors.dimanche_retard }}
          </div>
        </div>


        <div v-if="canShowFilter('lundi_retard')" class="form-group">
          <label>lundi_retard </label>
          <input v-model="form.lundi_retard" class="form-control"
                 type="text">

          <div v-if="errors.lundi_retard" class='div-error' show variant="danger">
            {{ errors.lundi_retard }}
          </div>
        </div>


        <div v-if="canShowFilter('mardi_retard')" class="form-group">
          <label>mardi_retard </label>
          <input v-model="form.mardi_retard" class="form-control"
                 type="text">

          <div v-if="errors.mardi_retard" class='div-error' show variant="danger">
            {{ errors.mardi_retard }}
          </div>
        </div>


        <div v-if="canShowFilter('mercredi_retard')" class="form-group">
          <label>mercredi_retard </label>
          <input v-model="form.mercredi_retard" class="form-control"
                 type="text">

          <div v-if="errors.mercredi_retard" class='div-error' show variant="danger">
            {{ errors.mercredi_retard }}
          </div>
        </div>


        <div v-if="canShowFilter('jeudi_retard')" class="form-group">
          <label>jeudi_retard </label>
          <input v-model="form.jeudi_retard" class="form-control"
                 type="text">

          <div v-if="errors.jeudi_retard" class='div-error' show variant="danger">
            {{ errors.jeudi_retard }}
          </div>
        </div>


        <div v-if="canShowFilter('vendredi_retard')" class="form-group">
          <label>vendredi_retard </label>
          <input v-model="form.vendredi_retard" class="form-control"
                 type="text">

          <div v-if="errors.vendredi_retard" class='div-error' show variant="danger">
            {{ errors.vendredi_retard }}
          </div>
        </div>


        <div v-if="canShowFilter('samedi_retard')" class="form-group">
          <label>samedi_retard </label>
          <input v-model="form.samedi_retard" class="form-control"
                 type="text">

          <div v-if="errors.samedi_retard" class='div-error' show variant="danger">
            {{ errors.samedi_retard }}
          </div>
        </div>


        <div v-if="canShowFilter('total_programmer')" class="form-group">
          <label>total_programmer </label>
          <input v-model="form.total_programmer" class="form-control"
                 type="text">

          <div v-if="errors.total_programmer" class='div-error' show variant="danger">
            {{ errors.total_programmer }}
          </div>
        </div>


        <div v-if="canShowFilter('total_colecter')" class="form-group">
          <label>total_colecter </label>
          <input v-model="form.total_colecter" class="form-control"
                 type="text">

          <div v-if="errors.total_colecter" class='div-error' show variant="danger">
            {{ errors.total_colecter }}
          </div>
        </div>


        <div v-if="canShowFilter('total_depassement')" class="form-group">
          <label>total_depassement </label>
          <input v-model="form.total_depassement" class="form-control"
                 type="text">

          <div v-if="errors.total_depassement" class='div-error' show variant="danger">
            {{ errors.total_depassement }}
          </div>
        </div>


        <div v-if="canShowFilter('hs15')" class="form-group">
          <label>hs15 </label>
          <input v-model="form.hs15" class="form-control"
                 type="text">

          <div v-if="errors.hs15" class='div-error' show variant="danger">
            {{ errors.hs15 }}
          </div>
        </div>


        <div v-if="canShowFilter('hs26')" class="form-group">
          <label>hs26 </label>
          <input v-model="form.hs26" class="form-control"
                 type="text">

          <div v-if="errors.hs26" class='div-error' show variant="danger">
            {{ errors.hs26 }}
          </div>
        </div>


        <div v-if="canShowFilter('hs55')" class="form-group">
          <label>hs55 </label>
          <input v-model="form.hs55" class="form-control"
                 type="text">

          <div v-if="errors.hs55" class='div-error' show variant="danger">
            {{ errors.hs55 }}
          </div>
        </div>


        <div v-if="canShowFilter('hs30')" class="form-group">
          <label>hs30 </label>
          <input v-model="form.hs30" class="form-control"
                 type="text">

          <div v-if="errors.hs30" class='div-error' show variant="danger">
            {{ errors.hs30 }}
          </div>
        </div>


        <div v-if="canShowFilter('hs60')" class="form-group">
          <label>hs60 </label>
          <input v-model="form.hs60" class="form-control"
                 type="text">

          <div v-if="errors.hs60" class='div-error' show variant="danger">
            {{ errors.hs60 }}
          </div>
        </div>


        <div v-if="canShowFilter('hs115')" class="form-group">
          <label>hs115 </label>
          <input v-model="form.hs115" class="form-control"
                 type="text">

          <div v-if="errors.hs115" class='div-error' show variant="danger">
            {{ errors.hs115 }}
          </div>
        </div>


        <div v-if="canShowFilter('hs130')" class="form-group">
          <label>hs130 </label>
          <input v-model="form.hs130" class="form-control"
                 type="text">

          <div v-if="errors.hs130" class='div-error' show variant="danger">
            {{ errors.hs130 }}
          </div>
        </div>


        <div v-if="canShowFilter('total')" class="form-group">
          <label>total </label>
          <input v-model="form.total" class="form-control"
                 type="text">

          <div v-if="errors.total" class='div-error' show variant="danger">
            {{ errors.total }}
          </div>
        </div>


        <div class="form-group">
          <label>programmations </label>
          <v-select
              v-model="form.programmation_id"
              :options="programmationsData"
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
  name: 'FiltreVentilations',
  components: {VSelect, Files},
  props: [
    'table',
    'programmationsData',
    'usersData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        user_id: "",

        semaine: "",

        dimanche_date: "",

        lundi_date: "",

        mardi_date: "",

        mercredi_date: "",

        jeudi_date: "",

        vendredi_date: "",

        samedi_date: "",

        dimanche_horaire: "",

        lundi_horaire: "",

        mardi_horaire: "",

        mercredi_horaire: "",

        jeudi_horaire: "",

        vendredi_horaire: "",

        samedi_horaire: "",

        dimanche: "",

        lundi: "",

        mardi: "",

        mercredi: "",

        jeudi: "",

        vendredi: "",

        samedi: "",

        dimanche_pointage: "",

        lundi_pointage: "",

        mardi_pointage: "",

        mercredi_pointage: "",

        jeudi_pointage: "",

        vendredi_pointage: "",

        samedi_pointage: "",

        dimanche_collecter: "",

        lundi_collecter: "",

        mardi_collecter: "",

        mercredi_collecter: "",

        jeudi_collecter: "",

        vendredi_collecter: "",

        samedi_collecter: "",

        dimanche_depassement: "",

        lundi_depassement: "",

        mardi_depassement: "",

        mercredi_depassement: "",

        jeudi_depassement: "",

        vendredi_depassement: "",

        samedi_depassement: "",

        dimanche_programmer: "",

        lundi_programmer: "",

        mardi_programmer: "",

        mercredi_programmer: "",

        jeudi_programmer: "",

        vendredi_programmer: "",

        samedi_programmer: "",

        dimanche_retard: "",

        lundi_retard: "",

        mardi_retard: "",

        mercredi_retard: "",

        jeudi_retard: "",

        vendredi_retard: "",

        samedi_retard: "",

        programmation_id: "",

        total_programmer: "",

        total_colecter: "",

        total_depassement: "",

        hs15: "",

        hs26: "",

        hs55: "",

        hs30: "",

        hs60: "",

        hs115: "",

        hs130: "",

        total: "",

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
