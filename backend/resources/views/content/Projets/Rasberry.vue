<template>
    <div class="row">
        <template>
            <!-- <b-overlay :show="isLoading"> -->
            <form @submit.prevent="createLine()">


                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>card_no </label>
                            <input v-model="form.card_no"
                                   :class="errors.card_no ? 'form-control is-invalid' : 'form-control'"
                                   type="text">

                            <div v-if="errors.card_no" class="invalid-feedback">
                                <template v-for=" error in errors.card_no"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Créer
                </button>
            </form>
            <!-- </b-overlay> -->
        </template>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
// import CreateProjets from './CreateProjets.vue'
// import EditProjets from './EditProjets.vue'
import DataModal from '@/components/DataModal.vue'
import ProjetsCard from "./ProjetsCard.vue";
import BesoinsView from "./Besoins/BesoinsView.vue";
import {v4 as uuidv4} from 'uuid';
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ProjetsView',
    components: {
        DataTable,
        AgGridTable,
        // CreateProjets,
        // EditProjets,
        DataModal,
        AgGridBtnClicked,
        ProjetsCard,
        BesoinsView
    },
    data() {

        return {
            formId: "projets",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/projets-Aggrid',
            table: 'projets',
            requette: 0,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            detailCellRenderer: null,
            errors: [],
            form: {

                id: "",

                card_no: "",
                area_alias: "",
                emp_code: "",
                punch_date: "",
                punch_time: "",
            },
            date: {
                anne: new Date().toISOString().slice(0, 10),
                timestamp: new Date().toISOString().slice(0, 19).replace('T', ' ')
            },
        }
    },

    computed: {
        routeData: function () {
            let router = {meta: {}}
            if (window.router) {
                try {
                    router = window.router;
                } catch (e) {
                }
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
    // watch: {
    //     'routeData': {
    //         handler: function (after, before) {
    //             this.gridApi.setFilterModel(null)
    //             this.gridApi.refreshServerSide()
    //         },
    //         deep: true
    //     },
    // },
    // created() {
    //     this.url = this.axios.defaults.baseURL + '/api/projets-Aggrid',
    //         this.formId = this.table + "_" + Date.now()
    //     this.rowBuffer = 0;
    //     this.rowModelType = 'serverSide';
    //     this.cacheBlockSize = 50;
    //     this.maxBlocksInCache = 2;
    //     this.detailCellRenderer = "BesoinsView"

    // },
    // beforeMount() {
    //     this.columnDefs =
    //         [
    //             {
    //                 field: null,
    //                 headerName: '',
    //                 suppressCellSelection: true,
    //                 minWidth: 80,maxWidth: 80,
    //                 pinned: 'left',
    //                 cellRendererSelector: params => {
    //                     return {
    //                         component: 'AgGridBtnClicked',
    //                         params: {
    //                             clicked: field => {
    //                                 this.showForm('Update', field, params.api)
    //                             },
    //                             render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
    //                         }
    //                     };
    //                 },

    //             },


    //             {
    //                 field: "libelle",
    //                 sortable: true,
    //                 filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
    //                 headerName: 'libelle',
    //             },


    //             {
    //                 field: "descriptions",
    //                 sortable: true,
    //                 filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
    //                 headerName: 'descriptions',
    //             },


    //             {
    //                 field: "debut_previsionnel",
    //                 sortable: true,
    //                 filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
    //                 headerName: 'debut_previsionnel',
    //                 valueFormatter: params => {
    //                     let retour = params.value
    //                     try {
    //                         retour = params.value.split(' ')[0]
    //                     } catch (e) {

    //                     }
    //                     return retour
    //                 }
    //             },


    //             {
    //                 field: "fin_previsionnel",
    //                 sortable: true,
    //                 filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
    //                 headerName: 'fin_previsionnel',
    //                 valueFormatter: params => {
    //                     let retour = params.value
    //                     try {
    //                         retour = params.value.split(' ')[0]
    //                     } catch (e) {

    //                     }
    //                     return retour
    //                 }
    //             },


    //             {
    //                 field: "debut_reel",
    //                 sortable: true,
    //                 filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
    //                 headerName: 'debut_reel',
    //                 valueFormatter: params => {
    //                     let retour = params.value
    //                     try {
    //                         retour = params.value.split(' ')[0]
    //                     } catch (e) {

    //                     }
    //                     return retour
    //                 }
    //             },


    //             {
    //                 field: "fin_reel",
    //                 sortable: true,
    //                 filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
    //                 headerName: 'fin_reel',
    //                 valueFormatter: params => {
    //                     let retour = params.value
    //                     try {
    //                         retour = params.value.split(' ')[0]
    //                     } catch (e) {

    //                     }
    //                     return retour
    //                 }
    //             },


    //             {
    //                 field: "creat_by",
    //                 sortable: true,
    //                 filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
    //                 headerName: 'creat_by',
    //             },


    //         ];

    //     this.columnDefs = [
    //         {
    //             field: null,
    //             headerName: 'Actions',
    //             suppressCellSelection: true,
    //             autoHeight: true,
    //             cellRendererSelector: params => {
    //                 return {
    //                     component: 'ProjetsCard',
    //                     params: {
    //                         clicked: field => {
    //                             this.showForm('Update', field, params.api, 'xl')
    //                         },
    //                         updateElement: field => {
    //                             this.showForm('Update', field, params.api, 'xl')
    //                         },
    //                         deleteElement: field => {
    //                             this.showForm('Update', field, params.api, 'xl')
    //                         },
    //                         showChild: field => {
    //                             console.log('on veut afficher', Object.getOwnPropertyNames(params.api));
    //                             // console.log('on veut afficher',params.api.get)
    //                             // params.api.getRow()
    //                             params.api.getRowNode(1).setExpanded(true)

    //                             this.showForm('Update', field, params.api, 'xl')
    //                         },
    //                         hideChild: field => {

    //                             this.showForm('Update', field, params.api, 'xl')
    //                         },
    //                     }
    //                 };
    //             },
    //         },]


    // },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

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

            this.gridApi.sizeColumnsToFit();
        },
        createLine() {
            this.form.bio_id = uuidv4();
            this.form.area_alias = "Gtech_prototype_1"
            this.form.emp_code = this.form.card_no
            this.form.punch_date = this.date.anne
            this.form.punch_time = this.date.timestamp
            this.isLoading = true
            // console.log('this.form', this.form)

            this.axios.post('/api/transactions', this.form).then(response => {
                // this.isLoading = false
                this.resetForm()
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        resetForm() {
            this.form = {
                id: "",
                card_no: "",
            }
        }
    }
}
</script>
<style>
#Projets-table .ag-theme-alpine .ag-header {
    display: none
}

#Projets-table .ag-theme-alpine .ag-row {
    border-bottom: 1px solid #fff !important
}

#Projets-table .ag-theme-alpine .ag-row:hover {
    background: #fff !important;

}

#Projets-table .ag-theme-alpine {
    --ag-borders: none;
    --ag-alpine-active-color: #fff !important;
    --ag-row-hover-color: #fff !important;

}

.ag-root-wrapper {
    border-radius: 5px
}

#Projets-table .ag-theme-alpine .ag-paging-panel {
    /*display: none*/
}

#Projets-table .ag-theme-alpine .ag-layout-auto-height .ag-center-cols-container {
    min-height: 0px !important;
}

#Projets-table .ag-theme-alpine .ag-layout-auto-height .ag-center-cols-clipper {
    min-height: 0px !important;
}

#Projets-table .ag-theme-alpine .ag-paging-panel {
    border-top: 0px !important;
}

.ag-root-wrapper {
    border-radius: 5px;
    border-color: #fff
}
</style>
