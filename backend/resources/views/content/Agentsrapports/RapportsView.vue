<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">
                    Update Rapports #{{ formData.id }}
                </div>
                <div v-if="formState == 'Create'">Create Rapports</div>
            </template>

            <EditRapports v-if="formState == 'Update'" :key="formKey" :data="formData" :gridApi="formGridApi"
                          :modalFormId="formId" :usersData="usersData" @close="closeForm"/>

            <CreateRapports v-if="formState == 'Create'" :key="formKey" :gridApi="formGridApi" :modalFormId="formId"
                            :usersData="usersData" @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>

        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData"
                         :rowModelType="rowModelType" :url="url" className="ag-theme-alpine"
                         domLayout="autoHeight" rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>
                    <input v-model="month" class="form-control" placeholder="Veuillez selectioner le mois"
                           style="width: auto !important" type="month"/>
                </template>
            </AgGridTable>
        </div>
    </div>
</template>

<script>
import DataTable from "@/components/DataTable.vue";
import AgGridTable from "@/components/AgGridTable.vue";
import CreateRapports from "./CreateRapports.vue";
import EditRapports from "./EditRapports.vue";
import CustomFiltre from "@/components/CustomFiltre.vue";
import DataModal from "@/components/DataModal.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: "RapportsView",
    components: {
        DataTable,
        AgGridTable,
        CreateRapports,
        EditRapports,
        DataModal,
        AgGridBtnClicked,
        CustomFiltre
    },
    data() {
        return {
            month: null,
            formId: "agentsrapports",
            formState: "",
            formData: {},
            formWidth: "lg",
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: "http://127.0.0.1:8000/api/agents_rapports-Aggrid",
            table: "agentsrapports",
            usersData: [],
            requette: 8,
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
        columnDefs: function () {
            let columnDefs = [
                // {
                //     field: null,
                //     headerName: '',
                //     suppressCellSelection: true,
                //     minWidth: 80,maxWidth: 80,
                //     pinned: 'left',
                //     cellRendererSelector: params => {
                //         return {
                //             component: 'AgGridBtnClicked',
                //             params: {
                //                 clicked: field => {
                //                     this.showForm('Update', field, params.api)
                //                 },
                //                 render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                //             }
                //         };
                //     },
                //
                // },

                // {
                //     field: "mois",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'mois',
                // },

                {
                    headerName: "agent",
                    field: "user.Selectlabel",

                    pinned: "left",
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: "agent",
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
                    headerName: "total",
                    field: "Totalpresent",
                    maxWidth: 100,
                },
            ];

            for (let i = 1; i <= 31; i++) {
                let newChamp = {
                    field: `J${i}`,
                    maxWidth: 90,
                    maxWidth: 50,
                    headerName: `J${i}`,
                    cellStyle: {textAlign: 'center'}
                };
                columnDefs.push(newChamp);
            }
            return columnDefs;
        },
        extrasData: function () {
            let params = {};
            if (!this.month) {
                params["id"] = {values: [0], filterType: "set"};
            }
            this.tableKey++;

            return {
                baseFilter: params,
                month: this.month,
            };
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
        (this.url = this.axios.defaults.baseURL + "/api/agents_rapports-Aggrid"),
            (this.formId = this.table + "_" + Date.now());
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
    },
    beforeMount() {
    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getusers();

    },
    methods: {
        closeForm() {
            this.tableKey++;
        },
        openCreate() {
            this.showForm("Create", {}, this.gridApi);
        },
        showForm(type, data, gridApi, width = "lg") {
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
        getusers() {
            this.axios.get('/api/users/type_id/2,3').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.usersData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
    },
};
</script>
