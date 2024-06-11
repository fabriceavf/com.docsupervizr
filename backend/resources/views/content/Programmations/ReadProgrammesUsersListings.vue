<template>
    <div class="listesDesAgentsProgrammer">
        <div class="row">
            <b-modal :id="formId" :size="formWidth">
                <template #modal-title>
                    <div v-if="formState=='Update'">Update Programmationsusers #{{ formData.id }}</div>
                    <div v-if="formState=='Create'">Create Programmationsusers</div>
                    <div v-if="formState=='AddUsers'">Programmer un agent</div>
                </template>
                <div
                    v-if="formState=='AddUsers'"
                >
                    <form @submit.prevent="addAgent()">
                        <div class="form-group">
                            <label>users </label>
                            <v-select
                                v-model="add.user_id"
                                :options="usersData"
                                :reduce="ele => ele.id"
                                label="Selectlabel"
                                required
                            />
                            <div v-if="errors.user_id" class="invalid-feedback">
                                <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div v-for="date in periodes" class="form-group">
                            <label>{{ showDate(date) }} </label>
                            <v-select
                                v-model="add['date'][date]"
                                :options="horairesData"
                                :reduce="ele => ele.id"
                                :value="horairesData[0].id"
                                label="Selectlabel"
                            />
                            <div v-if="errors.user_id" class="invalid-feedback">
                                <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-floppy-disk"></i> Créer
                        </button>
                    </form>

                </div>
                <AgGridSearch

                    v-if="formState=='AddUsersListings'"
                    :columnDefs="addListing.columnDefs"
                    :extrasData="addListing.extrasData"
                    :filterFields="['nom','prenom','matricule']"
                    :url="addListing.url"
                    filter-key="type_id"
                    filter-value="2"
                    @destruction="finishAddUser"
                >
                </AgGridSearch>
                <AgGridSearch

                    v-if="formState=='CreateAgent'"
                    :columnDefs="addTitulaire.columnDefs"
                    :extrasData="addTitulaire.extrasData"
                    :filterFields="['nom','prenom','matricule']"
                    :url="addTitulaire.url"
                    filter-key="type_id"
                    filter-value="2"
                    @destruction="finishAddUser"
                >
                </AgGridSearch>

                <template #modal-footer>
                    <div></div>
                </template>
            </b-modal>
            <div v-for="programmationUser in allProgrammesUsersForClient" class="col-sm-12">
                <div style="display:flex;justify-content:space-between;padding:10px">
                    <button class="btn">Liste des agents du poste <span
                        style="font-weight: bold">{{ programmationUser.posteLibelle }}</span></button>
                    <button class="btn btn-primary" @click="openCreateAgent(programmationUser.posteId)"><i
                        class="fa fa-plus"></i> Ajouter un agent
                    </button>
                </div>
                <AgGridTable
                    :key="tableKey"
                    :cacheBlockSize="cacheBlockSize"
                    :columnDefs="columnDefs"
                    :extrasData="getExtrasData(programmationUser)"
                    :inCard="false"
                    :maxBlocksInCache="maxBlocksInCache"
                    :pagination="pagination"
                    :paginationPageSize="paginationPageSize"
                    :rowData="rowData"
                    :rowHeight="50"
                    :rowModelType="rowModelType"
                    :show-export="false"
                    :sideBar="{}"
                    :url="url"
                    className="ag-theme-alpine"
                    domLayout='autoHeight'
                    rowSelection="multiple"
                    @gridReady="onGridReady"
                    @newData="newData"
                >
                    <template #header_buttons>

                    </template>

                </AgGridTable>
            </div>
        </div>
        <div class="container" style="opacity:0;heigth:25px">Espaceur</div>
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
import CheckPoste from "./CheckPoste.vue";
import PostesTraitements from "./PostesTraitements.vue";


import AgGridSearch from "@/components/AgGridSearch.vue";

