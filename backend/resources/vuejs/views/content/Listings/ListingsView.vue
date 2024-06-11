<template>

  <div class="row">
    <b-modal :id="formId" :size="formWidth">
      <template #modal-title>
        <div v-if="formState=='Update'">Update Listings #{{ formData.id }}</div>
        <div v-if="formState=='Create'">Create Listings</div>
      </template>

      <EditListings
          v-if="formState=='Update'"
          :key="formKey"
          :actifsData="actifsData"
          :balisesData="balisesData"
          :categoriesData="categoriesData"
          :contratsData="contratsData"
          :data="formData"
          :directionsData="directionsData"
          :echelonsData="echelonsData"
          :factionsData="factionsData"
          :fonctionsData="fonctionsData"
          :gridApi="formGridApi"
          :matrimonialesData="matrimonialesData"
          :modalFormId="formId"
          :nationalitesData="nationalitesData"
          :onlinesData="onlinesData"
          :postesData="postesData"
          :sexesData="sexesData"
          :sitesData="sitesData"
          :situationsData="situationsData"
          :typesData="typesData"
          :villesData="villesData"
          :zonesData="zonesData"
          @close="closeForm"
      />


      <CreateListings
          v-if="formState=='Create'"
          :key="formKey"
          :actifsData="actifsData"
          :balisesData="balisesData"
          :categoriesData="categoriesData"
          :contratsData="contratsData"
          :directionsData="directionsData"
          :echelonsData="echelonsData"
          :factionsData="factionsData"
          :fonctionsData="fonctionsData"
          :gridApi="formGridApi"
          :matrimonialesData="matrimonialesData"
          :modalFormId="formId"
          :nationalitesData="nationalitesData"
          :onlinesData="onlinesData"
          :postesData="postesData"
          :sexesData="sexesData"
          :sitesData="sitesData"
          :situationsData="situationsData"
          :typesData="typesData"
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
import CreateListings from './CreateListings.vue'
import EditListings from './EditListings.vue'
import DataModal from '@/components/DataModal.vue'
import ListingsTraitements from "@/views/content/Listings/ListingsTraitements.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
  name: 'ListingsView',
  components: {DataTable, AgGridTable, CreateListings, EditListings, DataModal, AgGridBtnClicked, ListingsTraitements},
  data() {

    return {
      formId: "listings",
      formState: "",
      formData: {},
      formWidth: 'lg',
      formGridApi: {},
      formKey: 0,
      tableKey: 0,
      url: 'http://127.0.0.1:8000/api/listings-Aggrid',
      table: 'listings',
      actifsData: [],
      balisesData: [],
      categoriesData: [],
      contratsData: [],
      directionsData: [],
      echelonsData: [],
      factionsData: [],
      fonctionsData: [],
      matrimonialesData: [],
      nationalitesData: [],
      onlinesData: [],
      postesData: [],
      sexesData: [],
      sitesData: [],
      situationsData: [],
      typesData: [],
      villesData: [],
      zonesData: [],
      requette: 18,
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
    this.url = this.axios.defaults.baseURL + '/api/listings-Aggrid',
        this.formId = this.table + "_" + Date.now()
    this.rowBuffer = 0;
    this.rowModelType = 'serverSide';
    this.cacheBlockSize = 50;
    this.maxBlocksInCache = 2;

  },
  beforeMount() {
    this.columnDefs =
        [
          // {
          //   field: null,
          //   headerName: '',
          //   suppressCellSelection: true,
          //   minWidth: 80,maxWidth: 80,
          //   pinned: 'left',
          //   cellRendererSelector: params => {
          //     return {
          //       component: 'AgGridBtnClicked',
          //       params: {
          //         clicked: field => {
          //           this.showForm('Update', field, params.api)
          //         },
          //         render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

          //       }
          //     };
          //   },
          //
          // },


          // {
          //   field: "name",
          //   sortable: true,
          //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
          //   headerName: 'name',
          // },

          {
            field: "date",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'date',
            valueFormatter: params => {
              let retour = params.value
              try {
                retour = params.value.split(' ')[0]
              } catch (e) {

              }
              return retour
            }
          },

          {
            field: "matricule",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'matricule',
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
            field: "present",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'present',
            cellRendererSelector: params => {
              return {
                component: 'ListingsTraitements',
                params: {
                  clicked: field => {
                    this.showForm('Update', field, params.api)
                  },
                }
              };
            },
          },

          {
            headerName: 'fonction',
            field: 'fonction.Selectlabel',
          },
          {

            headerName: 'fonction',
            field: 'fonction_id',
            hide: true,
            suppressColumnsToolPanel: true,
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
            field: "num_badge",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'num_badge',
          },


          // {
          //   field: "emp_code",
          //   sortable: true,
          //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
          //   headerName: 'emp_code',
          // },


          //
          // {
          //   field: "id_date",
          //   sortable: true,
          //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
          //   headerName: 'id_date',
          // },


          {
            headerName: 'actif',
            field: 'actif.Selectlabel',
          },
          {

            headerName: 'actif',
            field: 'actif_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['actif']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.actifsData);
              },
              refreshValuesOnOpen: true,
            },
          },


          // {
          //
          //   headerName: 'balise',
          //   field: 'balise_id',
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['balise']['Selectlabel']
          //     } catch (e) {
          //
          //     }
          //     return retour
          //   },
          //
          //   filter: 'agSetColumnFilter',
          //   filterParams: {suppressAndOrCondition: true,
          //     keyCreator: params => params.value.id,
          //     valueFormatter: params => params.value.Selectlabel,
          //     values: params => {
          //       params.success(this.balisesData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },


          {
            headerName: 'categorie',
            field: 'categorie.Selectlabel',
          },
          {

            headerName: 'categorie',
            field: 'categorie_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['categorie']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.categoriesData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'contrat',
            field: 'contrat.Selectlabel',
          },
          {

            headerName: 'contrat',
            field: 'contrat_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['contrat']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.contratsData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'direction',
            field: 'direction.Selectlabel',
          },
          {

            headerName: 'direction',
            field: 'direction_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['direction']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.directionsData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'echelon',
            field: 'echelon.Selectlabel',
          },
          {

            headerName: 'echelon',
            field: 'echelon_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['echelon']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.echelonsData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'faction',
            field: 'faction.Selectlabel',
          },
          {

            headerName: 'faction',
            field: 'faction_id',
            hide: true,
            suppressColumnsToolPanel: true,
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
            headerName: 'matrimoniale',
            field: 'matrimoniale.Selectlabel',
          },
          {

            headerName: 'matrimoniale',
            field: 'matrimoniale_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['matrimoniale']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.matrimonialesData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'nationalite',
            field: 'nationalite.Selectlabel',
          },
          {

            headerName: 'nationalite',
            field: 'nationalite_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['nationalite']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.nationalitesData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'online',
            field: 'online.Selectlabel',
          },
          {

            headerName: 'online',
            field: 'online_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['online']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.onlinesData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'poste',
            field: 'poste.Selectlabel',
          },
          {

            headerName: 'poste',
            field: 'poste_id',
            hide: true,
            suppressColumnsToolPanel: true,
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
            headerName: 'sexe',
            field: 'sexe.Selectlabel',
          },
          {

            headerName: 'sexe',
            field: 'sexe_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['sexe']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.sexesData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'site',
            field: 'site.Selectlabel',
          },
          {

            headerName: 'site',
            field: 'site_id',
            hide: true,
            suppressColumnsToolPanel: true,
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
            headerName: 'situation',
            field: 'situation.Selectlabel',
          },
          {

            headerName: 'situation',
            field: 'situation_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['situation']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.situationsData);
              },
              refreshValuesOnOpen: true,
            },
          },


          {
            headerName: 'type',
            field: 'type.Selectlabel',
          },
          {

            headerName: 'type',
            field: 'type_id',
            hide: true,
            suppressColumnsToolPanel: true,
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
            headerName: 'ville',
            field: 'ville.Selectlabel',
          },
          {

            headerName: 'ville',
            field: 'ville_id',
            hide: true,
            suppressColumnsToolPanel: true,
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

            headerName: 'zone',
            field: 'zone_id',
            hide: true,
            suppressColumnsToolPanel: true,
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

    this.getactifs();
    this.getbalises();
    this.getcategories();
    this.getcontrats();
    this.getdirections();
    this.getechelons();
    this.getfactions();
    this.getfonctions();
    this.getmatrimoniales();
    this.getnationalites();
    this.getonlines();
    this.getpostes();
    this.getsexes();
    this.getsites();
    this.getsituations();
    this.gettypes();
    this.getvilles();
    this.getzones();

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
    getactifs() {
      this.axios.get('/api/actifs').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.actifsData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getbalises() {
      this.axios.get('/api/balises').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.balisesData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getcategories() {
      this.axios.get('/api/categories').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.categoriesData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getcontrats() {
      this.axios.get('/api/contrats').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.contratsData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getdirections() {
      this.axios.get('/api/directions').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.directionsData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getechelons() {
      this.axios.get('/api/echelons').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.echelonsData = response.data

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

    getmatrimoniales() {
      this.axios.get('/api/matrimoniales').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.matrimonialesData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getnationalites() {
      this.axios.get('/api/nationalites').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.nationalitesData = response.data

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },

    getonlines() {
      this.axios.get('/api/onlines').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.onlinesData = response.data

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

    getsexes() {
      this.axios.get('/api/sexes').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.sexesData = response.data

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

    getsituations() {
      this.axios.get('/api/situations').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.situationsData = response.data

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
