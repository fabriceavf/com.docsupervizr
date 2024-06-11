<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Programmationsusers #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Programmationsusers</div>
                <div v-if="formState=='AddUsers'">Programmer un agent</div>
            </template>

            <!--            <EditProgrammationsusers-->
            <!--                v-if="formState=='Update'"-->
            <!--                :modalFormId="formId"-->
            <!--                :key="formKey"-->
            <!--                :data="formData"-->
            <!--                :gridApi="formGridApi"-->
            <!--                @close="closeForm"-->
            <!--                :usersData="usersData"-->
            <!--            />-->


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
            <!--            <CreateProgrammationsusers-->
            <!--                v-if="formState=='Create'"-->
            <!--                :modalFormId="formId"-->
            <!--                :key="formKey"-->
            <!--                :gridApi="formGridApi"-->
            <!--                @close="closeForm"-->
            <!--                :usersData="usersData"-->
            <!--            />-->

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
                :rowHeight="50"
                :rowModelType="rowModelType"
                :show-export="false"
                :url="url"
                className="ag-theme-alpine"
                domLayout='autoHeight'
                rowSelection="multiple"
                @gridReady="onGridReady"

            >
                <template #header_buttons>
                    <!--                    <div class="btn btn-primary" v-if="!routeData.meta.hideCreate"-->
                    <!--                         @click="showForm('AddUsers', {}, gridApi)"><i-->
                    <!--                        class="fa fa-plus"></i> Nouveau-->
                    <!--                    </div>-->
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
import moment from 'moment'
import VSelect from 'vue-select'
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import Presences from "./Presences.vue";

export default {
    name: 'Rapports',
    props: ['data', 'usersData', 'horairesData'],
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked,
        VSelect, CustomSelect,
        Presences
    },
    data() {
        return {
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
            usersData: [],
            requette: 1,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            users: [0],
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
        periodes: function () {

            return this.data.Generate.map(data => data.split(' ')[0]);

        },
        columnDefs: function () {
            let data = [
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
            this.periodes.forEach(date => {
                let donnees = {
                    headerName: date,
                    field: null,
                    cellRendererSelector: params => {
                        return {
                            component: 'Presences',
                            params: {
                                actualDate: date,
                                rapportId: this.data.id,
                            },
                        }
                    }
                }

                data.push(donnees)

            })
            return data;

        },
        extrasData: function () {
            let params = {baseFilter: {}}
            params['baseFilter']['id'] = {values: this.users, filterType: 'set'}
            return params
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
        'extrasData': {
            handler: function (after, before) {
                this.tableKey++
            },
            deep: true
        },

    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        // this.getUsers();

    },
    beforeMount() {
    },
    mounted() {


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
        showDate(date) {
            return moment(date, 'YYYY-MM-DD').locale('fr-fr').format("dddd") + ' ' + date
        },
        getUsers() {
            this.axios.post('/api/pointages/action?action=getMenbres', {id: this.data.id})
                .then(response => {
                    this.users = response.data

                })
                .finally(() => {

                })
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

        }

    }
}
</script>
