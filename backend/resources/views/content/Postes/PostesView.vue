<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Postes #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Postes</div>
            </template>

            <EditPostes v-if="formState == 'Update'" :key="formKey" :contratsclientsData="contratsclientsData"
                        :data="formData"
                        :gridApi="formGridApi" :modalFormId="formId" :pointeusesData="pointeusesData"
                        :sitesData="sitesData" @close="closeForm"/>


            <CreatePostes v-if="formState == 'Create'" :key="formKey" :contratsclientsData="contratsclientsData"
                          :gridApi="formGridApi"
                          :modalFormId="formId" :pointeusesData="pointeusesData" :sitesData="sitesData"
                          @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <div class="childBlock">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :getRowStyle="getRowStyle" :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData" :rowModelType="rowModelType" :url="url"
                         className="ag-theme-alpine" domLayout='autoHeight' rowSelection="multiple"
                         @gridReady="onGridReady">
                <template #header_buttons>
                    <div class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> Ajouter un poste
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreatePostes from './CreatePostes.vue'
import EditPostes from './EditPostes.vue'
import DataModal from '@/components/DataModal.vue'
import CustomFiltre from "@/components/CustomFiltre.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'PostesView',
    components: {DataTable, AgGridTable, CreatePostes, EditPostes, DataModal, AgGridBtnClicked, CustomFiltre},

    data() {

        return {
            formId: "postes",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/postes-Aggrid',
            table: 'postes',
            contratsclientsData: [],
            zoneselectionner: [],
            typeselectionner: [],
            zonesget: [],
            typesget: [],
            clientsData: [],
            zonesData: [],
            pointeusesData: [],
            sitesData: [],
            statutsData: [],
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
            if (!this.zoneselectionner) {
                // params["id"] = { values: [0], filterType: "set" };
            }
            this.tableKey++;

            return {
                baseFilter: params,
                zoneselectionner: this.zoneselectionner,
                typeselectionner: this.typeselectionner,
            };

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
        this.url = this.axios.defaults.baseURL + '/api/postes-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        this.statutsData = [
            'entierement couvert',
            'partiellement couvert',
            'non couvert'
        ];


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
                                    this.showForm('Update', field, params.api, "xl")
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },
                {
                    hide: !this.$routeData.meta.hideCreate,
                    headerName: 'code',
                    field: 'CodeConcat',
                    minWidth: 180, maxWidth: 180,
                },
                {
                    headerName: 'client',
                    field: 'site.client.Selectlabel',
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
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/clients-Aggrid',
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

                {
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                    width: 200,
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
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/sites-Aggrid',
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
                {
                    headerName: 'zone',
                    field: 'site.zone.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'type',
                    field: 'typesposte_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['typesposte']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "FiltreEntete",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/typespostes-Aggrid',
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
                    filter: "FiltreEntete",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/zones-Aggrid',
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


                {
                    field: "Agentjour",
                    sortable: true,
                    minWidth: 100, maxWidth: 100,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Jours',
                },
                {
                    field: "Agentnuit",
                    sortable: true,
                    minWidth: 100, maxWidth: 100,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Nuits',
                },

                {
                    field: null,
                    headerName: 'pointeuses',
                    suppressCellSelection: true,
                    cellRendererSelector: params => {
                        let pointeuses = 0;
                        try {
                            pointeuses = JSON.parse(params.data.pointeuses).length
                        } catch (e) {
                        }
                        let retour = {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                },
                                render: `<div class="" style="width:100%;height:100%;color:black;border-radius:5px;text-align:center;cursor:default"> ${pointeuses} Pointeuses </div>`
                            }
                        }
                        if (pointeuses <= 0) {
                            retour = {
                                component: 'AgGridBtnClicked',
                                params: {
                                    clicked: field => {
                                    },
                                    render: `<div class="" style="width:100%;height:100%;color:red;border-radius:5px;text-align:center;cursor:default"><i class="fa-solid fa-triangle-exclamation"></i> ${pointeuses} pointeuse  </div>`
                                }
                            }
                        }
                        return retour;
                    },

                },

                {
                    field: "code",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'code',
                    hide: true,
                },


                {
                    headerName: 'contrats',
                    field: 'contratsclient.Selectlabel',
                    hide: true,
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'contratsclient',
                    field: 'contratsclient_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['contratsclient']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/contratsclients-Aggrid',
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


                {
                    headerName: 'articles',
                    field: 'postesarticle.Selectlabel',
                    // hide: true,
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'postesarticle',
                    field: 'postesarticle_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['postesarticle']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/postesarticles-Aggrid',
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


                {
                    field: "jours",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'jours couverts',
                    hide: true,
                },

                {

                    headerName: 'statut',
                    field: 'statut_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['statut']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },

                    filter: 'agSetColumnFilter',
                    filterParams: {
                        suppressAndOrCondition: true,
                        keyCreator: params => params.value,
                        valueFormatter: params => params.value,
                        values: params => {
                            params.success(this.statutsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },
                {
                    headerName: 'typesposte',
                    field: 'typesposte.Selectlabel',
                },
                {

                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'typesposte',
                    field: 'typesposte_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['typesposte']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },

                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/typespostes-Aggrid',
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

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.zonesget = this.$routeData.meta.zonesGet
        this.typesget = this.$routeData.meta.typesGet
        console.log('this.typesget', this.$routeData.meta.typesGet);
        // this.getcontratsclients();
        // this.getclients();
        // this.getzones();
        // this.getpointeuses();
        // this.getsites();

    },
    methods: {

        getRowStyle(params) {
            let style = {}
            console.log('RowParams===', params)
            try {

                if (params.data.validation_couverture == 0) {
                    style.background = "#ff000070"
                }
                if (params.data.validation_couverture == 1) {
                    style.background = "#ECA84C"
                }
            } catch (e) {

            }
            return style;
        },
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
        getcontratsclients() {
            this.axios.get('/api/contratsclients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.contratsclientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getclients() {
            this.axios.get('/api/clients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.clientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getzones() {
            this.axios.get('/api/zones').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.zonesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
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

        getsites() {
            this.axios.get('/api/sites').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.sitesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        zoneselect(zone) {
            //   this.actualZone = zone;
            if (this.zoneselectionner.includes(zone)) {
                // Zone is already selected, so we want to deselect it
                const index = this.zoneselectionner.indexOf(zone);
                if (index !== -1) {
                    this.zoneselectionner.splice(index, 1); // Remove the zone from the array
                }
            } else {
                // Zone is not selected, so we want to select it
                this.zoneselectionner.push(zone);
            }

            // console.log('this.zoneselectionner', this.zoneselectionner)
        },

        typeselect(type) {
            if (this.typeselectionner.includes(type)) {
                // type is already selected, so we want to deselect it
                const index = this.typeselectionner.indexOf(type);
                if (index !== -1) {
                    this.typeselectionner.splice(index, 1); // Remove the zone from the array
                }
            } else {
                // type is not selected, so we want to select it
                this.typeselectionner.push(type);
            }

        },
    }
}
</script>

<style>
.ag-root-wrapper {
    border-radius: 5px
}

.childBlock {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 95%;
    margin: 10px auto;
}

.newButton {
    text-align: center;
    margin: 0 auto;
    position: absolute;
    top: 15px;
    right: 30px;
    border-radius: 5px;
    padding: 10px;
    background: #0004ff;
    color: #fff;
}
</style>
