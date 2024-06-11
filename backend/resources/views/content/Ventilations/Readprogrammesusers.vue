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
                :sideBar="false"
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
import HS from "./HS.vue";
import CalculHS from "./CalculHS.vue";
import moment from 'moment'
import VSelect from 'vue-select'
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'Readprogrammesusers',
    props: ['data', 'usersData', 'horairesData'],
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked,
        VSelect, CustomSelect, HS, CalculHS
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
            return date;

        },
        columnDefs: function () {
            let data = [


                {
                    field: "user.nom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'nom',
                },
                {
                    field: "user.prenom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'prenom',
                },

            ];
            this.periodes.forEach(date => {
                let donnees = {
                    headerName: date,
                    field: 'user.Selectlabel',
                    cellRendererSelector: params => {
                        return {
                            component: 'HS',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                refresh: field => {
                                    this.refreshData()
                                },
                                actualDate: date
                            },
                        }
                    }
                }

                data.push(donnees)

            })
            data.push({
                field: null,
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: 'TH Prog',
                cellRendererSelector: params => {
                    return {
                        component: 'CalculHS',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            refresh: field => {
                                this.refreshData()
                            },
                            dates: this.periodes,
                            type: 'THP',
                        },
                    }
                }
            })
            data.push({
                field: null,
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: 'TH Col',
                cellRendererSelector: params => {
                    return {
                        component: 'CalculHS',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            refresh: field => {
                                this.refreshData()
                            },
                            dates: this.periodes,
                            type: 'THC',
                        },
                    }
                }
            })
            data.push({
                field: null,
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: 'TH Sup',
                cellRendererSelector: params => {
                    return {
                        component: 'CalculHS',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            refresh: field => {
                                this.refreshData()
                            },
                            dates: this.periodes,
                            type: 'THS',
                        },
                    }
                }
            })
            data.push({
                field: null,
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: 'HS15',
                cellRendererSelector: params => {
                    return {
                        component: 'CalculHS',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            refresh: field => {
                                this.refreshData()
                            },
                            dates: this.periodes,
                            type: 'HS15',
                        },
                    }
                }
            })
            data.push({
                field: null,
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: 'HS26',
                cellRendererSelector: params => {
                    return {
                        component: 'CalculHS',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            refresh: field => {
                                this.refreshData()
                            },
                            dates: this.periodes,
                            type: 'HS26',
                        },
                    }
                }
            })
            data.push({
                field: null,
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: 'HS55',
                cellRendererSelector: params => {
                    return {
                        component: 'CalculHS',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            refresh: field => {
                                this.refreshData()
                            },
                            dates: this.periodes,
                            type: 'HS55',
                        },
                    }
                }
            })
            data.push({
                field: null,
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: 'HS30',
                cellRendererSelector: params => {
                    return {
                        component: 'CalculHS',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            refresh: field => {
                                this.refreshData()
                            },
                            dates: this.periodes,
                            type: 'HS30',
                        },
                    }
                }
            })
            data.push({
                field: null,
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: 'HS115',
                cellRendererSelector: params => {
                    return {
                        component: 'CalculHS',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            refresh: field => {
                                this.refreshData()
                            },
                            dates: this.periodes,
                            type: 'HS115',
                        },
                    }
                }
            })
            data.push({
                field: null,
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: 'HS60',
                cellRendererSelector: params => {
                    return {
                        component: 'CalculHS',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            refresh: field => {
                                this.refreshData()
                            },
                            dates: this.periodes,
                            type: 'HS60',
                        },
                    }
                }
            })
            data.push({
                field: null,
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: 'HS130',
                cellRendererSelector: params => {
                    return {
                        component: 'CalculHS',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            refresh: field => {
                                this.refreshData()
                            },
                            dates: this.periodes,
                            type: 'HS130',
                        },
                    }
                }
            })
            return data;

        }
        // cellRendererSelector: params => {
        //     let horaire = "Inconnu"
        //     try {
        //         let programmes = params.data.programmes.filter(ele => {
        //             let _date = ele.date.split(' ')[0]
        //             return _date == date
        //         })
        //         horaire = programmes[0].horaire.Selectlabel
        //         console.log('voici ce que je recois ==>', horaire)
        //     } catch (e) {
        //
        //     }
        //     return {
        //         component: 'AgGridBtnClicked',
        //         params: {
        //             clicked: field => {
        //                 this.showForm('Update', field, params.api)
        //             },
        //             render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer"> ${horaire}</div>`
        //             // render: horaire
        //         }
        //     };
        // },
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
        refreshData() {
            this.tableKey++
        }

    }
}
</script>
