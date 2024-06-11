<template>
  <AdminLte>
    <template #content>
      <div class="container-fluid">
        <!--div class="row mb-5">
          <div class="col-md-4">
            <Pie />
          </div>
          <div class="col-md-4">
            <Pie />
          </div>
          <div class="col-md-4">
            <Pie />
          </div>
        </!--div-->
        <div class="row">
          <div class="col-md-3">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ nb_employes }}</h3>
                <p>Personnel </p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <router-link :to="{name: 'employes'}" class="small-box-footer ">
                Voir plus <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-md-3">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ nb_enrolements }}</h3>
                <p>Enrolements </p>
              </div>
              <div class="icon">
                <i class="fas fa-id-card-alt"></i>
              </div>
              <router-link :to="{name: 'enrolements'}" class="small-box-footer">
                Voir plus <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>

          <div class="col-md-3">
            <!-- small card -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{ nb_taches }}</h3>
                <p>Taches </p>
              </div>
              <div class="icon">
                <i class="fas fa-location-arrow"></i>
              </div>
              <router-link class="small-box-footer" to="/taches">
                Voir plus <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>

          <div class="col-md-3">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ exceptions }}</h3>
                <p>Exeptions </p>
              </div>
              <div class="icon">
                <i class="fas fa-location-arrow"></i>
              </div>
              <router-link class="small-box-footer" to="/pointages/exceptions">
                Voir plus <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>

          <div class="col-md-6">
            <DataTable :fields="fields" :url="url_pointagesDuJour" limit="5" table="pointages_jour">
              <template #datatable_header_title>
                <div class="d-flex justify-content-between">
                  <h5> Pointages d'aujourd'hui</h5>
                  <router-link class="btn float-right" to="/pointages/journal">
                    Voir plus <i class="fas fa-arrow-circle-right"></i>
                  </router-link>
                </div>
              </template>
            </DataTable>
          </div>

          <div class="col-md-6">
            <DataTable :fields="fields2" :url="url_programmations" limit="5" table="programmations_en_cours">
              <template #datatable_header_title>
                <div class="d-flex justify-content-between">
                  <h5> Programmation(s) en cours</h5>
                  <router-link class="btn float-right" to="/programmations">
                    Voir plus <i class="fas fa-arrow-circle-right"></i>
                  </router-link>
                </div>
              </template>
            </DataTable>
          </div>
        </div>
      </div>
    </template>
  </AdminLte>
</template>

<script>
import moment from 'moment'
import SemaineLine from '@/components/SemaineLine'
import Doughnut from '@/components/AbsenceDoughnut'
import Pie from '@/components/HeurePie'
import AdminLte from '@/components/AdminLte'
import DataTable from '@/components/DataTable.vue'

export default {
  name: 'HomeView',
  components: {AdminLte, DataTable, SemaineLine, Doughnut, Pie},
  data() {
    return {
      fields: [
        {
          key: 'punch_time',
          sortable: 'true',
          formatter: this.formatHeure,
          label: 'Heure'
        },
        {
          key: 'emp_code',
          sortable: 'true',
          label: 'Code'
        },
        {
          key: 'first_name',
          sortable: 'true',
          label: 'Nom'
        },
        {
          key: 'last_name',
          sortable: 'true',
          label: 'Prenom'
        },
        {
          key: 'area_alias',
          sortable: 'true',
          label: 'Service'
        }
      ],
      url_pointagesDuJour: '/api/transactions?filter[date]=punch_date/=/' + moment(String(new Date())).format('YYYY-MM-DD') + '&',
      //url_pointagesDuJour: '/api/transactions?filter[date]=punch_date/=/2022-12-18',
      fields2: [
        {
          key: 'semaine',
          sortable: 'true',
          title: 'Semaine'
        },
        {
          key: 'superviseur',
          sortable: 'true',
          title: 'Superviseur'
        },
        {
          key: 'tache.libelle',
          sortable: 'true',
          label: 'Tache'
        }
      ],
      url_programmations: '/api/programmations?filter[like]=statut/cours&',
      nb_employes: 0,
      nb_enrolements: 0,
      nb_taches: 0,
      exceptions: 0,
      nb_absences: 0,
      nb_presences: 0,
      onChange: 1
    }
  },
  mounted() {
    this.getDatas()
  },
  methods: {
    async getDatas() {
      this.$store.commit('setIsLoading', true)
      await this.axios.get('/api/users?filter[actif]=1&filter[type]=employe&count=1').then((response) => {
        this.nb_employes = response.data
        // this.$store.commit('setIsLoading', false)
      }).catch(error => {
        this.errors = error.response.data.errors
        // this.$store.commit('setIsLoading', false)
      })

      this.$store.commit('setIsLoading', true)
      await this.axios.get('/api/users?filter[actif]=0&filter[type]=employe&count=1').then((response) => {
        this.nb_enrolements = response.data
        // this.$store.commit('setIsLoading', false)
      }).catch(error => {
        this.errors = error.response.data.errors
        // this.$store.commit('setIsLoading', false)
      })

      this.$store.commit('setIsLoading', true)
      await this.axios.get('/api/pointagesActionExceptions').then((response) => {
    //   await this.axios.get('/api/pointages/action?action=exceptions').then((response) => {
        this.exceptions = response.data.length
        // this.$store.commit('setIsLoading', false)
      }).catch(error => {
        this.errors = error.response.data.errors
        // this.$store.commit('setIsLoading', false)
      })

      this.$store.commit('setIsLoading', true)
      await this.axios.get('/api/taches?count=1').then((response) => {
        this.nb_taches = response.data
        // this.$store.commit('setIsLoading', false)
      }).catch(error => {
        this.errors = error.response.data.errors
        // this.$store.commit('setIsLoading', false)
      })

      /*this.$store.commit('setIsLoading', true)
      await this.axios.get('/api/pointages?filter[date]=debut_prevu/like/' + moment(String(new Date())).format('YYYY-MM-DD') + '&filter[debut_realise]=&count=1').then((response) => {
        this.nb_absences = response.data
        this.onChange++
        // this.$store.commit('setIsLoading', false)
      }).catch(error => {
        this.errors = error.response.data.errors
        // this.$store.commit('setIsLoading', false)
      })

      this.$store.commit('setIsLoading', true)
      await this.axios.get('/api/pointages?filter[date]=debut_prevu/like/' + moment(String(new Date())).format('YYYY-MM-DD') + '&filter[not_null]=debut_realise&count=1').then((response) => {
        this.nb_presences = response.data
        this.onChange++
        // this.$store.commit('setIsLoading', false)
      }).catch(error => {
        this.errors = error.response.data.errors
        // this.$store.commit('setIsLoading', false)
      })*/
    }
  }

}
</script>
