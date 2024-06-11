<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Permissions #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Permissions</div>
            </template>


            <AgGridSearch
                v-if="formState == 'Create'"
                :columnDefs="add.columnDefs"
                :extrasData="add.extrasData"
                :filterFields="['name','nom']"
                :paginationPageSize="10"
                :url="add.url"
                filter-key=""
                filter-value=""
                @destruction="finishAddUser"
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
                    <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> Ajouter une permission
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import DataModal from '@/components/DataModal.vue'
import AgGridSearch from "@/components/AgGridSearch.vue"

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import Check from "./Check.vue";

export default {
    name: 'RolesView',
    components: {DataTable, AgGridTable, DataModal, AgGridSearch, AgGridBtnClicked, Check},
    props: ['roleId'],
    data() {

        return {
            formId: "roles",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/roleHasPermission-Aggrid',
            table: 'roles',
            requette: 0,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 10,
            cacheBlockSize: 10,
            permAdded: 0,
            maxBlocksInCache: 1,

            add: {
                formId: "listings",
                formState: "",
                formData: {},
                formWidth: "lg",
                formGridApi: {},
                formKey: 0,
                tableKey: 0,
                url: "http://127.0.0.1:8000/api/permissions-Aggrid",
                table: "Users",
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
                extrasData: {},
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
        extrasData: function () {
            let retour = {};
            let params = {};
            params["role_id"] = {values: [this.roleId], filterType: "set"};
            retour["baseFilter"] = params;

            return retour;
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
        this.url = this.axios.defaults.baseURL + '/api/roleHasPermission-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
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
                                    this.DeleteLine(field);
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`,
                            },
                        };
                    },

                },

                {
                    // field: "permission.name",
                    valueGetter: this.fullNameGetter2,
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },

                {
                    field: null,
                    suppressColumnsToolPanel: true,
                    sortable: false,
                    headerName: "Creer",
                    maxWidth: 100,
                    cellRendererSelector: (params) => {
                        let response = {
                            component: "Check",
                            params: {
                                clicked: (field) => {
                                    this.addUser(field);
                                },
                                type: 'canCreate'
                            }
                        };
                        return response;
                    },
                },
                {
                    field: null,
                    suppressColumnsToolPanel: true,
                    sortable: false,
                    headerName: "Editer",
                    maxWidth: 100,
                    cellRendererSelector: (params) => {
                        let response = {
                            component: "Check",
                            params: {
                                clicked: (field) => {
                                    this.addUser(field);
                                },
                                type: 'canUpdate'
                            },
                        };
                        return response;
                    },
                },
                {
                    field: null,
                    suppressColumnsToolPanel: true,
                    sortable: false,
                    headerName: "Suprimer",
                    maxWidth: 100,
                    cellRendererSelector: (params) => {
                        let response = {
                            component: "Check",
                            params: {
                                clicked: (field) => {
                                    this.addUser(field);
                                },
                                type: 'canDelete'
                            },
                        };
                        return response;
                    },
                },


            ];
        (this.add.url =
            this.axios.defaults.baseURL + "/api/permissions-Aggrid"),
            (this.add.rowBuffer = 0);
        this.add.rowModelType = "serverSide";
        this.add.columnDefs = [
            {
                field: null,
                width: 40,
                pinned: "left",
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: "",
                cellRendererSelector: (params) => {
                    let response = {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.addUser(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa fa-plus"></i></div>`,
                        },
                    };
                    return response;
                },
            },
            {
                // sortable: true,
                // filter: "agTextColumnFilter",
                // filterParams: {suppressAndOrCondition: true},
                valueGetter: this.fullNameGetter,
                headerName: "libelle",
            },
        ];
        this.add.cacheBlockSize = 50;
        this.add.maxBlocksInCache = 2;

    },
    beforeMount() {


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }


    },
    methods: {
        fullNameGetter(params) {
            if (params.data.nom) {
                return params.data.nom;
            } else {

                return params.data.name;
            }
        },
        fullNameGetter2(params) {
            if (params.data.permission.nom) {
                return params.data.permission.nom;
            } else {
                return params.data.permission.name;
            }
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
            this.gridApi.sizeColumnsToFit();

        },
        addUser(element) {
            let data = {
                role_id: this.roleId,
                permission_id: element.id,
            };
            // console.log("voici les donnees ===>", data);

            this.isLoading = true;
            this.axios
                .post("/api/roleHasPermission", data)
                .then((response) => {
                    this.isLoading = false;
                    this.permAdded++;
                    this.$toast.success("Operation effectuer avec succes");
                    this.$emit("close");
                    console.log(response.data);
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    this.isLoading = false;
                    this.$toast.error(
                        "Erreur survenue lors de l'enregistrement"
                    );
                });
        },
        finishAddUser() {
            // evenement appeler lorsquon ferme le formulaire dajout des agents
            // on verifie si on ajouter des agents et on met a jour le tableau sinon on ne fait rien
            if (this.permAdded > 0) {
                this.tableKey++;
            }
            this.permAdded = 0;
            this.$bvModal.hide(this.formId);
        },
        DeleteLine(element) {
            this.isLoading = true;
            this.axios
                .post("/api/roleHasPermission/" + element.id + "/delete")
                .then((response) => {
                    this.isLoading = false;
                    this.tableKey++;

                    this.$toast.success("Operation effectuer avec succes");
                    this.$emit("close");
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error.response.data);
                    this.isLoading = false;
                    this.$toast.error("Erreur survenue lors de la suppression");
                });
        },
    }
}
</script>
