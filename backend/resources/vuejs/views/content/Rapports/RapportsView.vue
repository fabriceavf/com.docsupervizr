<template>

  <div class="row">
    <b-modal :id="formId" :size="formWidth">
      <template #modal-title>
        <div v-if="formState=='Update'">Update Rapports #{{ formData.id }}</div>
        <div v-if="formState=='Create'">Create Rapports</div>
      </template>

      <EditRapports
          v-if="formState=='Update'"
          :key="formKey"
          :clientsData="clientsData"
          :data="formData"
          :factionsData="factionsData"
          :fonctionsData="fonctionsData"
          :gridApi="formGridApi"
          :modalFormId="formId"
          :postesData="postesData"
          :sitesData="sitesData"
          :typesData="typesData"
          :usersData="usersData"
          :villesData="villesData"
          :zonesData="zonesData"
          @close="closeForm"
      />


      <CreateRapports
          v-if="formState=='Create'"
          :key="formKey"
          :clientsData="clientsData"
          :factionsData="factionsData"
          :fonctionsData="fonctionsData"
          :gridApi="formGridApi"
          :modalFormId="formId"
          :postesData="postesData"
          :sitesData="sitesData"
          :typesData="typesData"
          :usersData="usersData"
          :villesData="villesData"
          :zonesData="zonesData"
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
import CreateRapports from './CreateRapports.vue'
import EditRapports from './EditRapports.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
  name: 'RapportsView',
  components: {DataTable, AgGridTable, CreateRapports, EditRapports, DataModal, AgGridBtnClicked},
  data() {

    return {
      formId: "rapports",
      formState: "",
      formData: {},
      formWidth: 'lg',
      formGridApi: {},
      formKey: 0,
      tableKey: 0,
      url: 'http://127.0.0.1:8000/api/rapports-Aggrid',
      table: 'rapports',
      clientsData: [],
      factionsData: [],
      fonctionsData: [],
      postesData: [],
      sitesData: [],
      typesData: [],
      usersData: [],
      villesData: [],
      zonesData: [],
      requette: 9,
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
      },
      deep: true
    },
  },
  created() {
    this.url = this.axios.defaults.baseURL + '/api/rapports-Aggrid',
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
            field: "mois",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'mois',
          },


          {
            field: "nom",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'nom',
          },


          {
            field: "prenom",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'prenom',
          },


          {
            field: "matricule",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'matricule',
          },


          {
            field: "day_01",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J01',
          },


          {
            field: "day_02",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J02',
          },


          {
            field: "day_03",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J03',
          },


          {
            field: "day_04",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J04',
          },


          {
            field: "day_05",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J05',
          },


          {
            field: "day_06",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J06',
          },


          {
            field: "day_07",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J07',
          },


          {
            field: "day_08",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J08',
          },


          {
            field: "day_09",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J09',
          },


          {
            field: "day_10",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J10',
          },


          {
            field: "day_11",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J11',
          },


          {
            field: "day_12",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J12',
          },


          {
            field: "day_13",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J13',
          },


          {
            field: "day_14",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J14',
          },


          {
            field: "day_15",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J15',
          },


          {
            field: "day_16",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J16',
          },


          {
            field: "day_17",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J17',
          },


          {
            field: "day_18",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J18',
          },


          {
            field: "day_19",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J19',
          },


          {
            field: "day_20",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J20',
          },


          {
            field: "day_21",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J21',
          },


          {
            field: "day_22",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J22',
          },


          {
            field: "day_23",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J23',
          },


          {
            field: "day_24",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J24',
          },


          {
            field: "day_25",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J25',
          },


          {
            field: "day_26",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J26',
          },


          {
            field: "day_27",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J27',
          },


          {
            field: "day_28",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J28',
          },


          {
            field: "day_29",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J29',
          },


          {
            field: "day_30",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J30',
          },


          {
            field: "day_31",
            // sortable: true,
            //filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'J31',
          },


          {
            field: "jour_abscences",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'jour_abscences',
          },


          {
            field: "jour_presences",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'jour_presences',
          },


          {
            headerName: 'client',
            field: 'client.Selectlabel',
          },
          {
            hide: true,
            suppressColumnsToolPanel: true,

            headerName: 'client',
            field: 'client_id',
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['client']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.clientsData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'faction',
            field: 'faction.Selectlabel',
          },
          {
            hide: true,
            suppressColumnsToolPanel: true,

            headerName: 'faction',
            field: 'faction_id',
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['faction']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.factionsData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'fonction',
            field: 'fonction.Selectlabel',
          },
          {
            hide: true,
            suppressColumnsToolPanel: true,

            headerName: 'fonction',
            field: 'fonction_id',
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['fonction']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.fonctionsData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'poste',
            field: 'poste.Selectlabel',
          },
          {
            hide: true,
            suppressColumnsToolPanel: true,

            headerName: 'poste',
            field: 'poste_id',
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['poste']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.postesData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'site',
            field: 'site.Selectlabel',
          },
          {
            hide: true,
            suppressColumnsToolPanel: true,

            headerName: 'site',
            field: 'site_id',
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['site']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.sitesData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'type',
            field: 'type.Selectlabel',
          },
          {
            hide: true,
            suppressColumnsToolPanel: true,

            headerName: 'type',
            field: 'type_id',
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['type']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.typesData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'user',
            field: 'user.Selectlabel',
          },
          {
            hide: true,
            suppressColumnsToolPanel: true,

            headerName: 'user',
            field: 'user_id',
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


          {
            headerName: 'ville',
            field: 'ville.Selectlabel',
          },
          {
            hide: true,
            suppressColumnsToolPanel: true,

            headerName: 'ville',
            field: 'ville_id',
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['ville']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.villesData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'zone',
            field: 'zone.Selectlabel',
          },
          {
            hide: true,
            suppressColumnsToolPanel: true,

            headerName: 'zone',
            field: 'zone_id',
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['zone']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.zonesData);
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

    this.getclients();
    this.getfactions();
    this.getfonctions();
    this.getpostes();
    this.getsites();
    this.gettypes();
    this.getusers();
    this.getvilles();
    this.getzones();

  },
  methods: {
    closeForm() {
      this.tableKey++
    },
    openCreate() {
      this.showForm('Create', {}, this.gridApi)
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
    getclients() {
      this.axios.get('/api/clients').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.clientsData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getfactions() {
      this.axios.get('/api/factions').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.factionsData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getfonctions() {
      this.axios.get('/api/fonctions').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.fonctionsData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getpostes() {
      this.axios.get('/api/postes').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.postesData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getsites() {
      this.axios.get('/api/sites').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.sitesData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    gettypes() {
      this.axios.get('/api/types').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.typesData = response.data

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

    getvilles() {
      this.axios.get('/api/villes').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.villesData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getzones() {
      this.axios.get('/api/zones').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.zonesData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

  }
}
</script>
