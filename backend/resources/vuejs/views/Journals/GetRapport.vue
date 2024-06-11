<template>
  <b-overlay :show="isLoading">
    <form @submit.prevent="createLine()">
      <div class="mb-3">

        <div class="form-group">
          <label>libelle </label>
          <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'" required
                 type="text">

          <div v-if="errors.libelle" class="invalid-feedback">
            <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-6">
            <label>date de debut </label>
            <input v-model="form.debut" :class="errors.debut?'form-control is-invalid':'form-control'" required
                   type="date">

            <div v-if="errors.debut" class="invalid-feedback">
              <template v-for=" error in errors.debut"> {{ error[0] }}</template>

            </div>
          </div>
          <div class="form-group  col-sm-6">
            <label>date de fin </label>
            <input v-model="form.fin" :class="errors.fin?'form-control is-invalid':'form-control'" required
                   type="date">

            <div v-if="errors.fin" class="invalid-feedback">
              <template v-for=" error in errors.fin"> {{ error[0] }}</template>

            </div>
          </div>
        </div>


        <div class="form-group">
          <label>Filtrer les agents a prendre en compte dans le rapport</label>
          <div class="col-sm-12">
            <AgGridTable
                :key="tableKey"
                :cacheBlockSize="cacheBlockSize"
                :columnDefs="columnDefs"
                :extrasData="extrasData"
                :maxBlocksInCache="maxBlocksInCache"
                :pagination="pagination"
                :paginationPageSize="paginationPageSize"
                :rowData="rowData"
                :rowModelType="rowModelType"
                :show-export="false"
                :show-pagination="false"
                :url="url"
                className="ag-theme-alpine"
                dom-layout="normal"
                domLayout='autoHeight'
                rowSelection="multiple"
                @gridReady="onGridReady"
                @newData="newData"


            >

            </AgGridTable>

          </div>
        </div>


      </div>

      <button class="btn btn-primary" type="submit">
        <i class="fas fa-floppy-disk"></i> Créer et Telecharger
      </button>
    </form>
  </b-overlay>
</template>

<script>
import AgGridTable from "@/components/AgGridTable.vue"
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
  name: 'GetRapport',
  components: {VSelect, Files, AgGridTable},
  props: [
    'gridApi',
    'modalFormId',
    'actifsData',
    'balisesData',
    'categoriesData',
    'contratsData',
    'directionsData',
    'echelonsData',
    'factionsData',
    'fonctionsData',
    'matrimonialesData',
    'nationalitesData',
    'onlinesData',
    'postesData',
    'sexesData',
    'sitesData',
    'situationsData',
    'typesData',
    'usersData',
    'villesData',
    'zonesData',
  ],
  data() {
    return {
      errors: [],
      isLoading: false,
      form: {

        id: "",

        libelle: "",

        debut: "",
        fin: "",
        etats: "manuel",
        users: [],

        extra_attributes: "",

        created_at: "",

        updated_at: "",

        deleted_at: "",
      },
      defaultEntite: 'User',
      formId: "users",
      formState: "",
      formData: {},
      formWidth: 'lg',
      formGridApi: {},
      formKey: 0,
      tableKey: 0,
      url: 'http://127.0.0.1:8000/api/users-Aggrid',
      table: 'users',
      requette: 9,
      columnDefs: null,
      rowData: null,
      gridApi1: null,
      columnApi: null,
      rowModelType: null,
      pagination: true,
      paginationPageSize: 20,
      cacheBlockSize: 10,
      maxBlocksInCache: 1,
      extrasData: {},
      agGridData: null
    }
  },
  created() {
    if (this.$route.meta.listing == "automatique") {
      this.form.etats = 'automatique'
    }
    this.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
        this.formId = this.table + "_" + Date.now()
    this.rowBuffer = 0;
    this.rowModelType = 'serverSide';
    this.cacheBlockSize = 50;
    this.maxBlocksInCache = 2;
    let params = {}
    params['type_id'] = {values: [2], filterType: 'set'}
    this.extrasData['baseFilter'] = params
    this.extrasData['selectAllId'] = 1

  },
  beforeMount() {
    this.columnDefs = [
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
        field: "num_badge",
        sortable: true,
       filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
        headerName: 'badge',
      },


      {
        field: "date_naissance",
        sortable: true,
       filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
        headerName: 'date de naissance',
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
        field: "num_cnss",
        sortable: true,
       filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
        headerName: 'cnss',
      },


      {
        field: "num_cnamgs",
        sortable: true,
       filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
        headerName: 'cnamgs',
      },


      {
        field: "telephone1",
        sortable: true,
       filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
        headerName: 'telephone',
      },

      {
        field: "nombre_enfant",
        sortable: true,
       filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
        headerName: 'nombre_enfant',
      },

      {

        headerName: 'balise',
        field: 'balise_id',
        valueFormatter: params => {
          let retour = ''
          try {
            return params.data['balise']['Selectlabel']
          } catch (e) {

          }
          return retour
        },

        filter: 'agSetColumnFilter',
        filterParams: {suppressAndOrCondition: true,
          keyCreator: params => params.value.id,
          valueFormatter: params => params.value.Selectlabel,
          values: params => {
            params.success(this.balisesData);
          },
          refreshValuesOnOpen: true,
        },
      },


      {

        headerName: 'categorie',
        field: 'categorie_id',
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
        field: 'contrat_id',
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
        field: 'direction_id',
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
        field: 'echelon_id',
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

        headerName: 'matrimoniale',
        field: 'matrimoniale_id',
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
        field: 'nationalite_id',
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

        headerName: 'sexe',
        field: 'sexe_id',
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

        headerName: 'situation',
        field: 'situation_id',
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
    let defaultEntite = 'User'
    try {
      defaultEntite = this.$route.meta.defaultEntite
    } catch (e) {

    }
    this.defaultEntite = defaultEntite


  },
  methods: {

    onGridReady(params) {
      console.log('on demarre', params)
      this.gridApi1 = params.api;
      this.columnApi = params.columnApi;
      this.isLoading = false
    },


    newData(data) {
      this.agGridData = data
    },

    createLine() {
      console.log('API==>', this.agGridData)
      try {
        this.form['users'] = this.agGridData['__allId']
      } catch (e) {
      }
      this.isLoading = true
      this.axios.post('/api/get-apport', this.form).then(response => {
        this.isLoading = false
        this.resetForm()
        this.gridApi.applyServerSideTransaction({
          add: [
            response.data
          ],
        });
        this.gridApi.refreshServerSide()
        this.$bvModal.hide(this.modalFormId)
        this.$emit('close')
        window.open(response.data, "_blank");

        this.$toast.success('Operation effectuer avec succes')
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    resetForm() {
      this.form = {
        id: "",
        libelle: "",
        date: "",
        extra_attributes: "",
        created_at: "",
        updated_at: "",
        deleted_at: "",
      }
    }
  }
}
</script>
