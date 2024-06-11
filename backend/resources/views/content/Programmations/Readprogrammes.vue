<template>
    <div class="row" style="width:100%;margin:10px auto;display:flex;flex-direction:column;gap:10px">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Programmationsusers #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Programmationsusers</div>
                <div v-if="formState == 'AddUsers'">Programmer un agent</div>
            </template>
            <div v-if="formState == 'AddUsers'">
                <form @submit.prevent="addAgent()">
                    <div class="form-group">
                        <label>users </label>
                        <CustomSelect :key="add.user_id" :columnDefs="['nom', 'prenom', 'matricule']"
                                      :oldValue="{}" :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => add.user_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/users-Aggrid`"
                                      filter-key=""
                                      filter-value=""/>
                        <div v-if="errors.user_id" class="invalid-feedback">
                            <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div v-for="date in periodes" class="form-group">
                        <label>{{ showDate(date) }} </label>
                        <v-select v-model="add['date'][date]" :options="horairesData" :reduce="ele => ele.id"
                                  :value="horairesData[0].id" label="Selectlabel"/>
                        <div v-if="errors.user_id" class="invalid-feedback">
                            <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-floppy-disk"></i> Créer
                    </button>
                </form>

            </div>
            <AgGridSearch v-if="formState == 'AddUsersListings'" :columnDefs="addListing.columnDefs"
                          :extrasData="addListing.extrasData" :filterFields="['nom', 'prenom', 'matricule']"
                          :url="addListing.url"
                          filter-key="type_id" filter-value="2" @destruction="finishAddUser">
            </AgGridSearch>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>

        <div>

        </div>
        <div class="Programmes">

            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :inCard="false" :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData" :rowModelType="rowModelType" :show-export="false"
                         :sideBar="null"
                         :url="url"
                         className="ag-theme-alpine" domLayout='autoHeight' rowSelection="multiple"
                         @gridReady="onGridReady"
                         @newData="newData">
                <template #header_buttons>

                </template>

            </AgGridTable>
        </div>

    </div>
</template>


<script>
import CustomSelect from "@/components/CustomSelect.vue";
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import DataModal from '@/components/DataModal.vue'
import Preuves from "./Preuves.vue";
import moment from 'moment'
import VSelect from 'vue-select'
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import ListingsTraitements from "./ListingsTraitements.vue";
import PostesTraitements from "./PostesTraitements.vue";
import DeclarerPresents from "./Traitements/DeclarerPresents.vue"
import GetPoste from "./Traitements/GetPoste.vue"
import GetSite from "./Traitements/GetSite.vue"
import GetClient from "./Traitements/GetClient.vue"
import GetHoraire from "./Traitements/GetHoraire.vue"
import GetPointages from "./Traitements/GetPointages.vue"
import GetRemplacant from "./Traitements/GetRemplacant.vue"

import AgGridSearch from "@/components/AgGridSearch.vue";

export default {
    name: 'Readprogrammes',
    props: ['data', 'usersData', 'horairesData', 'filter', 'poste', 'periode'],
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked,
        VSelect, CustomSelect,
        Preuves,
        ListingsTraitements,
        PostesTraitements,
        AgGridSearch,
        DeclarerPresents,
        GetPoste,
        GetSite,
        GetClient,
        GetHoraire,
        GetRemplacant,
        GetPointages
    },
    data() {
        return {
            form: {
                client_id: "",
                poste_id: ""
            },
            add: {
                user_id: 0,
                date: {}
            },
            champsAfficher: [
                //LISTE DES CHAMP à MASQUER
            ],
            errors: {},
            formId: "programmes",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/programmationsusers-Aggrid',
            table: 'programmationsusers',
            requette: 1,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 25,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            allData: [],
            statutsData: [],
            addListing: {
                formId: "listings",
                formState: "",
                formData: {},
                formWidth: 'lg',
                formGridApi: {},
                formKey: 0,
                tableKey: 0,
                url: 'http://127.0.0.1:8000/api/listings-Aggrid',
                table: 'Users',
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
            }
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
        periodes: function () {
            let date = [this.periode]
            return date;

        },
        columnDefs: function () {
            let data = [
                {
                    field: null,

                    maxminWidth: 80,
                    maxWidth: 80,
                    pinned: 'left',
                    suppressColumnsToolPanel: true,
                    sortable: false,
                    headerName: '',
                    cellRendererSelector: params => {
                        let response = {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.deleteUser(field)
                                },
                                render: `<button class="btn btn-warning" > <i class="fa-solid fa-trash "></i></button>`
                            }
                        }

                        return response;
                    },
                },
                {

                    headerName: 'statut',
                    field: 'statut_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['statut']['Selectlabel']
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
                            params.success(this.statutsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },
                {
                    headerName: 'Client',
                    hide: this.isShow('Client'),
                    field: null,
                    // minWidth: 250,
                    cellRendererSelector: params => {
                        return {
                            component: 'GetClient',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                etats: 'manuel',
                                usersData: this.usersData
                            },
                        }
                    }
                },
                {
                    headerName: 'Site',
                    hide: this.isShow('Site'),
                    field: null,
                    // minWidth: 250,
                    cellRendererSelector: params => {
                        return {
                            component: 'GetSite',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                etats: 'manuel',
                                usersData: this.usersData
                            },
                        }
                    }
                },
                {
                    headerName: 'Poste',
                    hide: this.isShow('Poste'),
                    field: null,
                    // minWidth: 250,
                    cellRendererSelector: params => {
                        return {
                            component: 'GetPoste',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                etats: 'manuel',
                                usersData: this.usersData
                            },
                        }
                    }
                },
                // {
                //     headerName: 'Tache',
                //     hide: this.isShow('Tache'),
                //     field: null,
                //     minWidth: 250,
                //     cellRendererSelector: params => {
                //         return {
                //             component: 'GetPoste',
                //             params: {
                //                 clicked: field => {
                //                     this.showForm('Update', field, params.api)
                //                 },
                //                 etats: 'manuel',
                //                 usersData: this.usersData
                //             },
                //         }
                //     }
                // },
                {
                    headerName: 'Faction',
                    field: null,
                    hide: true,
                    minWidth: 150,
                    cellRendererSelector: params => {
                        return {
                            component: 'GetHoraire',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                etats: 'manuel',
                                usersData: this.usersData
                            },
                        }
                    }
                },
                {
                    suppressColumnsToolPanel: true,

                    headerName: 'Matricule',
                    maxWidth: 150,
                    field: 'user',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['user']['matricule']
                        } catch (e) {

                        }
                        return retour
                    },
                },
                {
                    suppressColumnsToolPanel: true,

                    headerName: 'Nom',
                    field: 'user',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['user']['nom']
                        } catch (e) {

                        }
                        return retour
                    },
                },
                {
                    suppressColumnsToolPanel: true,

                    headerName: 'Prenom',
                    field: 'user',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['user']['prenom']
                        } catch (e) {

                        }
                        return retour
                    }
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'agents',
                    field: 'user',
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
                    headerName: 'Remplacant',
                    hide: this.isShow('Remplacant'),
                    field: null,
                    cellRendererSelector: params => {
                        return {
                            component: 'GetRemplacant',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                etats: 'manuel',
                                usersData: this.usersData,
                                listingId: this.data.id
                            },
                        }
                    }
                },
                {
                    headerName: 'Pointages',
                    field: null,
                    minWidth: 80,
                    maxWidth: 100,
                    cellRendererSelector: params => {
                        return {
                            component: 'GetPointages',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                etats: 'manuel',
                                usersData: this.usersData
                            },
                        }
                    }
                },
                {
                    headerName: `Presents ?`,
                    field: null,
                    minWidth: 80,
                    maxWidth: 100,
                    cellRendererSelector: params => {
                        return {
                            component: 'DeclarerPresents',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                etats: 'manuel',
                                usersData: this.usersData
                            },
                        }
                    }
                }
            ];
            return data;

        },
        extrasData: function () {
            let params = {}
            params['programmation_id'] = {values: [this.data.id], filterType: 'set'}

            this.tableKey++
            return {'baseFilter': params}

        },
        testData: function () {
            let data = {}
            try {
                data = this.allData[0]
            } catch (e) {
            }
            return data
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
        'form.client_id': {
            handler: function (after, before) {
                this.form.poste_id = ''
            },
            deep: true
        },
        'postesData': {
            handler: function (after, before) {
                this.form.poste_id = after[0].id
            },
            deep: true
        },
        'clientsData': {
            handler: function (after, before) {
                this.form.client_id = after[0].id
            },
            deep: true
        },

    },
    created() {
        // if (this.$domaine != 'sgs') {
        //     this.champsAfficher = [
        //         'Poste',
        //         'Remplacant'
        //     ];
        // } else {
        //     this.champsAfficher = [
        //         'Tache'
        //     ];
        // }
        this.url = this.axios.defaults.baseURL + '/api/programmes-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        this.statutsData = [
            'present',
            'absent',
        ];
    },
    beforeMount() {


    },
    mounted() {
        this.addListing.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
            this.addListing.rowBuffer = 0;
        this.addListing.rowModelType = 'serverSide';
        this.addListing.columnDefs = [

            {
                field: null,

                width: 100,
                pinned: 'left',
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: '',
                cellRendererSelector: params => {
                    let response = {
                        component: 'AgGridBtnClicked',
                        params: {
                            clicked: field => {
                                this.addUser(field)
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                        }
                    }
                    return response;
                },
            },
            {
                field: "matricule",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'matricule',
            },
            {
                field: "nom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'nom',
            },
            {
                field: "prenom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'prenom',
            },
            {
                field: "num_badge",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'num_badge',
            },


        ];
        this.addListing.cacheBlockSize = 50;
        this.addListing.maxBlocksInCache = 2;
    },
    methods: {
        isShow(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            return this.champsAfficher.includes(fieldName); // si le champ existe return prend la valeur *true*
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
        showDate(date) {
            return moment(date, 'YYYY-MM-DD').locale('fr-fr').format("dddd") + ' ' + date
        },
        addAgent() {
            let data = []

            Object.keys(this.add.date).forEach(cle => {
                data.push({
                    programmation_id: this.data.id,
                    user_id: this.add.user_id,
                    date: cle,
                    horaire_id: this.add.date[cle],
                })

            })

            this.axios.post('/api/programmationsActionAddAgent', data).then((response) => {
                // this.axios.post('/api/programmations/action?action=addAgent', data).then((response) => {
                this.tableKey++
                this.$bvModal.hide(this.formId)
                this.$toast.success('Operation effectuer avec succes')

                // this.$toast.success('Erreur survenue lors de la récuperation')

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
            console.log('voici la data de base', this.add, data)

        },
        deleteUser(element) {
            if (element.programmation.valider2.length < 1) {
                this.isLoading = true
                let data = {}
                data.id = element.id
                console.log('suppression dagent du listing ===>', data)
                this.axios.post('/api/programmes/' + element.id + '/delete', data)
                    .then(response => {

                        this.isLoading = false
                        this.tableKey++
                        // this.gridApi.applyServerSideTransaction({
                        //   remove: [
                        //     element.id
                        //   ],
                        // });
                        this.$toast.success('Operation effectuer avec succes')
                    }).catch(error => {
                    console.log('error lors de la suppression des users ==>', error)
                    this.errors = error.response.data.errors
                    this.isLoading = false
                    this.$toast.error('Erreur survenue lors de l\'enregistrement')
                })
            } else {

                this.$toast.error('Impossible de modifier un listing deja valider par le chef de zone')
            }

        },
        newData(data) {
            this.allData = data.rowData
        },
        addUser(element) {


            let data = [
                {
                    programmation_id: this.data.id,
                    user_id: element.id,
                    date: this.periodes[0],
                    horaire_id: this.poste.horaireId,
                }
            ]

            console.log('voici le programmes', data, element, this.testData)
            this.axios.post('/api/programmationsActionAddAgent', data).then((response) => {
                // this.axios.post('/api/programmations/action?action=addAgent', data).then((response) => {
                this.isLoading = false
                this.$toast.success('Operation effectuer avec succes')
                this.userAdded++


            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })

        },
        finishAddUser() {
            // evenement appeler lorsquon ferme le formulaire dajout des agents
            // on verifie si on ajouter des agents et on met a jour le tableau sinon on ne fait rien
            if (this.userAdded > 0) {
                this.tableKey++
            }
            this.userAdded = 0
        },

    }
}
</script>
<style>

.Programmes .ag-theme-alpine .ag-layout-auto-height .ag-center-cols-container {
    min-height: 0px !important;
}

.Programmes .ag-theme-alpine .ag-layout-auto-height .ag-center-cols-clipper {
    min-height: 0px !important;
}
</style>
