<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Taches #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Taches</div>
            </template>

            <EditTaches
                v-if="formState=='Update'"
                :key="formKey"
                :data="formData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :pointeusesData="pointeusesData"
                :typestachesData="typestachesData"
                :typetacheselectionner="typetacheselectionner"
                :villesData="villesData"
                @close="closeForm"
            />


            <CreateTaches
                v-if="formState=='Create'"
                :key="formKey"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :pointeusesData="pointeusesData"
                :typestachesData="typestachesData"
                :typetacheselectionner="typetacheselectionner"
                :villesData="villesData"
                @close="closeForm"
            />

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>

        <div class="col-sm-12 card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-1" style="text-align: center;
display: flex;
justify-content: center;
align-content: center;
align-items: center;">

                        <h5 class="card-title">Type</h5>
                    </div>
                    <div class="col-sm-10">

                        <button v-for="items  in typetachesget" v-b-tooltip.hover
                                :style="typetacheselectionner==items.id ? 'border: 3px solid  green' : ''"
                                class="btn card-body"
                                style=""
                                @click.prevent="typetacheselect(items.id)">
                            <div class="iconParent">
                            <span> <i class="fa-solid fa-filter"></i>

                                {{ items.libelle }}
                            </span>

                            </div>
                        </button>
                    </div>
                </div>
            </div>

        </div>
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
                :url="url"
                className="ag-theme-alpine"
                domLayout='autoHeight'
                rowSelection="multiple"
                @gridReady="onGridReady"

            >
                <template #header_buttons>
                    <div v-if="!$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i>
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
import CreateTaches from './CreateTaches.vue'
import EditTaches from './EditTaches.vue'
import DataModal from '@/components/DataModal.vue'
import moment from 'moment'

import CustomFiltre from "@/components/CustomFiltre.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'TachesView',
    components: {DataTable, AgGridTable, CreateTaches, EditTaches, DataModal, AgGridBtnClicked, CustomFiltre},
    data() {

        return {
            formId: "taches",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/taches-Aggrid',
            table: 'taches',
            typestachesData: [],
            typetacheselectionner: null,
            typetachesget: [],
            villesData: [],
            pointeusesData: [],
            requette: 2,
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

    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },
        taille: function () {
            let result = 'col-sm-12'
            if (this.filtre) {
                result = 'col-sm-9'
            }
            return result
        },
        extrasData: function () {
            // let retour = {}
            let params = {}
            if (!this.typetacheselectionner) {
                // params["id"] = { values: [0], filterType: "set" };
            }
            this.tableKey++;

            return {
                baseFilter: params,
                typetacheselectionner: this.typetacheselectionner,
            };

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
        this.url = this.axios.defaults.baseURL + '/api/taches-Aggrid',
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
                    field: "id",
                    sortable: true,
                    filter: 'agTextColumnFilter',
                    filterParams: {suppressAndOrCondition: true,},
                    hide: true,
                    headerName: '#Id',
                },
                {
                    field: null,
                    headerName: '',
                    suppressCellSelection: true,
                    minWidth: 80, maxWidth: 80,
                    pinned: 'left',
                    cellRendererSelector: params => {
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api, 'xl')
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                            }
                        };
                    },

                },


                {
                    field: "code",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'code',
                },


                {
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },


                {
                    headerName: 'type',
                    field: 'typestache.Selectlabel',
                },
                {

                    headerName: 'type',
                    field: 'typestache_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['typestache']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/typestaches-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["Selectlabel"]}`;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['libelle'],
                    },
                },


                // {
                //     headerName: 'ville',
                //     field: 'ville.Selectlabel',
                // },
                // {

                //     headerName: 'ville',
                //     field: 'ville_id',
                //     hide: true,
                //     suppressColumnsToolPanel: true,
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['ville']['Selectlabel']
                //         } catch (e) {

                //         }
                //         return retour
                //     },
                //     filter: "CustomFiltre",
                //     filterParams: {
                //         url: this.axios.defaults.baseURL + '/api/villes-Aggrid',
                //         columnDefs: [
                //             {
                //                 field: "",
                //                 sortable: true,
                //                 filter: "agTextColumnFilter",
                //                 filterParams: {suppressAndOrCondition: true},
                //                 headerName: "",
                //                 cellStyle: {fontSize: '11px'},
                //                 valueFormatter: (params) => {
                //                     let retour = "";
                //                     try {
                //                         return `${params.data["Selectlabel"]}`;
                //                     } catch (e) {
                //                     }
                //                     return retour;
                //                 },
                //             },
                //         ],
                //         filterFields: ['libelle'],
                //     },
                // },
                {
                    field: "created_at",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Créer le',
                    valueFormatter: params => {
                        let retour = params.value
                        try {
                            if (retour) {
                                retour = moment(params.value).format('DD/MM/YYYY à HH:mm')

                            } else {
                                retour = 'Date inconnue'
                            }
                        } catch (e) {

                        }
                        return retour
                    }
                },

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.typetachesget = this.$routeData.meta.typetachesGet
        // this.gettypestaches();
        // this.getvilles();
        // this.getpointeuses();

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
        gettypestaches() {
            this.axios.get('/api/typestaches').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.typestachesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getvilles() {
            this.axios.get('/api/villes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.villesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getpointeuses() {
            this.axios.get('/api/pointeuses').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.pointeusesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        typetacheselect(typetache) {
            this.typetacheselectionner = typetache;
            //   this.actualZone = typetache;
            // if (this.typetacheselectionner.includes(typetache)) {
            //     // Zone is already selected, so we want to deselect it
            //     const index = this.typetacheselectionner.indexOf(typetache);
            //     if (index !== -1) {
            //         this.typetacheselectionner.splice(index, 1); // Remove the typetache from the array
            //     }
            // } else {
            //     // Zone is not selected, so we want to select it
            //     this.typetacheselectionner.push(typetache);
            // }

            // console.log('this.typetacheselectionner', this.typetacheselectionner)
        },

    }
}
</script>
