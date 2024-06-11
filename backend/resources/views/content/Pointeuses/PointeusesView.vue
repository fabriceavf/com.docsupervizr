<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Pointeuses #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Pointeuses</div>
            </template>

            <EditPointeuses v-if="formState == 'Update' " :key="formKey" :data="formData"
                            :gridApi="formGridApi"
                            :modalFormId="formId" :sitesData="sitesData" :supervirzclientsData="supervirzclientsData"
                            @close="closeForm"/>

            <!-- <EditPointeusesTache v-if="formState == 'Update' && $domaine != 'sgs'" :key="formKey" :data="formData"
                                 :gridApi="formGridApi"
                                 :modalFormId="formId" :sitesData="sitesData"
                                 :supervirzclientsData="supervirzclientsData"
                                 @close="closeForm"/> -->


            <CreatePointeuses v-if="formState == 'Create'" :key="formKey" :gridApi="formGridApi" :modalFormId="formId"
                              :sitesData="sitesData" :supervirzclientsData="supervirzclientsData" @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>

        <!-- <div  class="col-sm-12 card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-1" style="text-align: center;
display: flex;
justify-content: center;
align-content: center;
align-items: center;">

                        <h5 class="card-title">Zones</h5>
                    </div>
                    <div class="col-sm-10">

                        <button v-for="items  in zonesget" v-b-tooltip.hover
                                :style="zoneselectionner.includes(items.id) ? 'border: 3px solid  green' : ''"
                                class="btn card-body"
                                style=""
                                @click.prevent="zoneselect(items.id)">
                            <div class="iconParent">
                            <span> <i class="fa-solid fa-filter"></i>

                                {{ items.libelle }}
                            </span>

                            </div>
                        </button>
                    </div>
                </div>
            </div>

        </div> -->
        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData"
                         :rowModelType="rowModelType" :url="url" className="ag-theme-alpine"
                         domLayout='autoHeight' rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>
                    <div v-if="!$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> ajouter une pointeuse
                    </div>
                    <input v-model="week" class="form-control" placeholder="Veuillez selectioner le mois"
                           style="width: auto !important" type="week"/>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreatePointeuses from './CreatePointeuses.vue'
import EditPointeuses from './EditPointeuses.vue'
import EditPointeusesTache from './EditPointeusesTache.vue'
import CustomSelect from "@/components/CustomSelect.vue"
import CustomFiltre from "@/components/CustomFiltre.vue"
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'PointeusesView',
    components: {
        DataTable,
        AgGridTable,
        CreatePointeuses,
        EditPointeuses,
        EditPointeusesTache,
        DataModal,
        AgGridBtnClicked,
        CustomSelect,
        CustomFiltre
    },
    data() {

        return {
            formId: "pointeuses",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/pointeuses-Aggrid',
            table: 'pointeuses',
            sitesData: [],
            zonesget: [],
            zoneselectionner: [],
            supervirzclientsData: [],
            requette: 2,
            // columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            week: null,
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
        columnDefs: function () {
            let columnDefs = [
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
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-raduis:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },

                {
                    headerName: 'zone',
                    field: 'site.zone.Selectlabel',
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
                    headerName: 'client',
                    field: 'site.client.Selectlabel',
                },
                {
                    field: "code",
                    sortable: true,
                    maxWidth: 120,
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

                    maxWidth: 100,
                    field: "lun",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'lun',
                },


                {
                    maxWidth: 100,
                    field: "mar",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'mar',
                },


                {
                    maxWidth: 100,
                    field: "mer",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'mer',
                },


                {
                    maxWidth: 100,
                    field: "jeu",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'jeu',
                },


                {
                    maxWidth: 100,
                    field: "ven",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'ven',
                },


                {
                    maxWidth: 100,
                    field: "sam",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'sam',
                },


                {
                    maxWidth: 100,
                    field: "dim",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'dim',
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

            ]
            return columnDefs;
        },
        extrasData: function () {

            let params = {};
            if (!this.week) {
                // params["id"] = { values: [0], filterType: "set" };
            }
            this.tableKey++;

            return {
                baseFilter: params,
                week: this.week,
                zoneselectionner: this.zoneselectionner,
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
        this.url = this.axios.defaults.baseURL + '/api/pointeuses-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

    },
    beforeMount() {


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.zonesget = this.$routeData.meta.zonesGet

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

        getsupervirzclients() {
            this.axios.get('/api/supervirzclients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.supervirzclientsData = response.data

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
            this.extrasData1.zoneselectionner = this.zoneselectionner

            // console.log('this.zoneselectionner', this.zoneselectionner)
        },
    }
}
</script>