export default {
    name: 'Readprogrammesusers',
    props: ['horairesData', 'filter',],
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
        CheckPoste
    },
    data() {
        return {
            data: {},
            add: {
                user_id: 0,
                date: {}
            },
            errors: {},
            formId: "programmationsusers",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/programmationsusers-Aggrid',
            table: 'programmationsusers',
            // usersData: [],
            requette: 1,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            allData: [],
            usersData: [],
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
            },
            addTitulaire: {
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
            },
            clients: {},
            actualPoste: 0,
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
        periodes: function () {
            let dateA = moment(this.data.date_debut, 'YYYY-MM-DD')
            let dateB = moment(this.data.date_fin, 'YYYY-MM-DD')
            let date = [dateA.format('YYYY-MM-DD')]
            let encore = true
            let i = 0;
            let diff = dateB.diff(dateA, 'days');
            if (diff > 0) {
                while (encore) {
                    let actual = date[date.length - 1]
                    actual = moment(actual, 'YYYY-MM-DD')
                    let demain = actual.add(1, 'days')
                    console.log('voici la date  actual ==>', actual, demain.format('YYYY-MM-DD'))
                    date.push(demain.format('YYYY-MM-DD'))
                    if (dateB.diff(actual, 'days') == 0 || i == 30) {
                        encore = false
                    } else {

                        i++
                    }

                }
            }

            console.log('voici la date ==>', dateA, dateB, this.data, this.data.date_fin)
            console.log('voici la dates collecter ==>', date, i)
            return date;

        },
        allProgrammesUsersForClient: function () {
            let clientId = this.params.data.id;
            let postesForClient = this.data.Allclients[clientId]
            return Object.values(postesForClient)

        },
        columnDefs: function () {
            let data = [
                {
                    field: "user.matricule",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'matricule',
                    maxWidth: 150
                },
                {
                    field: "user.nom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'nom',
                    maxWidth: 150
                },
                {
                    field: "user.prenom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'prenom',
                    maxWidth: 150
                },
                {
                    field: "user.num_badge",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'num_badge',
                    maxWidth: 150
                },
            ];


            if (this.periodes.length == 1) {

                this.periodes.forEach(date => {
                    let donnees = [];

                    donnees.push({
                        headerName: 'Poste',
                        field: 'user.Selectlabel',
                        maxWidth: 150,
                        cellRendererSelector: params => {
                            return {
                                component: 'CheckPoste',
                                params: {
                                    clicked: field => {
                                        this.showForm('Update', field, params.api)
                                    },
                                    actualDate: date,
                                    etats: 'manuel',
                                    usersData: this.usersData
                                },
                            }
                        }
                    })
                    donnees.push({
                        headerName: 'Etat',
                        field: 'user.Selectlabel',
                        cellRendererSelector: params => {
                            return {
                                component: 'ListingsTraitements',
                                params: {
                                    clicked: field => {
                                        this.showForm('Update', field, params.api)
                                    },
                                    actualDate: date,
                                    etats: 'manuel',
                                    usersData: this.usersData
                                },
                            }
                        }
                    })

                    donnees.forEach(dat => data.push(dat))
                })
            }

            return data;

        },
        extrasData: function () {
            let params = {}
            params['programmation_id'] = {values: [this.data.id], filterType: 'set'}
            if (Array.isArray(this.filter)) {
                params['user_id'] = {values: this.filter, filterType: 'set'}
            }
            return {
                'baseFilter': params,
                'client_id': this.params.data.id,
                'programmation_id': this.data.id
            }

        },
        testData: function () {
            let data = {}
            try {
                data = this.allData[0]
            } catch (e) {
            }
            return data
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

        console.log('userListings==>', this.params.api)
        this.url = this.axios.defaults.baseURL + '/api/programmationsusers-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.data = this.params.api.__parentParams
        this.clients = this.data.AllClients
        this.usersData = this.params.api.__usersData

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
        this.addTitulaire.rowModelType = 'serverSide';

        this.addTitulaire.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
            this.addTitulaire.columnDefs = [

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
                                    this.addUser1(field)
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
        this.addTitulaire.cacheBlockSize = 50;
        this.addTitulaire.maxBlocksInCache = 2;
        console.log('voici les data passer en parametre 1', this.data)
    },
    methods: {
        getExtrasData(filtre) {
            let params = {}
            params['id'] = {values: filtre.programmationsUser, filterType: 'set'}
            return {
                'baseFilter': params,
            }
        },
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        openCreateAgent(posteId) {
            this.actualPoste = posteId;
            this.showForm('CreateAgent', {}, this.gridApi)
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
                    tache_id: this.add.date[cle],
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
            this.isLoading = true
            let data = {}
            data.id = element.id
            console.log('suppression dagent du listing ===>', data)
            this.axios.post('/api/programmationsusers/' + element.id + '/delete', data)
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
        },
        newData(data) {
            this.allData = data.rowData
        },
        addUser(element) {
            console.log('voici les donnees ===>', element, this.testData)

            let data = this.testData.programmes.map(data => {
                let donnees = {
                    programmation_id: this.testData.programmation_id,
                    user_id: element.id,
                    date: data.date,
                    tache_id: data.horaire_id,
                }
                return donnees
            })

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
        addUser1(element) {
            let programmationId = this.data.id
            let periodes = this.periodes
            let titulaireId = element.id
            let poste = this.actualPoste
            console.log('voici les donnees des titulaire a rajouter ===>', programmationId, periodes, titulaireId)
            let data = {
                programmation_id: programmationId,
                titulaire_id: titulaireId,
                periodes: periodes,
                poste: poste,
            }

            this.axios.post('/api/programmationsActionAddTitulaire', data).then((response) => {
                // this.axios.post('/api/programmations/action?action=addTitulaire', data).then((response) => {
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
.ag-root-wrapper {
    border-radius: 5px
}

.listesDesAgentsProgrammer {
    margin: 10px auto;
    width: 90%;
}

</style>
