<template>

    <b-overlay :show="isLoading">
        <div class="row">
            <b-modal :id="formId" :size="formWidth">
                <template #modal-title>
                    <div v-if="formState=='Update'">Detail de l'activite #{{ formData.id }}</div>
                    <div v-if="formState=='Create'">Ratacher une activite a faire</div>
                </template>

                <template v-if="formState=='Create'">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Date</label>
                            <input v-model="date" :class="errors.date ? 'form-control is-invalid' : 'form-control'"
                                   type="date">

                            <div v-if="errors.date" class="invalid-feedback">
                                <template v-for=" error in errors.date"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div class="form-group  col-sm-6">
                            <label>Agent </label>
                            <v-select
                                v-model="agent"
                                :options="usersData"
                                :reduce="ele => ele.id"
                                label="Selectlabel"
                            />
                            <div v-if="errors.user_id" class="invalid-feedback">
                                <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div class="col-sm-12">
                            <AgGridSearch

                                :columnDefs="add.columnDefs"
                                :filterFields="['libelle']"
                                :filterValue="true"
                                :url="add.url"
                                filterKey="isTache"
                                @destruction="finishAddActivite"
                            >
                            </AgGridSearch>
                        </div>
                    </div>


                </template>

                <DetailsActivites
                    v-if="formState=='Update'"
                    :key="formKey"
                    :data="formData"
                    :gridApi="formGridApi"
                    :modalFormId="formId"
                    :usersData="usersData"
                    @close="closeForm"
                />

                <template #modal-footer>
                    <div></div>
                </template>
            </b-modal>


            <!--            <div class="col-sm-12">-->


            <!--                <AgGridTable-->
            <!--                    :key="tableKey"-->
            <!--                    domLayout='autoHeight'-->
            <!--                    rowSelection="multiple"-->
            <!--                    className="ag-theme-alpine"-->
            <!--                    :columnDefs="columnDefs"-->
            <!--                    :url="url"-->
            <!--                    :rowModelType="rowModelType"-->
            <!--                    :paginationPageSize="paginationPageSize"-->
            <!--                    :cacheBlockSize="cacheBlockSize"-->
            <!--                    :maxBlocksInCache="maxBlocksInCache"-->
            <!--                    :pagination="pagination"-->
            <!--                    :rowData="rowData"-->
            <!--                    @gridReady="onGridReady"-->
            <!--                    :rowHeight="45"-->

            <!--                    :extrasData="extrasData"-->

            <!--                >-->
            <!--                    <template #header_buttons>-->
            <!--                        <div class="btn btn-primary" v-if="canAdd()" @click="openCreate"><i-->
            <!--                            class="fa fa-plus"></i> Rajouter des activites-->
            <!--                        </div>-->
            <!--                    </template>-->

            <!--                </AgGridTable>-->

            <!--            </div>-->
            <div class="col-sm-12">
                <AgGridTable
                    :key="tableKey"
                    :cacheBlockSize="cacheBlockSize"
                    :columnDefs="columnDefs"
                    :extras-data="extrasData"
                    :maxBlocksInCache="maxBlocksInCache"
                    :pagination="pagination"
                    :paginationPageSize="paginationPageSize"
                    :rowData="rowData"
                    :rowModelType="rowModelType"
                    :showActu="false"
                    :showExport="false"
                    :url="url"
                    className="ag-theme-alpine"
                    domLayout='autoHeight'
                    rowSelection="multiple"
                    @gridReady="onGridReady"

                >
                    <template #header_buttons>
                        <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                            class="fa fa-plus"></i> Rajouter des activites a des agents
                        </div>
                    </template>

                </AgGridTable>

            </div>

        </div>
    </b-overlay>
</template>


<script>
import CustomSelect from "@/components/CustomSelect.vue";
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateActivites from './CreateActivites.vue'
import DetailsActivites from './DetailsActivites.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import ActivitesActions from "./ActivitesActions.vue"
import Messages from './Messages.vue'
import ActivitesChildView from './ActivitesChildView.vue'
import VSelect from 'vue-select'

import AgGridSearch from "@/components/AgGridSearch.vue";

