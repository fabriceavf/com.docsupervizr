<template>
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
    <b-row>
      <b-col lg="3" sm="6">
        <statistic-card-horizontal :statistic="nb_employes" background="#00cfe8" color="success" icon="UserCheckIcon"
                                   statistic-title="Personnel"/>
      </b-col>
      <b-col lg="3" sm="6">

        <statistic-card-horizontal :statistic="nb_enrolements" background="rgb(255, 159, 67)" color="success"
                                   icon="UsersIcon" statistic-title="Enrolements"/>
      </b-col>
      <b-col lg="3" sm="6">

        <statistic-card-horizontal :statistic="nb_taches" background="rgb(40, 167, 69)" color="danger"
                                   icon="ActivityIcon"
                                   statistic-title="Taches"/>
      </b-col>
      <b-col lg="3" sm="6">
        <statistic-card-horizontal :statistic="exceptions" background="rgb(234, 84, 85)" color="warning"
                                   icon="AlertOctagonIcon" statistic-title="Exeptions"/>
      </b-col>
    </b-row>
    <div class="row">


      <div class="col-md-6">
        <AgGridTable :key="tableKey" :show-export="false" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                     :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                     :paginationPageSize="paginationPageSize"
                     :rowData="rowData" :rowModelType="rowModelType" :url="url" className="ag-theme-alpine"
                     domLayout='autoHeight'
                     :extrasData="extrasData"
                     rowSelection="multiple" @gridReady="onGridReady">
          <template #header_buttons>
            <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i class="fa fa-plus"></i>
              Nouveau
            </div>
          </template>

        </AgGridTable>
      </div>

      <div class="col-md-6">
        <AgGridTable :key="tableKey" :show-export="false" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs2"
                     :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                     :paginationPageSize="paginationPageSize"
                     :rowData="rowData" :rowModelType="rowModelType" :url="url2" className="ag-theme-alpine"
                     domLayout='autoHeight'
                     rowSelection="multiple" @gridReady="onGridReady">
          <template #header_buttons>
            <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i class="fa fa-plus"></i>
              Nouveau
            </div>
          </template>
        </AgGridTable>
      </div>
    </div>
  </div>
</template>

<script>
import {BCol, BRow} from 'bootstrap-vue'
import StatisticCardVertical from '@core/components/statistics-cards/StatisticCardVertical.vue'
import StatisticCardHorizontal from '@core/components/statistics-cards/StatisticCardHorizontal.vue'
import StatisticCardWithAreaChart from '@core/components/statistics-cards/StatisticCardWithAreaChart.vue'
import StatisticCardWithLineChart from '@core/components/statistics-cards/StatisticCardWithLineChart.vue'

import AgGridTable from "@/components/AgGridTable.vue"
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import moment from 'moment'
import SemaineLine from '@/components/SemaineLine'
import Doughnut from '@/components/AbsenceDoughnut'
import Pie from '@/components/HeurePie'
import DataTable from '@/components/DataTable.vue'

export default {
  name: 'HomeView',
  components: {
    DataTable, AgGridTable, AgGridBtnClicked, SemaineLine, Doughnut, Pie, BRow, BCol,
    StatisticCardVertical,
    StatisticCardHorizontal,
    StatisticCardWithAreaChart,
    StatisticCardWithLineChart
  },
  data() {
    return {
      nb_employes: 0,
      nb_enrolements: 0,
      nb_taches: 0,
      exceptions: 0,
      nb_absences: 0,
      nb_presences: 0,
      onChange: 1,

      formId: "transactions",
      formState: "",
      formData: {},
      formWidth: 'lg',
      formGridApi: {},
      formKey: 0,
      tableKey: 0,
      url: 'http://127.0.0.1:8000/api/transactions-Aggrid',
      url2: 'http://127.0.0.1:8000/api/programmations-Aggrid',
      table: 'transactions',
      requette: 2,
      columnDefs: null,
      rowData: null,
      gridApi: null,
      columnApi: null,
      rowModelType: null,
      pagination: true,
      paginationPageSize: 10,
      cacheBlockSize: 10,
      maxBlocksInCache: 1,
    }
  },
   computed: {$routeData:function(){let router = {meta:{}};try{router=window.routeData}catch (e) {};return router; },
        routeData:function () {
            let router={meta:{}}
            if(window.router){
                try{ router=window.router; }catch (e) { }
            }


            return router
        },
    taille: function () {
      let result = 'col-sm-12'
      if (this.filtre) {
        result = 'col-sm-9'
      }
      return result
    },
    extrasData: function () {
      let date=moment().format('YYYY-MM-DD')
      let params = { debut: date+' 00:00',fin: date+' 23:59'}

      return params


    }
  },
  watch: {
    'routeData': {
      handler: function (after, before) {
        this.gridApi.setFilterModel(null)
        this.gridApi.refreshServerSide()
        this.tableKey++
      },
      deep: true
    },
  },
  created() {
    this.url = this.axios.defaults.baseURL + '/api/transactions-Aggrid',
        this.url2 = this.axios.defaults.baseURL + '/api/programmations-Aggrid',
        this.formId = this.table + "_" + Date.now()
    this.rowBuffer = 0;
    this.rowModelType = 'serverSide';
    this.cacheBlockSize = 50;
    this.maxBlocksInCache = 2;

  },
  beforeMount() {
    this.columnDefs =
        [
          {
            field: "punch_time",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'Heure',
            valueFormatter: params => {
              let retour = params.value
              try {
                retour = moment(params.value).format('DD/MM/YYYY à HH:mm')
              } catch (e) {

              }
              return retour
            }
          },
          {
            field: "emp_code",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'Code',
          },
          {
            field: "nom",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'Nom',
          },
          {
            field: "prenom",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'Prenom',
          },
          {
            field: "area_alias",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'Service',
          },

        ];
    this.columnDefs2 =
        [
          {
            field: "semaine ",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'Semaine',
          },
          {
            field: "tache.libelle",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'Tache',
          },
          {
            field: "superviseur",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'Superviseur',
          },

        ];
  },
  mounted() {
    if (this.requette > 0) {
      this.$store.commit('setIsLoading', true)
    }
    this.getDatas()
  },
  methods: {
    onGridReady(params) {
      console.log('on demarre', params)
      this.gridApi = params.api;
      this.columnApi = params.columnApi;
      this.isLoading = false
    },
    async getDatas() {
      this.$store.commit('setIsLoading', true)
      await this.axios.get('/api/users?filter[actif_id]=1&filter[type_id]=2&count=1').then((response) => {
        this.nb_employes = response.data
        // this.$store.commit('setIsLoading', false)
      }).catch(error => {
        this.errors = error.response.data.errors
        // this.$store.commit('setIsLoading', false)
      })

      this.$store.commit('setIsLoading', true)
      await this.axios.get('/api/users?filter[actif_id]=2&filter[type_id]=2&count=1').then((response) => {
        this.nb_enrolements = response.data
        // this.$store.commit('setIsLoading', false)
      }).catch(error => {
        this.errors = error.response.data.errors
        // this.$store.commit('setIsLoading', false)
      })

      this.$store.commit('setIsLoading', true)
      await this.axios.get('/api/pointages/action?action=exceptions').then((response) => {
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

<style></style>
