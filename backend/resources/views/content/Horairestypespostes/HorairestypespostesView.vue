<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Horairestypespostes #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Horairestypespostes</div>
            </template>

            <EditHorairestypespostes
                v-if="formState=='Update'"
                :key="formKey"
                :data="formData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :parentId="parentId"
                :typespostesData="typespostesData"
                @close="closeForm"
            />


            <CreateHorairestypespostes
                v-if="formState=='Create'"
                :key="formKey"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :parentId="parentId"
                :typespostesData="typespostesData"
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
import CreateHorairestypespostes from './CreateHorairestypespostes.vue'
import EditHorairestypespostes from './EditHorairestypespostes.vue'
import CustomSelect from "@/components/CustomSelect.vue"
import CustomFiltre from "@/components/CustomFiltre.vue"
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'HorairestypespostesView',
    components: {
        DataTable,
        AgGridTable,
        CreateHorairestypespostes,
        EditHorairestypespostes,
        DataModal,
        AgGridBtnClicked,
        CustomSelect,
        CustomFiltre
    },
    props: ['parentId'
    ],
    data() {

        return {
            formId: "horairestypespostes",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/horairestypespostes-Aggrid',
            table: 'horairestypespostes',
            typespostesData: [],
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
            let params = {baseFilter: {}}
            params['baseFilter']['typesposte_id'] = {values: [this.parentId], filterType: 'set'}
            return params


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
        this.url = this.axios.defaults.baseURL + '/api/horairestypespostes-Aggrid',
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
                    width: 80,
                    pinned: 'left',
                    cellRendererSelector: params => {
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-raduis:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },


                {
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },


                {
                    field: "debut",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'debut',
                },


                {
                    field: "fin",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'fin',
                },


                //                         {
                //     field: "creat_by",
                //     sortable: true,
                //     filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'creat_by',
                // },


                {
                    field: "ordre",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'ordre',
                },


                // {
                //     headerName: 'typesposte',
                //     field: 'typesposte.Selectlabel',
                // },
                // {

                //     hide: true,
                //     suppressColumnsToolPanel: true,

                //     headerName: 'typesposte',
                //     field: 'typesposte_id',
                //     valueFormatter: params => {
                //         let retour=''
                //         try{
                //             return params.data['typesposte']['Selectlabel']
                //         }catch (e) {

                //         }
                //         return  retour
                //     },

                //     filter: "CustomFiltre",
                //     filterParams: {
                //         url: this.axios.defaults.baseURL + '/api/typespostes-Aggrid',
                //         columnDefs: [
                //             {
                //                 field: "",
                //                 sortable: true,
                //                 filter: "agTextColumnFilter",
                //                 filterParams: { suppressAndOrCondition: true },
                //                 headerName: "",
                //                 cellStyle: { fontSize: '11px' },
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

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        this.gettypespostes();

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
        },
        gettypespostes() {
            this.axios.get('/api/typespostes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.typespostesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

    }
}
</script>
