<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">
                    Update Programmations #{{ formData.id }}
                </div>
                <div v-if="formState == 'Validation'">
                    Confirmation #{{ formData.id }}
                </div>
                <div v-if="formState == 'Duplicate'">
                    Dupliquer Programmations #{{ formData.id }}
                </div>
                <div v-if="formState == 'Create'">Create Programmations</div>
            </template>

            <DuplicateHebdoProgrammations v-if="formState == 'Duplicate'" :key="formKey" :data="formData"
                                          :gridApi="formGridApi" :modalFormId="formId" :tachesData="tachesData"
                                          :usersData="usersData"
                                          @close="closeForm"/>
            <EditProgrammations v-if="formState == 'Update'" :key="formKey" :data="formData" :gridApi="formGridApi"
                                :modalFormId="formId" :tachesData="tachesData" :usersData="usersData"
                                @close="closeForm"/>

            <CreateHebdoProgrammations v-if="formState == 'Create'" :key="formKey" :gridApi="formGridApi"
                                       :modalFormId="formId" :tachesData="tachesData" :usersData="usersData"
                                       @close="closeForm"/>
            <CreateListingsjours v-if="formState == 'CreateListings'" :key="formKey" :actifsData="actifsData"
                                 :balisesData="balisesData" :categoriesData="categoriesData"
                                 :contratsData="contratsData"
                                 :directionsData="directionsData"
                                 :echelonsData="echelonsData" :factionsData="factionsData"
                                 :fonctionsData="fonctionsData"
                                 :gridApi="formGridApi" :matrimonialesData="matrimonialesData"
                                 :modalFormId="formId"
                                 :nationalitesData="nationalitesData" :onlinesData="onlinesData"
                                 :postesData="postesData"
                                 :sexesData="sexesData" :sitesData="sitesData"
                                 :situationsData="situationsData"
                                 :tachesData="tachesData" :typesData="typesData" :usersData="usersData"
                                 :villesData="villesData"
                                 :zonesData="zonesData" @close="closeForm"/>

            <validation v-if="formState == 'Validation'" :key="formKey" :data="formData" :gridApi="formGridApi"
                        :modalFormId="formId" :tachesData="tachesData" :usersData="usersData" :valider="valider"
                        @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <div class="row col-sm-12" style="display: flex;justify-content: space-around">
            <!-- <div v-if="$domaine == 'sgs'" class="col-sm-12 card">
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
                             :rowData="rowData" :rowModelType="rowModelType"
                             :url="url" className="ag-theme-alpine" domLayout="autoHeight"
                             rowSelection="multiple" @gridReady="onGridReady">
                    <template #header_buttons>
                        <div v-if="$routeData.meta.isProgrammations" class="btn btn-primary" @click="openCreate">
                            <i class="fa fa-plus"></i> Nouvelle programmations
                        </div>

                        <div v-if="$routeData.meta.isHebdo" class="btn btn-primary" @click="openListings">
                            <i class="fa fa-plus"></i> Nouveau Listings
                        </div>
                        <div v-if="$routeData.meta.isHebdo" class="btn btn-primary" @click="openListings">
                            <i class="fa fa-plus"></i> Nouvelle programmation
                            Hebdomadaire
                        </div>
                        <input v-if="!$routeData.meta.isProgrammations" v-model="jourselectioner"
                               class="form-control" placeholder="Veuillez selectioner la date"
                               style="width: auto !important"
                               type="date"/>
                    </template>
                </AgGridTable>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateProgrammations from './CreateProgrammations.vue'
