<template>

  <div class="row">
    <b-modal :id="formId" :size="formWidth">
      <template #modal-title>
        <div v-if="formState=='Update'">Update Programmes #{{ formData.id }}</div>
        <div v-if="formState=='Create'">Create Programmes</div>
      </template>

      <EditProgrammes
          v-if="formState=='Update'"
          :key="formKey"
          :data="formData"
          :gridApi="formGridApi"
          :modalFormId="formId"
          :programmationsData="programmationsData"
          :tachesData="tachesData"
          :usersData="usersData"
          @close="closeForm"
      />


      <CreateProgrammes
          v-if="formState=='Create'"
          :key="formKey"
          :gridApi="formGridApi"
          :modalFormId="formId"
          :programmationsData="programmationsData"
          :tachesData="tachesData"
          :usersData="usersData"
          @close="closeForm"
      />

      <template #modal-footer>
        <div></div>
      </template>
    </b-modal>


    <div class="col-sm-12">
      <AgGridTable
          :key="tableKey"
          :cacheBlockSize="cacheBlockSize"
          :columnDefs="columnDefs"
          :maxBlocksInCache="maxBlocksInCache"
          :pagination="pagination"
          :paginationPageSize="paginationPageSize"
          :rowData="rowData"
          :rowModelType="rowModelType"
          :url="url"
          className="ag-theme-alpine"
          domLayout='autoHeight'
          rowSelection="multiple"
          @gridReady="onGridReady"

      >
        <template #header_buttons>
          <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i class="fa fa-plus"></i>
            Nouveau
          </div>
        </template>

      </AgGridTable>

    </div>
  </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateProgrammes from './CreateProgrammes.vue'
import EditProgrammes from './EditProgrammes.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
  name: 'ProgrammesView',
  components: {DataTable, AgGridTable, CreateProgrammes, EditProgrammes, DataModal, AgGridBtnClicked},
  data() {

    return {
      formId: "programmes",
      formState: "",
      formData: {},
      formWidth: 'lg',
      formGridApi: {},
      formKey: 0,
      tableKey: 0,
      url: 'http://127.0.0.1:8000/api/programmes-Aggrid',
      table: 'programmes',
      programmationsData: [],
      tachesData: [],
      usersData: [],
      requette: 3,
      columnDefs: null,
      rowData: null,
      gridApi: null,
      columnApi: null,
      rowModelType: null,
      pagination: true,
      paginationPageSize: 100,
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
    this.url = this.axios.defaults.baseURL + '/api/programmes-Aggrid',
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
            field: null,
            headerName: '',
            suppressCellSelection: true,
            minWidth: 80,maxWidth: 80,
            pinned: 'left',
            cellRendererSelector: params => {
              return {
                component: 'AgGridBtnClicked',
                params: {
                  clicked: field => {
                    this.showForm('Update', field, params.api)
                  },
                  render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                }
              };
            },

          },


          {
            field: "dimanche",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'dimanche',
          },


          {
            field: "lundi",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'lundi',
          },


          {
            field: "mardi",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'mardi',
          },


          {
            field: "mercredi",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'mercredi',
          },


          {
            field: "jeudi",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'jeudi',
          },


          {
            field: "vendredi",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'vendredi',
          },


          {
            field: "samedi",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'samedi',
          },


          {
            field: "actif",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'actif',
          },


          {
            headerName: 'programmation',
            field: 'programmation.Selectlabel',
          },
          {

            headerName: 'programmation',
            field: 'programmation_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['programmation']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.programmationsData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'tache',
            field: 'tache.Selectlabel',
          },
          {

            headerName: 'tache',
            field: 'tache_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['tache']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.tachesData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'user',
            field: 'user.Selectlabel',
          },
          {

            headerName: 'user',
            field: 'user_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['user']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.usersData);
              },
              refreshValuesOnOpen: true,
            },
          },

        ];


  },
  mounted() {
    if (this.requette > 0) {
      this.$store.commit('setIsLoading', true)
    }

    this.getprogrammations();
    this.gettaches();
    this.getusers();

  },
  methods: {
    openCreate() {
      this.showForm('Create', {}, this.gridApi)
    },
    closeForm() {
      this.tableKey++
    },
    showForm(type, data, gridApi, width = 'lg') {
      this.formKey++
      this.formWidth = width
      this.formState = type
      this.formData = data
      this.formGridApi = gridApi
      this.$bvModal.show(this.formId)
    },
    onGridReady(params) {
      console.log('on demarre', params)
      this.gridApi = params.api;
      this.columnApi = params.columnApi;
      this.isLoading = false
    },
    getprogrammations() {
      this.axios.get('/api/programmations').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.programmationsData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    gettaches() {
      this.axios.get('/api/taches').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.tachesData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getusers() {
      this.axios.get('/api/users').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.usersData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

  }
}
</script>
