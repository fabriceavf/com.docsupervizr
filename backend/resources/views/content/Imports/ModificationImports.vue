<template>

    <div class="row">
        <!-- <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Surveillances #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Surveillances</div>
            </template>

<EditSurveillances v-if="formState == 'Update'" :key="formKey" :data="formData" :gridApi="formGridApi"
    :modalFormId="formId" :usersData="usersData" @close="closeForm" />


<CreateSurveillances v-if="formState == 'Create'" :key="formKey" :gridApi="formGridApi" :modalFormId="formId"
    :usersData="usersData" @close="closeForm" />

<template #modal-footer>
                <div></div>
            </template>
</b-modal> -->

        <div class="col-sm-12">
            <template class=" card">
                <div class=" d-flex justify-content-arround allBoutons card-body">
                    <template v-for="page in allPages">
                        <button v-if="actions == page.replaceAll(' ', '')" :key="`oui-${page.replaceAll(' ', '')}`"
                                class="btn btn-outline-primary" @click.prevent="togglePage(page.replaceAll(' ', ''))">
                            <i class="fa-regular fa-square-check"></i> {{ page }}
                        </button>
                        <button v-else :key="`non-${page.replaceAll(' ', '')}`" class="btn btn-outline-secondary"
                                @click.prevent="togglePage(page.replaceAll(' ', ''))">
                            <i class="fa-regular fa-square"></i> {{ page }}
                        </button>
                    </template>


                </div>
            </template>
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData" :rowModelType="rowModelType"
                         :url="url"
                         className="ag-theme-alpine" domLayout='autoHeight' rowSelection="multiple"
                         @gridReady="onGridReady">

                <template #header_buttons>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import AgGridTable from "@/components/AgGridTable.vue"
