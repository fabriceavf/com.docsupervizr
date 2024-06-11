<template>
  <div>

    <form @submit.prevent="checkInDate()">

      <div class="row">
        <div class="col-sm-5">
          <div class="form-group">
            <label>date de debut </label>
            <input v-model="form.debut" class="form-control" required
                   type="datetime-local">
          </div>
        </div>
        <div class="col-sm-5">
          <div class="form-group">
            <label>date de fin </label>
            <input v-model="form.fin" class="form-control" required
                   type="datetime-local">

          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            </br>
            <button class="btn btn-primary" type="submit">Valider</button>

          </div>
        </div>


      </div>
    </form>

    <div :key="key" class="row">
      <b-modal :id="formId" :size="formWidth">
        <template #modal-title>
          <div v-if="formState=='Update'">Update Journals #{{ formData.id }}</div>
          <div v-if="formState=='Create'">Create Journals</div>
          <div v-if="formState=='CreateRapport'">Generer un rapport</div>
        </template>

        <EditJournals
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
            :pointeusesData="pointeusesData"
            :postesData="postesData"
            :sexesData="sexesData"
            :sitesData="sitesData"
            :situationsData="situationsData"
            :typesData="typesData"
            :villesData="villesData"
            :zonesData="zonesData"
            @close="closeForm"
        />


        <CreateJournals
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
            :pointeusesData="pointeusesData"
            :postesData="postesData"
            :sexesData="sexesData"
            :sitesData="sitesData"
            :situationsData="situationsData"
            :typesData="typesData"
            :villesData="villesData"
            :zonesData="zonesData"
            @close="closeForm"
        />

        <GetRapport
            v-if="formState=='CreateRapport'"
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
            :pointeusesData="pointeusesData"
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
            :extrasData="form"
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
            <div v-if="!$route.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i class="fa fa-plus"></i>
              Nouveau
            </div>

            <div class="btn btn-primary" @click="openCreateRapport"><i class="fa fa-plus"></i>
              Creer un rapport
            </div>
          </template>

        </AgGridTable>

      </div>
    </div>
  </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateJournals from './CreateJournals.vue'
import EditJournals from './EditJournals.vue'
import DataModal from '@/components/DataModal'
import GetRapport from "@/views/content/Journals/GetRapport"
import moment from 'moment'

import AgGridBtnClicked from "@/components/AgGridBtnClicked";