import CreateHebdoProgrammations from './CreateHebdoProgrammations.vue'
import DuplicateHebdoProgrammations from './DuplicateHebdoProgrammations.vue'
import EditProgrammations from './EditProgrammations.vue'
import validation from './validation.vue'
import CreateListingsjours from './../Listingsjours/CreateListingsjours.vue'
import DataModal from '@/components/DataModal.vue'
import CustomFiltre from "@/components/CustomFiltre.vue";
import moment from 'moment'
import CountPresents from "./CountPresents.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ProgrammationsView',
    components: {
        DataTable,
        AgGridTable,
        CreateProgrammations,
        EditProgrammations,
        DataModal,
        AgGridBtnClicked,
        CreateListingsjours,
        CreateHebdoProgrammations,
        DuplicateHebdoProgrammations,
        validation,
        CustomFiltre, CountPresents
    },
    data() {

        return {
            formId: "programmations",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/programmations-Aggrid',
            table: 'programmations',
            tachesData: [],
            requette: 2,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            // extrasData: {},
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            zoneselectionner: [],
            zonesget: [],
            actifsData: [],
            balisesData: [],
            categoriesData: [],
            contratsData: [],
            directionsData: [],
            echelonsData: [],
            factionsData: [],
            fonctionsData: [],
            matrimonialesData: [],
            nationalitesData: [],
            onlinesData: [],
            postesData: [],
            sexesData: [],
            sitesData: [],
            situationsData: [],
            typesData: [],
            usersData: [],
            villesData: [],
            zonesData: [],
            validationsData: [
                "non traité",
                "Validater 1",
                "Validater 2",
                // "Archiver",
                // "etat 1",
                // "etat 2",
                // "etat 3",
                // "etat 3",
            ],
            jourselectioner: null,
            page: null,
            valider: 'validation',
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
        extrasData: function () {
            let params = {};

            // if (!this.zoneselectionner) {
            //     // params["id"] = { values: [0], filterType: "set" };
            // } else {
            //     this.tableKey++;
            //     this.tableKey1++;

            //     return {
            //         baseFilter: params,
            //         jourselectioner: this.jourselectioner,
            //     };
            // }


            // if (!this.jourselectioner) {
            //     if (this.page=="listings") {
            //         params = {valider1: "valider1", valider2: "valider1"}
            //     } else if (this.page=="listingsval1") {
            //         params = {valider1: "", valider2: ""}
            //     } else if (this.page=="listingsval2") {
            //             params = {valider1: "valider1", valider2: ""}
            //     } else {
            //     }
            // }
            if (this.page == "listings") {
                params = {valider1: "valider1", valider2: "valider1"}
            } else if (this.page == "listingsval1") {
                params = {valider1: "", valider2: ""}
            } else if (this.page == "listingsval2") {
                params = {valider1: "valider1", valider2: ""}
            } else {


            }
            this.tableKey++;

            return {
                // this.extrasData['baseFilter'] = params
                baseFilter: params,
                jourselectioner: this.jourselectioner,
                zoneselectionner: this.zoneselectionner,

            }


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
        this.url = this.axios.defaults.baseURL + '/api/programmations-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

        // params['type'] = {values: ['programmations'], filterType: 'set'}
        // if (this.$routeData.meta.isListings) {
        //     params['valider1'] = {values: null, filterType: 'set'}

        // }
        // else if (this.$routeData.meta.isListings && !this.$routeData.meta.isListingsPoste ) {
        //     params['type'] = {values: ['listings-declaratif', 'listings-automatique'], filterType: 'set'}
        //
        // }


    },
    beforeMount() {
        if (this.$routeData.meta.isProgrammations) {
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
                                        this.showForm('Update', field, params.api, 'xl')
                                    },
                                    render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                                }
                            };
                        },

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
                                        this.showForm('Duplicate', field, params.api, 'lg')
                                    },
                                    render: `<div class="" style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-copy "></i></div>`
                                }
                            };
                        },

                    },
                    {
                        field: "libelle",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'libelle',

                        hide: this.$routeData.meta.isListingsPoste,
                    },
                    {
                        field: "date_debut",
                        sortable: true,
                        // hide: !this.$routeData.meta.isProgrammations,
                        // filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
                        headerName: 'jour',
                        valueFormatter: params => {
                            let retour = params.value
                            try {
                                retour = params.value.split(' ')[0]
                            } catch (e) {

                            }
                            return retour
                        }
                    },
                    {
                        field: "date_fin",
                        sortable: true,
                        // hide: !this.$routeData.meta.isProgrammations,
                        // filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
                        headerName: 'date_fin',
                        valueFormatter: params => {
                            let retour = params.value
                            try {
                                retour = params.value.split(' ')[0]
                            } catch (e) {

                            }
                            return retour
                        }
                    },
                    {
                        headerName: 'tache',
                        field: 'tache.Selectlabel',
                        // hide: !this.$routeData.meta.isProgrammations,

                    },

                    {
                        hide: true,
                        suppressColumnsToolPanel: true,

                        headerName: 'tache',
                        field: 'tache_id',
                        valueFormatter: params => {
                            let retour = ''
                            try {
                                return params.data['tache']['Selectlabel']
                            } catch (e) {

                            }
                            return retour
                        },
                        filter: "CustomFiltre",
                        filterParams: {
                            url: this.axios.defaults.baseURL + '/api/taches-Aggrid',
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
                        // hide: !this.$routeData.meta.isProgrammations,
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

        }
        if (this.$routeData.meta.isRapports) {
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
                                        this.showForm('Update', field, params.api, 'xl')
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

                        hide: this.$routeData.meta.isListingsPoste,
                    },
                    {
                        field: "created_at",
                        sortable: true,
                        // hide: !this.$routeData.meta.isProgrammations,
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

        }
        if (this.$routeData.meta.isListings) {
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
                                        this.showForm('Update', field, params.api, 'xl')
                                    },
                                    render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                                }
                            };
                        },

                    },
                    {
                        field: "date_debut",
                        minWidth: 120, maxWidth: 120,
                        sortable: true,
                        headerName: 'date ',
                        valueFormatter: params => {
                            let retour = params.value
                            try {
                                retour = params.value.split(' ')[0]
                            } catch (e) {

                            }
                            return retour
                        }
                    },
                    // {
                    //     field: "typelistings",
                    //     sortable: true,
                    //     filter: "agTextColumnFilter",
                    //     filterParams: {suppressAndOrCondition: true},
                    //     headerName: "type de listings",
                    // },
                    // {
                    //     field: 'faction',
                    //     headerName: 'faction',
                    //     minWidth: 100, maxWidth: 100,
                    //     suppressCellSelection: true,

                    // },
                    // {
                    //     hide: true,
                    //     suppressColumnsToolPanel: true,

                    //     headerName: 'zone',
                    //     field: 'zone_id',
                    //     valueFormatter: params => {
                    //         let retour = ''
                    //         try {
                    //             return params.data['zone']['Selectlabel']
                    //         } catch (e) {

                    //         }
                    //         return retour
                    //     },
                    //     filter: "CustomFiltre",
                    //     filterParams: {
                    //         url: this.axios.defaults.baseURL + '/api/zones-Aggrid',
                    //         columnDefs: [
                    //             {
                    //                 field: "",
                    //                 sortable: true,
                    //                 filter: "agTextColumnFilter",
                    //                 filterParams: {suppressAndOrCondition: true},
                    //                 headerName: "",
                    //                 cellStyle: {fontSize: '11px'},
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
                    {
                        field: "Selectlabel",
                        sortable: true,
                        width: 400,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'libelle',
                    },
                    {
                        field: 'present',
                        headerName: 'Prs',
                        suppressCellSelection: true,
                        maxWidth: 85,
                    },
                    {
                        field: 'abscent',
                        headerName: 'Abs',
                        suppressCellSelection: true,
                        maxWidth: 85,
                    },
                    {
                        headerName: 'Valideur 1',
                        field: 'valideur1.Selectlabel',
                    },
                    {
                        hide: true,
                        suppressColumnsToolPanel: true,

                        headerName: 'Valideur 1',
                        field: 'valideur_1',
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
                        field: "valider1",
                        sortable: true,
                        headerName: 'Validation 1',
                        valueFormatter: params => {
                            let retour = params.value
                            try {
                                if (retour) {
                                    retour = moment(params.value).format('DD/MM/YYYY à HH:mm')

                                } else {
                                    retour = 'Non Validé'
                                }
                            } catch (e) {

                            }
                            return retour
                        }
                    },
                    {
                        headerName: 'Valideur 2',
                        field: 'valideur2.Selectlabel',
                    },
                    {
                        hide: true,
                        suppressColumnsToolPanel: true,

                        headerName: 'Valideur 2',
                        field: 'valideur_2',
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
                        field: "valider2",
                        sortable: true,
                        headerName: 'Validation 2',
                        valueFormatter: params => {
                            let retour = params.value
                            try {
                                if (retour) {
                                    retour = moment(params.value).format('DD/MM/YYYY à HH:mm')

                                } else {
                                    retour = 'Non Validé'
                                }
                            } catch (e) {

                            }
                            return retour
                        }
                    },
                    {
                        hide: true,
                        suppressColumnsToolPanel: true,
                        suppressFilter: this.$routeData.meta.validation,
                        headerName: 'validation',
                        field: 'validation',
                        valueFormatter: params => {
                            let retour = ''
                            try {
                                return params.data['validation']['Selectlabel']
                                // return params.data
                            } catch (e) {

                            }
                            return retour
                        },
                        filter: 'agSetColumnFilter',
                        filterParams: {
                            suppressAndOrCondition: true,
                            keyCreator: params => params.value,
                            valueFormatter: params => params.value,
                            values: params => {
                                params.success(this.validationsData);
                            },
                            refreshValuesOnOpen: true,
                        },
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
                    {
                        hide: true,
                        suppressColumnsToolPanel: true,

                        headerName: 'direction',
                        field: 'direction_id',
                        valueFormatter: params => {
                            let retour = ''
                            try {
                                return params.data['direction']['Selectlabel']
                            } catch (e) {

                            }
                            return retour
                        },
                        filter: "FiltreEntete",
                        filterParams: {
                            url: this.axios.defaults.baseURL + '/api/directions-Aggrid',
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
                    // {
                    //     field: "valider1",
                    //     headerName: 'Validation 1',
                    //     suppressCellSelection: true,
                    //     minWidth: 80,maxWidth: 80,
                    //     // pinned: 'left',
                    //     cellRendererSelector: params => {
                    //         return {
                    //             component: 'AgGridBtnClicked',
                    //             params: {
                    //                 clicked: field => {
                    //                     this.valider1()
                    //                     this.showForm('Validation', field, params.api, 'l')
                    //                 },
                    //                 render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-circle-check"></i></div>`
                    //             }
                    //         };
                    //     },
                    // },
                    // {
                    //     field: "valider2",
                    //     sortable: true,
                    //     headerName: 'Validation 2',
                    //     suppressCellSelection: true,
                    //     minWidth: 80,maxWidth: 80,
                    //     cellRendererSelector: params => {
                    //         return {
                    //             component: 'AgGridBtnClicked',
                    //             params: {
                    //                 clicked: field => {
                    //                     this.valider2()
                    //                     this.showForm('Validation', field, params.api, 'l')
                    //                 },
                    //                 render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer"> <i class="fa-solid fa-circle-check"></i></div>`
                    //             }
                    //         };
                    //     },
                    // },
                ];
        }
        // if (this.$routeData.meta.isListingvalidations) {
        //     this.columnDefs =
        //         [
        //             {
        //                 field: null,
        //                 headerName: '',
        //                 suppressCellSelection: true,
        //                 minWidth: 80, maxWidth: 80,
        //                 pinned: 'left',
        //                 cellRendererSelector: params => {
        //                     return {
        //                         component: 'AgGridBtnClicked',
        //                         params: {
        //                             clicked: field => {
        //                                 this.showForm('Update', field, params.api, 'xl')
        //                             },
        //                             render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
        //                         }
        //                     };
        //                 },

        //             },
        //             {
        //                 field: "date_debut",

        //                 sortable: true,
        //                 filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
        //                 headerName: 'date ',
        //                 valueFormatter: params => {
        //                     let retour = params.value
        //                     try {
        //                         retour = params.value.split(' ')[0]
        //                     } catch (e) {

        //                     }
        //                     return retour
        //                 }
        //             },
        //             {
        //                 field: "libelle",
        //                 width: 400,
        //                 sortable: true,
        //                 filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
        //                 headerName: 'libelle',
        //             },
        //             {
        //                 headerName: 'Superviseur',
        //                 field: 'user.Selectlabel',
        //             },
        //             {
        //                 hide: true,
        //                 suppressColumnsToolPanel: true,

        //                 headerName: 'superviseur',
        //                 field: 'user_id',
        //                 valueFormatter: params => {
        //                     let retour = ''
        //                     try {
        //                         return params.data['user']['Selectlabel']
        //                     } catch (e) {

        //                     }
        //                     return retour
        //                 },
        //                 filter: "CustomFiltre",
        //                 filterParams: {
        //                     url: this.axios.defaults.baseURL + '/api/users-Aggrid',
        //                     columnDefs: [
        //                         {
        //                             field: "",
        //                             sortable: true,
        //                             filter: "agTextColumnFilter",
        //                             filterParams: {suppressAndOrCondition: true},
        //                             headerName: "",
        //                             cellStyle: {fontSize: '11px'},
        //                             valueFormatter: (params) => {
        //                                 let retour = "";
        //                                 try {
        //                                     return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
        //                                 } catch (e) {
        //                                 }
        //                                 return retour;
        //                             },
        //                         },
        //                     ],
        //                     filterFields: ['matricule', 'nom', 'prenom'],
        //                 },
        //             },

        //             {
        //                 field: 'Presents',
        //                 headerName: 'Presents',
        //                 suppressCellSelection: true,

        //             },

        //             {
        //                 field: 'Abscents',
        //                 headerName: 'Abscents',
        //                 suppressCellSelection: true,

        //             },
        //             {
        //                 field: "valider1",
        //                 sortable: true,
        //                 headerName: 'Validation 1',
        //                 valueFormatter: params => {
        //                     let retour = params.value
        //                     try {
        //                         if (retour) {
        //                             retour = moment(params.value).format('DD/MM/YYYY à HH:mm')

        //                         } else {
        //                             retour = 'Non Validé'
        //                         }
        //                     } catch (e) {

        //                     }
        //                     return retour
        //                 }
        //             },
        //             {
        //                 field: "valider2",
        //                 sortable: true,
        //                 headerName: 'Validation 2',
        //                 valueFormatter: params => {
        //                     let retour = params.value
        //                     try {
        //                         if (retour) {
        //                             retour = moment(params.value).format('DD/MM/YYYY à HH:mm')

        //                         } else {
        //                             retour = 'Non Validé'
        //                         }
        //                     } catch (e) {

        //                     }
        //                     return retour
        //                 }
        //             },
        //             // {
        //             //     hide: true,
        //             //     suppressColumnsToolPanel: true,
        //             //     headerName: 'validation',
        //             //     field: 'validation',
        //             //     valueFormatter: params => {
        //             //         let retour = ''
        //             //         try {
        //             //             return params.data['validation']['Selectlabel']
        //             //             // return params.data
        //             //         } catch (e) {

        //             //         }
        //             //         return retour
        //             //     },
        //             //     filter: 'agSetColumnFilter',
        //             //     filterParams: {
        //             //         suppressAndOrCondition: true,
        //             //         keyCreator: params => params.value,
        //             //         valueFormatter: params => params.value,
        //             //         values: params => {
        //             //             params.success(this.validationsData);
        //             //         },
        //             //         refreshValuesOnOpen: true,
        //             //     },
        //             // },
        //             // {
        //             //     field: "valider1",
        //             //     headerName: 'Validation 1',
        //             //     suppressCellSelection: true,
        //             //     minWidth: 80,maxWidth: 80,
        //             //     // pinned: 'left',
        //             //     cellRendererSelector: params => {
        //             //         return {
        //             //             component: 'AgGridBtnClicked',
        //             //             params: {
        //             //                 clicked: field => {
        //             //                     this.valider1()
        //             //                     this.showForm('Validation', field, params.api, 'l')
        //             //                 },
        //             //                 render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-circle-check"></i></div>`
        //             //             }
        //             //         };
        //             //     },
        //             // },
        //             // {
        //             //     field: "valider2",
        //             //     sortable: true,
        //             //     headerName: 'Validation 2',
        //             //     suppressCellSelection: true,
        //             //     minWidth: 80,maxWidth: 80,
        //             //     cellRendererSelector: params => {
        //             //         return {
        //             //             component: 'AgGridBtnClicked',
        //             //             params: {
        //             //                 clicked: field => {
        //             //                     this.valider2()
        //             //                     this.showForm('Validation', field, params.api, 'l')
        //             //                 },
        //             //                 render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer"> <i class="fa-solid fa-circle-check"></i></div>`
        //             //             }
        //             //         };
        //             //     },
        //             // },
        //         ];
        // }
        // if (this.$routeData.meta.isListingPostes) {
        //     this.columnDefs =
        //         [
        //             {
        //                 field: null,
        //                 headerName: '',
        //                 suppressCellSelection: true,
        //                 minWidth: 80, maxWidth: 80,
        //                 pinned: 'left',
        //                 cellRendererSelector: params => {
        //                     return {
        //                         component: 'AgGridBtnClicked',
        //                         params: {
        //                             clicked: field => {
        //                                 this.showForm('Update', field, params.api, 'xl')
        //                             },
        //                             render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
        //                         }
        //                     };
        //                 },

        //             },
        //             {
        //                 field: "date_debut",

        //                 sortable: true,
        //                 filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
        //                 headerName: 'date ',
        //                 valueFormatter: params => {
        //                     let retour = params.value
        //                     try {
        //                         retour = params.value.split(' ')[0]
        //                     } catch (e) {

        //                     }
        //                     return retour
        //                 }
        //             },
        //             {
        //                 headerName: 'poste',
        //                 field: 'poste.Selectlabel',


        //             },
        //             {
        //                 headerName: 'site',
        //                 field: 'poste.site.Selectlabel',


        //             },
        //             {
        //                 headerName: 'client',
        //                 field: 'poste.site.client.Selectlabel',


        //             },
        //             {
        //                 field: "faction",

        //                 sortable: true,
        //                 filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
        //                 headerName: 'Faction ',
        //             },

        //             {
        //                 hide: true,
        //                 suppressColumnsToolPanel: true,

        //                 headerName: 'poste',
        //                 field: 'poste_id',
        //                 valueFormatter: params => {
        //                     let retour = ''
        //                     try {
        //                         return params.data['poste']['Selectlabel']
        //                     } catch (e) {

        //                     }
        //                     return retour
        //                 },
        //                 filter: "CustomFiltre",
        //                 filterParams: {
        //                     url: this.axios.defaults.baseURL + '/api/postes-Aggrid',
        //                     columnDefs: [
        //                         {
        //                             field: "",
        //                             sortable: true,
        //                             filter: "agTextColumnFilter",
        //                             filterParams: {suppressAndOrCondition: true},
        //                             headerName: "",
        //                             cellStyle: {fontSize: '11px'},
        //                             valueFormatter: (params) => {
        //                                 let retour = "";
        //                                 try {
        //                                     return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
        //                                 } catch (e) {
        //                                 }
        //                                 return retour;
        //                             },
        //                         },
        //                     ],
        //                     filterFields: ['matricule', 'nom', 'prenom'],
        //                 },
        //             },
        //             // {
        //             //     headerName: 'Superviseur',
        //             //     hide: this.$routeData.meta.isProgrammations,
        //             //     field: 'user.Selectlabel',
        //             // },
        //             // {
        //             //     hide: true,
        //             //     suppressColumnsToolPanel: true,

        //             //     headerName: 'user',
        //             //     field: 'user_id',
        //             //     valueFormatter: params => {
        //             //         let retour = ''
        //             //         try {
        //             //             return params.data['user']['Selectlabel']
        //             //         } catch (e) {

        //             //         }
        //             //         return retour
        //             //     },
        //             //     filter: "CustomFiltre",
        //             //     filterParams: {
        //             //         url: this.axios.defaults.baseURL + '/api/users-Aggrid',
        //             //         columnDefs: [
        //             //             {
        //             //                 field: "",
        //             //                 sortable: true,
        //             //                 filter: "agTextColumnFilter",
        //             //                 filterParams: { suppressAndOrCondition: true },
        //             //                 headerName: "",
        //             //                 cellStyle: { fontSize: '11px' },
        //             //                 valueFormatter: (params) => {
        //             //                     let retour = "";
        //             //                     try {
        //             //                         return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
        //             //                     } catch (e) {
        //             //                     }
        //             //                     return retour;
        //             //                 },
        //             //             },
        //             //         ],
        //             //         filterFields: ['matricule', 'nom', 'prenom'],
        //             //     },
        //             // },

        //             {
        //                 field: 'Presents',
        //                 headerName: 'Presents',
        //                 hide: this.$routeData.meta.isProgrammations,
        //                 suppressCellSelection: true,

        //             },

        //             {
        //                 field: 'Abscents',
        //                 headerName: 'Abscents',
        //                 hide: this.$routeData.meta.isProgrammations,
        //                 suppressCellSelection: true,

        //             },
        //             {
        //                 headerName: 'Superviseur',
        //                 hide: this.$routeData.meta.isProgrammations,
        //                 field: 'user.Selectlabel',
        //             },
        //             {
        //                 hide: true,
        //                 suppressColumnsToolPanel: true,

        //                 headerName: 'user',
        //                 field: 'user_id',
        //                 valueFormatter: params => {
        //                     let retour = ''
        //                     try {
        //                         return params.data['user']['Selectlabel']
        //                     } catch (e) {

        //                     }
        //                     return retour
        //                 },
        //                 filter: "CustomFiltre",
        //                 filterParams: {
        //                     url: this.axios.defaults.baseURL + '/api/users-Aggrid',
        //                     columnDefs: [
        //                         {
        //                             field: "",
        //                             sortable: true,
        //                             filter: "agTextColumnFilter",
        //                             filterParams: {suppressAndOrCondition: true},
        //                             headerName: "",
        //                             cellStyle: {fontSize: '11px'},
        //                             valueFormatter: (params) => {
        //                                 let retour = "";
        //                                 try {
        //                                     return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
        //                                 } catch (e) {
        //                                 }
        //                                 return retour;
        //                             },
        //                         },
        //                     ],
        //                     filterFields: ['matricule', 'nom', 'prenom'],
        //                 },
        //             },

        //             {
        //                 field: 'Presents',
        //                 headerName: 'Presents',
        //                 hide: this.$routeData.meta.isProgrammations,
        //                 suppressCellSelection: true,

        //             },

        //             {
        //                 field: 'Abscents',
        //                 headerName: 'Abscents',
        //                 hide: this.$routeData.meta.isProgrammations,
        //                 suppressCellSelection: true,

        //             },
        //         ];
        // }


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
            // let params = {}
            this.zonesget = this.$routeData.meta.zonesGet

            if (this.$routeData.meta.validation || this.$routeData.meta.isProgrammationsvalid) {
                this.page = "listings"
            } else if (this.$routeData.meta.validation1) {
                this.page = "listingsval1"
            } else if (this.$routeData.meta.validation2) {
                this.page = "listingsval2"
            } else {
                this.page = "listingsval3"

            }
        }
        const days = new Date().toISOString().slice(0, 11)
        // this.jourselectioner = days.split('T')[0];

        // console.log('validationsData=>', this.validationsData)
        // this.gettaches();
        // this.getusers();
        // this.getactifs();
        // this.getbalises();
        // this.getcategories();
        // this.getcontrats();
        // this.getdirections();
        // this.getechelons();
        // this.getfactions();
        // this.getfonctions();
        // this.getmatrimoniales();
        // this.getnationalites();
        // this.getonlines();
        // this.getpostes();
        // this.getsexes();
        // this.getsites();
        // this.getsituations();
        // this.gettypes();
        // this.getvilles();
        // this.getzones();

    },
    methods: {
        valider1() {
            this.valider = 'valider1'
        },
        valider2() {
            this.valider = 'valider2'
        },
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        openListings() {
            this.showForm('CreateListings', {}, this.gridApi, 'xl')
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
        gettaches() {
            this.axios.get('/api/taches').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.tachesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
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
        getactifs() {
            this.axios.get('/api/actifs').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.actifsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getbalises() {
            this.axios.get('/api/balises').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.balisesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getcategories() {
            this.axios.get('/api/categories').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.categoriesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getcontrats() {
            this.axios.get('/api/contrats').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.contratsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getdirections() {
            this.axios.get('/api/directions').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.directionsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getechelons() {
            this.axios.get('/api/echelons').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.echelonsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getfactions() {
            this.axios.get('/api/factions').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.factionsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getfonctions() {
            this.axios.get('/api/fonctions').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.fonctionsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getmatrimoniales() {
            this.axios.get('/api/matrimoniales').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.matrimonialesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getnationalites() {
            this.axios.get('/api/nationalites').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.nationalitesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getonlines() {
            this.axios.get('/api/onlines').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.onlinesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getpostes() {
            this.axios.get('/api/postes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.postesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getsexes() {
            this.axios.get('/api/sexes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.sexesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getsites() {
            this.axios.get('/api/sites').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.sitesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getsituations() {
            this.axios.get('/api/situations').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.situationsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        gettypes() {
            this.axios.get('/api/types').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.typesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },


        getvilles() {
            this.axios.get('/api/villes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.villesData = response.data

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