import moment from 'moment'
// import CreateSurveillances from './CreateSurveillances.vue'
// import EditSurveillances from '../Surveillances/EditSurveillances.vue'
import DataModal from '@/components/DataModal.vue'
import CustomFiltre from "@/components/CustomFiltre.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'SurveillancesView',

    components: {
        AgGridTable, CustomFiltre,
        //  CreateSurveillances,
        // EditSurveillances,
        DataModal, AgGridBtnClicked
    },
    props: ['type', 'typeValue'],
    data() {

        return {
            formId: "surveillances",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            newDataNouveau: {},
            newDataAncien: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/surveillances-Aggrid',
            table: 'surveillances',
            usersData: [],
            requette: 2,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            cleImport: null,
            maxBlocksInCache: 1,
            actions: '',
            allPages: [
                'creations',
                'modifications',
                'suppressions',
            ],

            champsAfficher: [
                //LISTE DES CHAMP à MASQUER
            ],
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
                params['entite'] = {
                    values: ['imports-agents', 'imports-agents-one', 'imports-postes', 'Imports-effectifs'],
                    filterType: "set"
                };
                params['entite_cle'] = {values: [this.typeValue], filterType: "set"};
                if (this.actions == 'creations') {
                    // this.actions = 'Create'
                    params['action'] = {values: ['Create'], filterType: "set"};

                } else if (this.actions == 'modifications') {
                    // this.actions = 'Update'
                    params['action'] = {values: ['Update'], filterType: "set"};

                } else if (this.actions == 'suppressions') {
                    // this.actions = 'Delete'
                    params['action'] = {values: ['Delete'], filterType: "set"};

                } else {
                    params['action'] = {values: [''], filterType: "set"};
                }

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
        this.url = this.axios.defaults.baseURL + '/api/surveillances-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        if (this.type == 'postes') {
            this.champsAfficher = [
                //LISTE DES CHAMP à MASQUER POUR sgs
                "matricule",
            ];
        } else {
            this.champsAfficher = [
                //LISTE DES CHAMP à MASQUER POUR sgs
                "site",
                "client",
                "zone",
            ];
        }

    },
    beforeMount() {
        this.columnDefs =
            [
                {
                    field: null,
                    headerName: '',
                    hide: true,
                    suppressColumnsToolPanel: true,
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
                    field: "id",
                    sortable: true,
                    filter: 'agTextColumnFilter',
                    filterParams: {suppressAndOrCondition: true,},
                    hide: true,
                    headerName: '#Id',
                },
                {
                    field: "created_at",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    hide: true,
                    suppressColumnsToolPanel: true,
                    headerName: 'Date',
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
                    field: "Detail",
                    sortable: true,
                    headerName: 'réalisation',
                    hide: true,
                    suppressColumnsToolPanel: true,
                },

                {
                    // field: "Detail",
                    valueGetter: this.fullNameGetterNom,
                    sortable: true,
                    headerName: 'Nom',
                },

                {
                    valueGetter: this.fullNameGetterMatricule,
                    sortable: true,
                    headerName: 'matricule',
                    hide: this.isShow("matricule"),
                    suppressColumnsToolPanel: this.isShow("matricule"),
                },

                {
                    valueGetter: this.fullNameGetterSite,
                    sortable: true,
                    headerName: 'site',
                    hide: this.isShow("site"),
                    suppressColumnsToolPanel: this.isShow("site"),
                },

                {
                    valueGetter: this.fullNameGetterClient,
                    sortable: true,
                    headerName: 'client',
                    hide: this.isShow("client"),
                    suppressColumnsToolPanel: this.isShow("client"),
                },

                {
                    valueGetter: this.fullNameGetterZone,
                    sortable: true,
                    headerName: 'zone',
                    hide: this.isShow("zone"),
                    suppressColumnsToolPanel: this.isShow("zone"),
                },
                {
                    field: "action",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Action',
                    hide: true,
                    suppressColumnsToolPanel: true,
                },


                {
                    headerName: 'utilisateur',
                    field: 'user.Selectlabel',
                    hide: true,
                    suppressColumnsToolPanel: true,
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
                    field: "ip",
                    sortable: true,
                    headerName: 'Adresse IP',
                    hide: true,
                    suppressColumnsToolPanel: true,
                },


                {
                    field: "pays",
                    sortable: true,
                    hide: true,
                    suppressColumnsToolPanel: true,
                    headerName: 'Pays',
                },


                {
                    field: "ville",
                    sortable: true,
                    hide: true,
                    suppressColumnsToolPanel: true,
                    headerName: 'Ville',
                },

                {
                    field: "navigateur",
                    sortable: true,
                    hide: true,
                    suppressColumnsToolPanel: true,
                    headerName: 'Navigateur',
                },


            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        // this.getusers();
        console.log('this.type', this.type);
        if (this.type === 'agents-one') {
            this.type = 'agents_one'
            this.cleImport = ('IMPORTATIONS-' + this.type + '-' + this.typeValue).toUpperCase();

        } else {
            this.cleImport = ('IMPORTATIONS-' + this.type + '-' + this.typeValue).toUpperCase();

        }
    },
    methods: {
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        closeForm() {
            this.tableKey++
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

            this.axios.get('/api/users/type_id/1').then((response) => {
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


        togglePage(page) {

            this.actions = page
            this.tableKey++;
        },
        fullNameGetterNom(params) {
            // if (params.data.nouveau) {
            this.newDataNouveau = JSON.parse(params.data.nouveau)
            this.newDataAncien = JSON.parse(params.data.ancien)
            let response = ""
            let champ = Object.keys(this.newDataNouveau)
            let champ2 = Object.keys(this.newDataAncien)
            // if (champ.length ==! 0  && this.newDataNouveau.constructor ==! Object) {
            if (champ.includes('nom') && champ.includes('prenom')) {

                if (!this.newDataNouveau['nom'] && !this.newDataNouveau['prenom']) {
                    response = 'null'
                } else {
                    if (!this.newDataNouveau['nom']) {
                        this.newDataNouveau['nom'] = 'vide'
                    }
                    if (!this.newDataNouveau['prenom']) {
                        this.newDataNouveau['prenom'] = 'vide'
                    }
                    response = this.newDataNouveau['nom'] + " " + this.newDataNouveau['prenom']
                }

            } else if (champ.includes('libelle')) {

                if (!this.newDataNouveau['libelle']) {
                    response = null
                } else {
                    response = this.newDataNouveau['libelle']
                }

            } else if (champ.includes('name')) {

                if (!this.newDataNouveau['name']) {
                    response = null
                } else {
                    response = this.newDataNouveau['name']
                }

            } else if (champ2.includes('nom') && champ2.includes('prenom')) {

                if (!this.newDataAncien['nom'] && !this.newDataAncien['prenom']) {
                    response = 'null'
                } else {
                    if (!this.newDataAncien['nom']) {
                        this.newDataAncien['nom'] = 'vide'
                    }
                    if (!this.newDataAncien['prenom']) {
                        this.newDataAncien['prenom'] = 'vide'
                    }
                    response = this.newDataAncien['nom'] + " " + this.newDataAncien['prenom']
                }
            } else if (champ2.includes('libelle')) {

                if (!this.newDataAncien['libelle']) {
                    response = null
                } else {
                    response = this.newDataAncien['libelle']
                }

            } else if (champ2.includes('name')) {

                if (!this.newDataAncien['name']) {
                    response = null
                } else {
                    response = this.newDataAncien['name']
                }

            } else {

            }

            return response.toUpperCase()
        },
        fullNameGetterMatricule(params) {

            this.newDataNouveau = JSON.parse(params.data.nouveau)
            this.newDataAncien = JSON.parse(params.data.ancien)
            let response = ""
            let champ = Object.keys(this.newDataNouveau)
            let champ2 = Object.keys(this.newDataAncien)

            if (champ.includes('matricule')) {

                if (!this.newDataNouveau['matricule']) {
                    response = null
                } else {
                    if (!this.newDataNouveau['matricule']) {
                        this.newDataNouveau['matricule'] = 'vide'
                    }
                    response = this.newDataNouveau['matricule']
                }

            } else if (champ2.includes('matricule')) {

                if (!this.newDataAncien['matricule']) {
                    response = null
                } else {
                    if (!this.newDataAncien['matricule']) {
                        this.newDataAncien['matricule'] = 'vide'
                    }
                    response = this.newDataAncien['matricule']
                }

            } else {

            }
            return response.toUpperCase()
            // return params.data.action;
            //     return params.data.nom;

        },
        fullNameGetterSite(params) {

            this.newDataNouveau = JSON.parse(params.data.nouveau)
            this.newDataAncien = JSON.parse(params.data.ancien)
            let response = ""
            let champ = Object.keys(this.newDataNouveau)
            let champ2 = Object.keys(this.newDataAncien)

            if (champ.includes('site')) {

                if (!this.newDataNouveau['site']) {
                    response = null
                } else {
                    if (!this.newDataNouveau['site']) {
                        this.newDataNouveau['site'] = 'vide'
                    }
                    response = this.newDataNouveau['site']
                }

            } else if (champ2.includes('site')) {

                if (!this.newDataAncien['site']) {
                    response = null
                } else {
                    if (!this.newDataAncien['site']) {
                        this.newDataAncien['site'] = 'vide'
                    }
                    response = this.newDataAncien['site']
                }

            } else {

            }
            return response.toUpperCase()
            // return params.data.action;
            //     return params.data.nom;

        },
        fullNameGetterClient(params) {

            this.newDataNouveau = JSON.parse(params.data.nouveau)
            this.newDataAncien = JSON.parse(params.data.ancien)
            let response = ""
            let champ = Object.keys(this.newDataNouveau)
            let champ2 = Object.keys(this.newDataAncien)

            if (champ.includes('client')) {

                if (!this.newDataNouveau['client']) {
                    response = null
                } else {
                    if (!this.newDataNouveau['client']) {
                        this.newDataNouveau['client'] = 'vide'
                    }
                    response = this.newDataNouveau['client']
                }

            } else if (champ2.includes('client')) {

                if (!this.newDataAncien['client']) {
                    response = null
                } else {
                    if (!this.newDataAncien['client']) {
                        this.newDataAncien['client'] = 'vide'
                    }
                    response = this.newDataAncien['client']
                }

            } else {

            }
            return response.toUpperCase()
            // return params.data.action;
            //     return params.data.nom;

        },
        fullNameGetterZone(params) {

            this.newDataNouveau = JSON.parse(params.data.nouveau)
            this.newDataAncien = JSON.parse(params.data.ancien)
            let response = ""
            let champ = Object.keys(this.newDataNouveau)
            let champ2 = Object.keys(this.newDataAncien)

            if (champ.includes('zone')) {

                if (!this.newDataNouveau['zone']) {
                    response = null
                } else {
                    if (!this.newDataNouveau['zone']) {
                        this.newDataNouveau['zone'] = 'vide'
                    }
                    response = this.newDataNouveau['zone']
                }

            } else if (champ2.includes('zone')) {

                if (!this.newDataAncien['zone']) {
                    response = null
                } else {
                    if (!this.newDataAncien['zone']) {
                        this.newDataAncien['zone'] = 'vide'
                    }
                    response = this.newDataAncien['zone']
                }

            } else {

            }
            return response.toUpperCase()
            // return params.data.action;
            //     return params.data.nom;

        },
        isShow(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            return this.champsAfficher.includes(fieldName); // si le champ existe return prend la valeur *true*
        },
    }
}
</script>
<style scoped>
.blockBadge {
    padding: 10px;
    border: dashed;
    border-radius: 5px;
}

.blockPointages {
    text-align: center;
    margin: 10px;
    border: 2px dashed #b1acac;
    border-radius: 5px;
    padding: 10px;
}

.allBoutons {
    display: flex;
    gap: 10px
}
</style>
