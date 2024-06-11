<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Cruds #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Cruds</div>
            </template>

            <EditCruds v-if="formState == 'Update'" :key="formKey" :data="formData" :gridApi="formGridApi"
                       :modalFormId="formId" :usersData="usersData" @close="closeForm"/>


            <CreateCruds v-if="formState == 'Create'" :key="formKey" :gridApi="formGridApi" :modalFormId="formId"
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
                         :rowData="rowData" :rowModelType="rowModelType" :url="url" className="ag-theme-alpine"
                         domLayout='autoHeight' rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>
                    <div v-if="!$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> Nouveau
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateCruds from './CreateCruds.vue'
import EditCruds from './EditCruds.vue'
import DataModal from '@/components/DataModal.vue'
import CustomFiltre from "@/components/CustomFiltre.vue";
import moment from 'moment'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'CrudsView',
    components: {DataTable, AgGridTable, CreateCruds, EditCruds, DataModal, AgGridBtnClicked, CustomFiltre},
    props: ['type', 'typeValue'],
    data() {

        return {
            formId: "cruds",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/cruds-Aggrid',
            table: 'cruds',
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
            cleImport: null,
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
            let retour = {};
            let params = {};
            if (this.type) {
                params['entite'] = {values: [this.cleImport], filterType: "set"};

            } else {

            }
            retour["baseFilter"] = params;

            return retour;
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
        this.url = this.axios.defaults.baseURL + '/api/cruds-Aggrid',
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
                                    this.showForm('Update', field, params.api)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                            }
                        };
                    },

                },


                {
                    field: "Detail",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'réalisation',
                },


                // {
                //     field: "entite",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'Element modifier',
                // },


                // {
                //     field: "entite_cle",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'Identifiant',
                // },

                //
                // {
                //   field: "ancien",
                //   sortable: true,
                //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
                //   headerName: 'ancien',
                // },
                //
                //
                // {
                //   field: "nouveau",
                //   sortable: true,
                //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
                //   headerName: 'nouveau',
                // },


                {
                    headerName: 'utilisateur',
                    field: 'user.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'user',
                    field: 'user_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['user']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
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
                                        return ` ${params.data["nom"]} ${params.data["prenom"]} `;
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
                    field: "created_at",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Créer le',
                    valueFormatter: params => {
                        let retour = params.value
                        try {
                            retour = moment(params.value).format('DD/MM/YYYY à HH:mm')
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
        this.fetchCrudsData();
        // this.getusers();
        if (this.type === 'agents-one') {
            this.type = 'agents_one'
            this.cleImport = ('IMPORTATIONS-' + this.type + '-' + this.typeValue).toUpperCase();

        } else {
            this.cleImport = ('IMPORTATIONS-' + this.type + '-' + this.typeValue).toUpperCase();

        }
        // console.log('voici les data des impots==>', this.type, this.typeValue)
        // console.log('voici les data des impots==>', this.cleImport )
    },
    methods: {
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        showForm(type, data, gridApi, width = 'xl') {
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
        getusers() {
            this.axios.get('/api/users/type_id/2').then((response) => {
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
        fetchCrudsData() {// Émission des données via un événement personnalisé
            // this.$emit('crudsData', crudsData);
            console.log('aaaaaaaa')
        }
    },
}
</script>