export default {
    name: 'PlanificationsView',
    components: {
        DataTable,
        AgGridTable,
        CreateActivites,
        DetailsActivites,
        DataModal,
        AgGridBtnClicked,
        Messages,
        ActivitesActions,
        ActivitesChildView,
        VSelect, CustomSelect,
        AgGridSearch

    },
    data() {

        return {
            isLoading: false,
            formId: "activites",
            formState: "",
            formData: {},
            formWidth: 'xl',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/activites-Aggrid',
            table: 'activites',
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
            usersData: [],
            autoGroupColumnDef: {},
            detailCellRenderer: null,
            errors: [],
            date: false,
            agent: false,
            add: {
                url: 'http://127.0.0.1:8000/api/listings-Aggrid',
                columnDefs: null
            },
            newActivite: 0


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
            let params = {}
            if (this.agent) {
                params['user_id'] = {values: [this.agent], filterType: 'set'}
            }
            if (this.date) {
                params['debut'] = {values: [this.date], filterType: 'set'}
            }
            this.tableKey++
            return {'baseFilter': params}
        },
        extrasDataOne: function () {
            let params = {}
            params['isTache'] = {values: [0], filterType: 'set'}
            return {'baseFilter': params, 'test': 2}
        }
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
        this.url = this.axios.defaults.baseURL + '/api/works-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        this.autoGroupColumnDef = {
            field: 'id',
            cellRendererParams: {
                innerRenderer: (params) => {
                    // display employeeName rather than group key (employeeId)
                    return params.data.libelle;
                },
            },
        };


    },
    beforeMount() {
        this.columnDefs = [
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
                                this.showForm('Update', field.activite, params.api, 'lg')
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                        }
                    };
                },

            },

            {
                headerName: 'Activite',
                field: 'activite.Selectlabel',
            },

            {
                headerName: 'Agent',
                field: 'user.Selectlabel',
            },
            // {
            //     field: "libelle",
            //     sortable: true,
            //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
            //     headerName: 'libelle',
            // },


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


            // {
            //     field: "groupe",
            //     sortable: true,
            //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
            //     headerName: 'groupe',
            // },


            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: 'activite',
                field: 'activite_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['activite']['Selectlabel']
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
                        params.success(this.activitesData);
                    },
                    refreshValuesOnOpen: true,
                },
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
        this.add.url = this.axios.defaults.baseURL + '/api/activites-Aggrid';
        this.add.columnDefs = [
            {
                field: null,

                maxWidth: 100,
                pinned: 'left',
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: '',
                cellRendererSelector: params => {
                    let response = {
                        component: 'AgGridBtnClicked',
                        params: {
                            clicked: field => {
                                this.addActivite(field)
                            },

                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                        }
                    }
                    return response;
                },
            },


            {
                field: "libelle",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'libelle',
            },

        ];
    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.getusers()


    },
    methods: {

        canAdd() {
            return this.agent != "" && this.date != "";
        },
        // indicate if row is a group node
        isServerSideGroup(dataItem) {
            return dataItem.has_child;
        },

// specify which group key to use
        getServerSideGroupKey(dataItem) {
            return dataItem.id;
        },

        closeForm() {
            this.tableKey++
        },

        openCreate() {
            this.showForm('Create', {}, this.gridApi, 'lg')
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

        getusers() {
            this.isLoading = true
            this.axios.get('/api/users/type_id/2').then((response) => {

                this.isLoading = false
                this.usersData = response.data

            }).catch(error => {
                this.isLoading = false
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        addActivite(field) {
            this.isLoading = true

            console.log('on veut rajouter une activite a 1 agents', field)
            let data = {
                debut: this.date,
                user_id: this.agent,
                activite_id: field.id,
            }

            this.axios.post('/api/works', data).then((response) => {
                this.isLoading = false
                this.$toast.success('element ajouter avec succes')
                this.newActivite++

            }).catch(error => {
                this.isLoading = false
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        finishAddActivite() {
            if (this.newActivite > 0) {
                this.tableKey++
            }
            this.agent = false
            this.date = false
            this.newActivite = 0
        }
    }
}
</script>
<style>
.ag-theme-alpine {
    --ag-alpine-active-color: #fff;

}
</style>
