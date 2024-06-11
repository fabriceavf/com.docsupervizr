<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Sites #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Sites</div>
            </template>

            <EditSites
                v-if="formState=='Update'"
                :key="formKey"
                :champsAfficher="champsAfficher"
                :clientsData="clientsData"
                :data="formData"
                :gridApi="formGridApi"
                :mapkey="$routeData.meta.key"
                :modalFormId="formId"
                :zonesData="zonesData"
                @close="closeForm"
            />


            <CreateSites
                v-if="formState=='Create'"
                :key="formKey"
                :champsAfficher="champsAfficher"
                :clientsData="clientsData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :zonesData="zonesData"
                @close="closeForm"
            />

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>

        <div class="childBlock">
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
                    <div v-if="type !='Sites'" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i>
                        Ajouter un site
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateSites from './CreateSites.vue'
import EditSites from './EditSites.vue'
import CustomFiltre from "@/components/CustomFiltre.vue";
import DataModal from '@/components/DataModal.vue'
import moment from 'moment'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'SitesView',
    components: {DataTable, AgGridTable, CreateSites, EditSites, DataModal, AgGridBtnClicked, CustomFiltre},
    props: ['type'],
    data() {

        return {
            champsAfficher: [
                //LISTE DES CHAMP à MASQUER
            ],
            formId: "sites",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/sites-Aggrid',
            table: 'sites',
            clientsData: [],
            typesget: [],
            typeselectionner: [],
            zonesData: [],
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
        columnDefs: function () {
            let columnDefs = [
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
                    hide: this.isShow("interne"),
                    // hide: true,
                    pinned: 'left',
                    cellRendererSelector: params => {
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    // if (this.isShow("zone_id")) {
                                    this.showForm('Update', field, params.api, 'xl')
                                    // } else {
                                    // this.showForm('Update', field, params.api)
                                    // }
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
                },


                {
                    headerName: 'client',
                    field: 'client.Selectlabel',
                    hide: this.isShow("client_id"),
                },
                {

                    headerName: 'client',
                    field: 'client_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['client']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: this.havecustomfilter("client_id"),
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
                    headerName: 'zone',
                    field: 'zone.Selectlabel',
                    hide: this.isShow("zone_id"),
                },
                {

                    headerName: 'zone',
                    field: 'zone_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['zone']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: this.havecustomfilter("zone_id"),
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

                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'type',
                    field: 'typessite_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['typessite']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "FiltreEntete",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/typessites-Aggrid',
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
            if (this.type == "Sites") {
                params = {type: "clients"}
                this.champsAfficher = [
                    "interne",

                ]

            } else {
                params = {type: "internes"}
                this.champsAfficher = []
            }
            this.tableKey++;
            return {
                baseFilter: params,
                typeselectionner: this.typeselectionner,
            }


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
        this.url = this.axios.defaults.baseURL + '/api/sites-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;


    },
    beforeMount() {
        // this.columnDefs =
        //     [


        //     ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        // this.getclients();
        // this.getzones();
        this.typesget = this.$routeData.meta.typesGet
        console.log('this.typesget', this.$routeData.meta.typesGet);
    },
    methods: {
        havecustomfilter(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            if (this.champsAfficher.includes(fieldName)) {
                return null
            } else {
                return "CustomFiltre"
            }
        },
        isShow(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            return this.champsAfficher.includes(fieldName); // si le champ existe return prend la valeur *true*
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        closeForm() {
            this.tableKey++
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
        getclients() {
            this.axios.get('/api/clients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.clientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getzones() {
            this.axios.get('/api/zones').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.zonesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
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
