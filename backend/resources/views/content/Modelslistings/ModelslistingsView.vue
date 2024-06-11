<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">
                    Update Modelslistings #{{ formData.id }}
                </div>
                <div v-if="formState == 'Create'">Create Modelslistings</div>
            </template>

            <EditModelslistings v-if="formState == 'Update'" :key="formKey" :data="formData"
                                :factionsData="factionsData"
                                :gridApi="formGridApi" :modalFormId="formId" :usersData="usersData"
                                :zonesData="zonesData"
                                @close="closeForm"/>

            <CreateModelslistings v-if="formState == 'Create'" :key="formKey" :factionsData="factionsData"
                                  :gridApi="formGridApi"
                                  :modalFormId="formId" :usersData="usersData" :zonesData="zonesData"
                                  @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>

        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :maxBlocksInCache="maxBlocksInCache"
                         :pagination="pagination" :paginationPageSize="paginationPageSize" :rowData="rowData"
                         :rowModelType="rowModelType"
                         :url="url" className="ag-theme-alpine" domLayout="autoHeight"
                         rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>
                    <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate">
                        <i class="fa fa-plus"></i> Nouveau
                    </div>
                </template>
            </AgGridTable>
        </div>
    </div>
</template>

<script>
import DataTable from "@/components/DataTable.vue";
import AgGridTable from "@/components/AgGridTable.vue";
import CreateModelslistings from "./CreateModelslistings.vue";
import EditModelslistings from "./EditModelslistings.vue";
import DataModal from "@/components/DataModal.vue";
import CustomFiltre from "@/components/CustomFiltre.vue";

