<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Horaires #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Horaires</div>
            </template>

            <EditHoraires v-if="formState == 'Update'" :key="formKey" :data="formData" :gridApi="formGridApi"
                          :modalFormId="formId" :tachesData="tachesData" @close="closeForm"/>


            <CreateHoraires v-if="formState == 'Create'" :key="formKey" :gridApi="formGridApi" :modalFormId="formId"
                            :parentId="parentId" :parentKey="parentKey" :tachesData="tachesData" @close="closeForm"/>

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
                         domLayout='autoHeight' rowSelection="multiple" @gridReady="onGridReady" @newData="newData">
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
import CreateHoraires from './CreateHoraires.vue'
import EditHoraires from './EditHoraires.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'HorairesView',
    components: {DataTable, AgGridTable, CreateHoraires, EditHoraires, DataModal, AgGridBtnClicked},
    props: ['parentId', 'parentKey'],
    data() {

        return {
            formId: "horaires",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/horaires-Aggrid',
            table: 'horaires',
            tachesData: [],
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
            horaireSelectioner: 0
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
            // params['baseFilter']['parent'] = {values: [this.parentKey], filterType: 'set'}
            // params['baseFilter']['parentId'] = {values: [this.parentId], filterType: 'set'}
            params['baseFilter']['poste_id'] = {values: [this.parentId], filterType: 'set'}
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
        this.url = this.axios.defaults.baseURL + '/api/horaires-Aggrid',
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
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                    maxWidth: 100,
                    cellStyle: params => {
                        if (params.data.id === this.horaireSelectioner) {
                            //mark police cells as red
                            return {color: '#fff', backgroundColor: 'green'};
                        }
                        return null;
                    },
                    cellRendererSelector: params => {
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.selectHoraire(field)
                                },
                                render: `<div class="" style="width:100%;height:100%;cursor:pointer">${params.data.libelle}</div>`
                            }
                        };
                    },
                },
                {
                    field: "debut",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'debut',
                    maxWidth: 120,
                },
                {
                    field: "fin",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'fin',
                    maxWidth: 120,
                },
                {
                    field: "nmb_pointage_min",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Min P',
                    maxWidth: 120,
                },
                {
                    field: "vol_horaire_min",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Vol H',
                    maxWidth: 120,
                },


            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.sendFormData();
        // this.gettaches();

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
        newData(data) {
            this.$emit('newData1', data.rowData)
        },
        gettaches() {
            this.axios.get('/api/taches').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.tachesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        selectHoraire(horaire) {
            this.horaireSelectioner = horaire.id

            this.gridApi.redrawRows();

        },
        sendFormData() {
            this.$emit('getFormData', this.formData);
        }
    }
}
</script>