export default {
  name: 'JournalsView',
  components: {DataTable, AgGridTable, CreateJournals, EditJournals, DataModal, AgGridBtnClicked, GetRapport},
  data() {

    return {
      showFormElement: false,
      formId: "journals",
      formState: "",
      formData: {},
      formWidth: 'lg',
      formGridApi: {},
      formKey: 0,
      tableKey: 0,
      url: 'http://127.0.0.1:8000/api/journals-Aggrid',
      table: 'journals',
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
      pointeusesData: [],
      postesData: [],
      sexesData: [],
      sitesData: [],
      clientsData: [],
      situationsData: [],
      typesData: [],
      villesData: [],
      zonesData: [],
      requette: 19,
      columnDefs: null,
      rowData: null,
      gridApi: null,
      columnApi: null,
      rowModelType: null,
      pagination: true,
      paginationPageSize: 100,
      cacheBlockSize: 10,
      maxBlocksInCache: 1,
      key: 0,
      form: {
        debut: new Date().toISOString().slice(0, 11) + '00:00',
        fin: new Date().toISOString().slice(0, 11) + '23:59'
      },
    }
  },

  computed: {
    taille: function () {
      let result = 'col-sm-12'
      if (this.filtre) {
        result = 'col-sm-9'
      }
      return result
    },
  },
  watch: {
    '$route': {
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
            field: "punch_time",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'Heure',
            valueFormatter: params => {
              let retour = params.value
              try {
                retour = moment(params.value).format('HH:mm')
              } catch (e) {

              }
              return retour
            }
          },
          {
            field: "punch_time",
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'Jour',
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
            field: "card_no",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'badge',
          },

          {
            headerName: 'pointeuse',
            field: 'pointeuse.Selectlabel',
          },
          {

            headerName: 'pointeuse',
            field: 'pointeuse_id',
            hide: true,
            suppressColumnsToolPanel: true,
            valueFormatter: params => {
              let retour = ''
              try {
                return params.data['pointeuse']['Selectlabel']
              } catch (e) {

              }
              return retour
            },

            filter: 'agSetColumnFilter',
            filterParams: {suppressAndOrCondition: true,
              keyCreator: params => params.value.id,
              valueFormatter: params => params.value.Selectlabel,
              values: params => {
                params.success(this.pointeusesData);
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


          // {
          //   headerName: 'site',
          //   field: 'site.Selectlabel',
          // },
          // {
          //
          //   headerName: 'site',
          //   field: 'site_id',
          //   hide: true,
          //   suppressColumnsToolPanel: true,
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['site']['Selectlabel']
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
          //       params.success(this.sitesData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },

          // {
          //   field: "emp_code",
          //   sortable: true,
          //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
          //   headerName: 'emp_code',
          // },


          // {
          //
          //   headerName: 'actif',
          //   field: 'actif_id',
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['actif']['Selectlabel']
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
          //       params.success(this.actifsData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },


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


          // {
          //   headerName: 'categorie',
          //   field: 'categorie.Selectlabel',
          // },
          // {
          //
          //   headerName: 'categorie',
          //   field: 'categorie_id',
          //   hide: true,
          //   suppressColumnsToolPanel: true,
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['categorie']['Selectlabel']
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
          //       params.success(this.categoriesData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },


          // {
          //   headerName: 'contrat',
          //   field: 'contrat.Selectlabel',
          // },
          // {
          //
          //   headerName: 'contrat',
          //   field: 'contrat_id',
          //   hide: true,
          //   suppressColumnsToolPanel: true,
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['contrat']['Selectlabel']
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
          //       params.success(this.contratsData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },


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


          // {
          //   headerName: 'echelon',
          //   field: 'echelon.Selectlabel',
          // },
          // {
          //
          //   headerName: 'echelon',
          //   field: 'echelon_id',
          //   hide: true,
          //   suppressColumnsToolPanel: true,
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['echelon']['Selectlabel']
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
          //       params.success(this.echelonsData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },


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


          // {
          //   headerName: 'matrimoniale',
          //   field: 'matrimoniale.Selectlabel',
          // },
          // {
          //
          //   headerName: 'matrimoniale',
          //   field: 'matrimoniale_id',
          //   hide: true,
          //   suppressColumnsToolPanel: true,
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['matrimoniale']['Selectlabel']
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
          //       params.success(this.matrimonialesData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },

          //
          // {
          //   headerName: 'nationalite',
          //   field: 'nationalite.Selectlabel',
          // },
          // {
          //
          //   headerName: 'nationalite',
          //   field: 'nationalite_id',
          //   hide: true,
          //   suppressColumnsToolPanel: true,
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['nationalite']['Selectlabel']
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
          //       params.success(this.nationalitesData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },


          // {
          //
          //   headerName: 'online',
          //   field: 'online_id',
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['online']['Selectlabel']
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
          //       params.success(this.onlinesData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },


          // {
          //   headerName: 'sexe',
          //   field: 'sexe.Selectlabel',
          // },
          // {
          //
          //   headerName: 'sexe',
          //   field: 'sexe_id',
          //   hide: true,
          //   suppressColumnsToolPanel: true,
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['sexe']['Selectlabel']
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
          //       params.success(this.sexesData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },


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
            headerName: 'client',
            field: 'client.Selectlabel',
          },
          {

            headerName: 'client',
            field: 'client_id',
            hide: true,
            suppressColumnsToolPanel: true,
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
            headerName: 'fonctions',
            field: 'fonction.Selectlabel',
          },
          {

            headerName: 'fonctions',
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


          // {
          //   headerName: 'situation',
          //   field: 'situation.Selectlabel',
          // },
          // {
          //
          //   headerName: 'situation',
          //   field: 'situation_id',
          //   hide: true,
          //   suppressColumnsToolPanel: true,
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['situation']['Selectlabel']
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
          //       params.success(this.situationsData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },


          // {
          //
          //   headerName: 'type',
          //   field: 'type_id',
          //   valueFormatter: params => {
          //     let retour = ''
          //     try {
          //       return params.data['type']['Selectlabel']
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
          //       params.success(this.typesData);
          //     },
          //     refreshValuesOnOpen: true,
          //   },
          // },


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

    // this.getactifs();
    // this.getbalises();
    // this.getcategories();
    // this.getcontrats();
    this.getdirections();
    // this.getechelons();
    this.getfactions();
    this.getfonctions();
    // this.getmatrimoniales();
    // this.getnationalites();
    // this.getonlines();
    this.getpointeuses();
    this.getpostes();
    this.getsexes();
    this.getsites();
    this.getclients();
    this.getfonctions();
    // this.getsituations();
    // this.gettypes();
    this.getvilles();
    this.getzones();
    this.gettransactions();

  },
  methods: {
    openCreate() {
      this.showForm('Create', {}, this.gridApi)
    },
    openCreateRapport() {
      this.showForm('CreateRapport', {}, this.gridApi, 'xl')
    },
    checkInDate() {
      // alert('on as chosit entre les dates et on peut desormait affricher le formulaire')
      this.key++
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

    getpointeuses() {
      this.axios.get('/api/pointeuses').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        this.pointeusesData = response.data

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


    gettransactions() {

      this.axios.get('/api/transactions').then((response) => {
        this.requette--
        if (this.requette == 0) {
          this.$store.commit('setIsLoading', false)
        }
        // this.transactionsData = response.data
        console.log('users', response.data)

      }).catch(error => {
        console.log(error.response.data)
        this.$store.commit('setIsLoading', false)
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },


  }
}
</script>
