<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Imports #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Imports</div>
            </template>

            <EditImports v-if="formState == 'Update'" :key="formKey" :data="formData" :gridApi="formGridApi"
                         :modalFormId="formId" :type="type" @close="closeForm"/>

            <CreateImports v-if="formState == 'Create'" :key="formKey" :data="formData" :gridApi="formGridApi"
                           :modalFormId="formId" :type="type" @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData" :rowModelType="rowModelType"
                         :url="url"
                         className="ag-theme-alpine" domLayout='autoHeight' rowSelection="multiple"
                         @gridReady="onGridReady">
                <template #header_buttons>
                    <div v-if="type != 'importspostes' && type != 'importspointages'" class="btn btn-primary"
                         @click="openImport('agents')">
                        <i class="fa fa-plus"></i>
                        Importer agents
                    </div>
                    <!-- <button v-if="!$routeData.meta.ispostes && $routeData.meta.domaine == 'sgs'" class="btn btn-primary"
                            @click="openImport('one')">
                        <i class="fa fa-plus"></i>
                        Importer one
                    </button> -->
                    <button v-if="type == 'importspostes'" class="btn btn-primary" @click="openImport('postes')">
                        <i class="fa fa-plus"></i>
                        Importer postes
                    </button>
                    <button v-if="type == 'importspointages'" class="btn btn-primary" @click="openImport('pointages')">
                        <i class="fa fa-plus"></i>
                        Importer pointages
                    </button>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateImports from './CreateImports.vue'
import moment from 'moment'
import EditImports from './EditImports.vue'
import AnalysesImports from './AnalysesImports.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ImportsView',
    components: {DataTable, AgGridTable, CreateImports, EditImports, DataModal, AgGridBtnClicked, AnalysesImports},
    props: ['type'],
    data() {

        return {
            formId: "imports",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            file: [],
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/imports-Aggrid',
            table: 'imports',
            requette: 0,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            // extrasData: {},
            maxBlocksInCache: 1,
            importParamsagents: {
                type: "effectifs",
                allChamps: [
                    "nom",
                    "prenom",
                    "matricule",
                    "naissance",
                    "embauche",
                    "cnamgs",
                    "cnss",
                    "nationalite",
                    "fonction",
                    "direction",
                    "echelon",
                    "categorie",
                    "contrat",
                ],
            },
            importParamspostes: {
                type: "postes",
                allChamps: [
                    "code",
                    "libelle",
                    "jours",
                    "maxjours",
                    "maxnuits",
                ],
            },
            importParamspointages: {
                type: "pointages",
                allChamps: [
                    "date",
                    "badge",
                    "pointeuse",
                    "idpointeuse",
                ],
            },
        }
    },

    computed: {
        $domaine: function () {
            let domaine = 'supervizr';
            try {
                domaine = window.domaine
            } catch (e) {
            }

            console.log('voila le domaine ==>', domaine)
            return domaine;
        },
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != "undefined") {
                    router = window.routeData;
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
            let retour = {};
            let params = {};
            if (this.type == 'importspostes') {
                params["type"] = {values: ['postes'], filterType: "set"};
                this.tableKey++
            } else if (this.type == 'importspointages') {
                params["type"] = {values: ['pointages'], filterType: "set"};
                this.tableKey++
            } else {
                params["type"] = {values: ['agents-one', 'agents', 'effectifs'], filterType: "set"};
                // params["type"] = {values: ['effectifs'], filterType: "set"};
                this.tableKey++

            }
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
        this.url = this.axios.defaults.baseURL + '/api/imports-Aggrid',
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
                    minWidth: 80, maxWidth: 80,
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
                    field: "created_at",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Importer le',
                    valueFormatter: params => {
                        let retour = params.value
                        try {
                            retour = moment(params.value).format('DD/MM/YYYY à HH:mm')
                        } catch (e) {

                        }
                        return retour
                    }
                },

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
                //                     this.download(field.file)
                //                 },
                //                 render: `<div class="" style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-download"></i></div>`
                //             }
                //         };
                //     },

                // },

                {
                    // field: "type",
                    valueGetter: this.fullNameGetter,
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'type',
                },


                {
                    field: "etats",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'etats',
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

                {
                    field: "create",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Nbrs creation',
                },

                {
                    field: "update",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: "Nbrs d'edition",
                },

                {
                    field: "delete",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: "Nbrs supprimer",
                },
                {
                    field: "creat_by",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'importer par',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['user']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: 'agSetColumnFilter',
                    filterParams: {
                        suppressAndOrCondition: true,
                        keyCreator: params => params.value.id,
                        valueFormatter: params => params.value.Selectlabel,
                        values: params => {
                            params.success(this.usersData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }


    },
    methods: {
        fullNameGetter(params) {
            if (params.data.typesposte_id) {

                return params.data.typesposte.Selectlabel;

            } else if (params.data.typeseffectif) {

                return params.data.typeseffectif.Selectlabel;
            } else {

                return params.data.type;
            }
        },
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        openImport(element) {
            if (element == "agents") {
                // this.importParamsagents["type"] = "effectifs";

                this.showForm("Create", this.importParamsagents, this.gridApi, "lg");
            } else if (element == "pointages") {
                // this.importParamsagents["type"] = "agents-one";
                this.showForm("Create", this.importParamspointages, this.gridApi, "lg");

            } else {

                this.showForm("Create", this.importParamspostes, this.gridApi, "lg");

            }
        },
        download(filename) {
            // console.log( this.file[2])
            this.isLoading = true;
            this.axios
                .get("/api/downloadImports?file=" + filename)
                .then((response) => {
                    this.isLoading = false;
                    // window.open(response.data, "_blank");
                    this.$toast.success("Operation effectuer avec succes");
                })
                .catch((error) => {
                    this.errors = error;
                    this.isLoading = false;
                    this.$toast.error(
                        "Erreur survenue lors de l'enregistrement"
                    );
                });
        },
        annulerImport(data) {
            console.log('on veut annuler', data)
        },
        validerImport(data) {

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
    }
}
</script>
