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


            <div v-if="formState=='AddUsers'">


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

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-floppy-disk"></i> Enregistrer
                        </button>
                        <button v-if="add.id!=0" class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                            <i class="fas fa-close"></i> Supprimer
                        </button>
                    </div>
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
                :rowModelType="rowModelType"
                :show-export="false"
                :sideBar="{}"
                :url="url"
                className="ag-theme-alpine"
                domLayout='autoHeight'
                rowSelection="multiple"
                @gridReady="onGridReady"

            >
                <template #header_buttons>
                    <div v-if="!routeData.meta.hideCreate" class="btn btn-primary"
                         @click="createAgentProgramme()"><i
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
import DataModal from '@/components/DataModal.vue'
import moment from 'moment'
import VSelect from 'vue-select'
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'Managesprogrammesusers',
    props: ['data', 'usersData', 'horairesData'],
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked,
        VSelect
    },
    data() {
        return {
            add: {
                user_id: 0,
                date: {},
                id: 0
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
            extrasData: {},
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
        columnDefs: function () {
            let data = [
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
                                    this.updateAgentProgramme(params.data)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },


                // {
                //     field: "identifiants_sadge",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'identifiants_sadge',
                // },


                {
                    headerName: 'user',
                    field: 'user.Selectlabel',
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
            this.periodes.forEach(date => {
                let donnees = {
                    headerName: date,
                    field: 'user.Selectlabel',
                    cellRendererSelector: params => {
                        let horaire = "Inconnu"
                        try {
                            let programmes = params.data.programmes.filter(ele => {
                                let _date = ele.date.split(' ')[0]
                                return _date == date
                            })
                            horaire = programmes[0].horaire.Selectlabel
                            console.log('voici ce que je recois ==>', horaire)
                        } catch (e) {

                        }
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer"> ${horaire}</div>`
                                // render: horaire
                            }
                        };
                    },
                }

                data.push(donnees)

            })
            return data;

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
        this.url = this.axios.defaults.baseURL + '/api/programmationsusers-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }


        // while(encore){
        //
        // }
        // return data;

        // this.getusers();

    },
    beforeMount() {


    },
    mounted() {
        let params = {}
        params['programmation_id'] = {values: [this.data.id], filterType: 'set'}
        this.extrasData['baseFilter'] = params
        console.log('voici la data passer ==>', this.data)

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
        updateAgentProgramme(data) {

            let add = {
                user_id: data.user_id,
                date: {},
                id: data.id
            }
            let programmes = [];
            try {
                programmes = data.programmes

            } catch (e) {

            }
            programmes.forEach(data => {
                console.log('on veut update le programmes', data)
                let _date = "";
                try {
                    _date = data.date.split(' ')[0]
                } catch (e) {

                }
                add.date[_date] = data.horaire_id;
            })

            this.add = add
            console.log('on veut update cette ligne', data, add)
            this.showForm('AddUsers', {}, this.gridApi)

        },
        createAgentProgramme() {
            let add = {
                user_id: 0,
                date: {},
                id: 0,
            }


            this.add = add
            this.showForm('AddUsers', {}, this.gridApi)

        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/programmationsusers/' + this.add.id + '/delete',).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.formId)
                this.tableKey++
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de loperation')
            })


        }

    }
}
</script>