import AnalysesImports from './AnalysesImports.vue'
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: "ModelslistingsView",
    components: {
        DataTable,
        AgGridTable,
        CreateModelslistings,
        EditModelslistings,
        DataModal,
        CustomFiltre,
        AgGridBtnClicked,
        AnalysesImports
    },
    data() {
        return {
            formId: "modelslistings",
            formState: "",
            formData: {},
            formWidth: "xl",
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: "http://127.0.0.1:8000/api/modelslistings-Aggrid",
            table: "modelslistings",
            zonesData: [],
            factionsData: ["Jour", "Nuit"],
            usersData: [],
            requette: 1,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
        };
    },

    computed: {
        routeData: function () {
            let router = {meta: {}};
            if (window.router) {
                try {
                    router = window.router;
                } catch (e) {
                }
            }

            return router;
        },
        taille: function () {
            let result = "col-sm-12";
            if (this.filtre) {
                result = "col-sm-9";
            }
            return result;
        },
    },
    watch: {
        routeData: {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null);
                this.gridApi.refreshServerSide();
            },
            deep: true,
        },
    },
    created() {
        (this.url = this.axios.defaults.baseURL + "/api/modelslistings-Aggrid"),
            (this.formId = this.table + "_" + Date.now());
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
    },
    beforeMount() {
        this.columnDefs = [
            {
                field: null,
                headerName: "",
                suppressCellSelection: true,
                minWidth: 80, maxWidth: 80,
                pinned: "left",
                cellRendererSelector: (params) => {
                    return {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.showForm("Update", field, params.api);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                        },
                    };
                },
            },

            {
                field: "Libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Libelle",
            },
            // {
            //     field: "typelistings",
            //     sortable: true,
            //     filter: "agTextColumnFilter",
            //     filterParams: {suppressAndOrCondition: true},
            //     headerName: "type de listings",
            // },
            // {
            //     field: "faction",
            //     sortable: true,
            //     filter: "agTextColumnFilter",
            //     filterParams: {suppressAndOrCondition: true},
            //     headerName: "faction",
            // },

            //
            // {
            //     field: "date",
            //     sortable: true,
            //     filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            //     headerName: 'date',
            // },

            // {
            //     headerName: 'faction',
            //     field: 'faction.Selectlabel',
            // },
            // {
            //     hide: true,
            //     suppressColumnsToolPanel: true,

            //     headerName: 'faction',
            //     field: 'faction',
            //     valueFormatter: params => {
            //         let retour = ''
            //         try {
            //             return params.data['faction']['Selectlabel']
            //         } catch (e) {

            //         }
            //         return retour
            //     },

            //     filter: 'agSetColumnFilter',
            //     filterParams: {
            //         suppressAndOrCondition: true,
            //         keyCreator: params => params.value.id,
            //         valueFormatter: params => params.value.Selectlabel,
            //         values: params => {
            //             params.success(this.factionsData);
            //         },
            //         refreshValuesOnOpen: true,
            //     },
            // },

            // {
            //     field: "postes",
            //     sortable: true,
            //     filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            //     headerName: 'postes',
            // },

            {
                headerName: "zone",
                field: "zone.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "zone",
                field: "zone_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["zone"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: "CustomFiltre",
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
                headerName: " valideur 1",
                field: "user.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "valideur 1",
                field: "user_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["user"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: "CustomFiltre",
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/users-Aggrid',
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
                                    return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
                                } catch (e) {
                                }
                                return retour;
                            },
                        },
                    ],
                    filterFields: ['matricule', 'nom', 'prenom'],
                },
            },
            {
                headerName: "valideur 1",
                field: "user2.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "valideur 1",
                field: "user_id_2",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["user"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: "CustomFiltre",
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/users-Aggrid',
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
                                    return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
                                } catch (e) {
                                }
                                return retour;
                            },
                        },
                    ],
                    filterFields: ['matricule', 'nom', 'prenom'],
                },
            },
            {
                headerName: "valideur 2",
                field: "user3.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "valideur 2",
                field: "user_id_3",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["user3"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: "CustomFiltre",
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/users-Aggrid',
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
                                    return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
                                } catch (e) {
                                }
                                return retour;
                            },
                        },
                    ],
                    filterFields: ['matricule', 'nom', 'prenom'],
                },
            },
            {
                headerName: "valideur 2",
                field: "user4.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "valideur 2",
                field: "user_id_4",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["user4"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: "CustomFiltre",
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/users-Aggrid',
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
                                    return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
                                } catch (e) {
                                }
                                return retour;
                            },
                        },
                    ],
                    filterFields: ['matricule', 'nom', 'prenom'],
                },
            },
            {
                field: "etats",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'etats',
                hide: true,
                wrapText: true,
                autoHeight: true,
                cellRendererSelector: params => {
                    return {
                        component: 'AnalysesImports',
                        params: {
                            validerImport: field => {
                                this.validerImport(field)
                            },
                            annulerImport: field => {
                                this.annulerImport(field)
                            },
                        }
                    };
                },
            },

        ];
    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        console.log("factionsData=>", this.factionsData);
        // this.getzones();
        // this.getfactions();
        // this.getusers();
    },
    methods: {
        closeForm() {
            this.tableKey++;
        },
        openCreate() {
            this.showForm("Create", {}, this.gridApi);
        },
        showForm(type, data, gridApi, width = "xl") {
            this.formKey++;
            this.formWidth = width;
            this.formState = type;
            this.formData = data;
            this.formGridApi = gridApi;
            this.$bvModal.show(this.formId);
        },
        onGridReady(params) {
            console.log("on demarre", params);
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false;
        },
        getzones() {
            this.axios
                .get("/api/zones")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.zonesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },
        // getfactions() {
        //     this.axios.get('/api/factions').then((response) => {
        //         this.requette--
        //         if (this.requette == 0) {
        //             // this.$store.commit('setIsLoading', false)
        //         }
        //         this.factionsData = response.data

        //     }).catch(error => {
        //         console.log(error.response.data)
        //         // this.$store.commit('setIsLoading', false)
        //         this.$toast.error('Erreur survenue lors de la récuperation')
        //     })
        // },
        getusers() {
            this.axios
                .get("/api/users/type_id/2,3")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.usersData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },
    },
};
</script>
