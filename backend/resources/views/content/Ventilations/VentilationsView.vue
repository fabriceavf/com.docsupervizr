<template>

    <div :key="key" class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Ventilations #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Ventilations</div>
            </template>

            <EditVentilations v-if="formState == 'Update'" :key="formKey" :data="formData" :gridApi="formGridApi"
                              :modalFormId="formId" :tachesData="tachesData" :usersData="usersData" @close="closeForm"/>


            <CreateVentilations v-if="formState == 'Create'" :key="formKey" :gridApi="formGridApi" :modalFormId="formId"
                                :tachesData="tachesData" :usersData="usersData" @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="col-sm-12">
            <template class=" card">
                <div class=" d-flex justify-content-arround allBoutons card-body custom-control custom-switch">


                    <!--                    <div style="display: flex;gap:10px;width: 100%;">-->
                    <!--                        <div style="display:flex;flex-direction:row;align-items: center;gap:10px;border: 1px solid #c4c4c4;border-radius: 5px;padding: 5px 10px;" v-for="type in ['absence','heure sup','anomalies']">-->
                    <!--                            <div>-->
                    <!--                                {{type}}-->
                    <!--                            </div>-->
                    <!--                            <div style="display:flex;flex-direction:column">-->
                    <!--                                <template v-for="page in allPages">-->
                    <!--                                    <template v-if="page.includes(type)">-->
                    <!--                                        <span v-if="typesventilations == page.replaceAll(' ','')"-->
                    <!--                                                :key="`oui-${page.replaceAll(' ','')}`" style="color:green"-->
                    <!--                                                @click.prevent="togglePage(page.replaceAll(' ',''))">-->
                    <!--                                            <i class="fa-regular fa-square-check"></i> {{ page.replace(type,'') }}-->
                    <!--                                        </span>-->
                    <!--                                        <span v-else :key="`non-${page.replaceAll(' ','')}`"-->
                    <!--                                                @click.prevent="togglePage(page.replaceAll(' ',''))">-->
                    <!--                                            <i class="fa-regular fa-square"></i> {{ page.replace(type,'') }}-->
                    <!--                                        </span>-->

                    <!--                                    </template>-->

                    <!--                             </template>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->


                </div>
            </template>

            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label>date de debut </label>
                        <input v-model="form.debut" class="form-control" required type="date">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>date de fin </label>
                        <input v-model="form.fin" class="form-control" required type="date">

                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <br/>
                        <div style="display: flex;gap:5px">
                            <button class="btn btn-primary" @click.prevent="checkInDate()">Valider</button>

                            <b-overlay :show="isLoadingRapport">
                                <button class="btn btn-warning" @click.prevent="Exporter()"> Exporter</button>
                            </b-overlay>
                        </div>

                    </div>
                </div>

            </div>
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData" :rowModelType="rowModelType"
                         :showDelete="false"
                         :showExport="false"
                         :url="url"
                         className="ag-theme-alpine" domLayout='autoHeight' rowSelection="multiple"
                         @gridReady="onGridReady">
                <template #header_buttons>
                    <div
                        v-for="type in ['absence','heure sup','anomalies']"
                        style="display:flex;flex-direction:row;align-items: center;gap:10px;border: 1px solid #c4c4c4;border-radius: 5px;padding: 5px 10px;">
                        <div>
                            {{ type }}
                        </div>
                        <div style="display:flex;flex-direction:column">
                            <template v-for="page in allPages">
                                <template v-if="page.includes(type)">
                                        <span v-if="typesventilations == page.replaceAll(' ','')"
                                              :key="`oui-${page.replaceAll(' ','')}`" style="color:green"
                                              @click.prevent="togglePage(page.replaceAll(' ',''))">
                                            <i class="fa-regular fa-square-check"></i> {{ page.replace(type, '') }}
                                        </span>
                                    <span v-else :key="`non-${page.replaceAll(' ','')}`"
                                          @click.prevent="togglePage(page.replaceAll(' ',''))">
                                            <i class="fa-regular fa-square"></i> {{ page.replace(type, '') }}
                                        </span>

                                </template>

                            </template>
                        </div>
                    </div>
                </template>

            </AgGridTable>

        </div>

    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import AgGridSearch from "@/components/AgGridSearch.vue"
import CreateVentilations from './CreateVentilations.vue'
import EditVentilations from './EditVentilations.vue'
import CreateListingsjours from './../Listingsjours/CreateListingsjours.vue'
import DataModal from '@/components/DataModal.vue'
import CustomFiltre from "@/components/CustomFiltre.vue";
import moment from 'moment'
import PostesTraitements from "./../Programmations/PostesTraitements.vue";
import DeclarerPresents from "./../Programmations/Traitements/DeclarerPresents.vue"
import GetPoste from "./../Programmations/Traitements/GetPoste.vue"
import GetSite from "./../Programmations/Traitements/GetSite.vue"
import GetClient from "./../Programmations/Traitements/GetClient.vue"
import GetHoraire from "./../Programmations/Traitements/GetHoraire.vue"
import GetPointages from "./../Programmations/Traitements/GetPointages.vue"
import GetRemplacant from "./../Programmations/Traitements/GetRemplacant.vue"
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'VentilationsView',
    components: {
        DataTable,
        AgGridTable,
        AgGridSearch,
        CreateVentilations,
        EditVentilations,
        DataModal,
        AgGridBtnClicked,
        CreateListingsjours,
        CustomFiltre,
        GetPoste,
        GetSite,
        GetClient,
        GetHoraire,
        GetRemplacant,
        GetPointages,
        DeclarerPresents
    },
    data() {

        return {
            isLoadingRapport: false,
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
            usersData: [],
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
            typesventilations: '',
            form: {
                debut: 0,
                fin: 0
            },
            allPages: [
                'absence traites',
                'absence non traites',
                'heure sup traites',
                'heure sup non traites',
                'anomalies traites',
                'anomalies non traites',
            ]

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


            this.tableKey++;

            return {
                debut: this.form.debut,
                fin: this.form.fin,
                typesventilations: this.typesventilations,
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
        // this.url = this.axios.defaults.baseURL + '/api/programmations-Aggrid',
        this.url = this.axios.defaults.baseURL + '/api/programmes-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        // let params = {}
        // params['type'] = {values: ['programmations'], filterType: 'set'}
        // if (this.$routeData.meta.isListings) {
        //     params['type'] = {values: ['listings'], filterType: 'set'}

        // }
        // this.extrasData['baseFilter'] = params
        // this.extrasData['selectAllId'] = 1

    },
    beforeMount() {
        this.columnDefs = [

            {
                headerName: 'Pts',
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
                headerName: 'debut prevu',
                field: 'debut_prevu',
                minWidth: 150,
            },
            {
                headerName: 'fin prevu',
                field: 'fin_prevu',
                minWidth: 150,
            },
            {
                headerName: 'debut collecter',
                field: 'debut_realise',
                minWidth: 150,
            },
            {
                headerName: 'fin collecter',
                field: 'fin_realise',
                minWidth: 150,
            },
            {
                headerName: 'Client',

                hide: true,
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
                hide: true,
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
            // {
            //     headerName: 'Remplacant',
            //     field: null,
            //     cellRendererSelector: params => {
            //         return {
            //             component: 'GetRemplacant',
            //             params: {
            //                 clicked: field => {
            //                     this.showForm('Update', field, params.api)
            //                 },
            //                 etats: 'manuel',
            //                 usersData: this.usersData,
            //                 listingId: this.data.id
            //             },
            //         }
            //     }
            // },
            // {
            //     headerName: `Presents ?`,
            //     field: null,
            //     minWidth: 80,
            //     maxWidth: 100,
            //     cellRendererSelector: params => {
            //         return {
            //             component: 'DeclarerPresents',
            //             params: {
            //                 clicked: field => {
            //                     this.showForm('Update', field, params.api)
            //                 },
            //                 etats: 'manuel',
            //                 usersData: this.usersData
            //             },
            //         }
            //     }
            // }
            // {
            //     hide: true,
            //     suppressColumnsToolPanel: true,

            //     headerName: 'Types',
            //     field: 'typesventilations',
            //     valueFormatter: params => {
            //         let retour = ''
            //         try {
            //             return params.data['typesagentshoraire']['Selectlabel']
            //         } catch (e) {

            //         }
            //         return retour
            //     },
            //     filter: "FiltreEntete",
            //     filterParams: {
            //         url: this.axios.defaults.baseURL + '/api/typesventilations-Aggrid',
            //         columnDefs: [
            //             {
            //                 field: "",
            //                 sortable: true,
            //                 filter: "agTextColumnFilter",
            //                 filterParams: { suppressAndOrCondition: true },
            //                 headerName: "",
            //                 cellStyle: { fontSize: '11px' },
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
        ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.form.debut = new Date().toISOString().slice(0, 11) + '00:00',
            this.form.fin = new Date().toISOString().slice(0, 11) + '23:59'
        // this.gettaches();
        // this.getusers();

    },
    methods: {
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
        },
        gettaches() {
            this.axios.get('/api/taches').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.tachesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getusers() {
            this.axios.get('/api/users/type_id/2,3').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.usersData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        togglePage(page) {
            this.typesventilations = page
            // this.tableKey++;
        },
        checkInDate() {
            // alert('on as chosit entre les dates et on peut desormait affricher le formulaire')
            this.tableKey++
        },
        Exporter() {
            this.isLoadingRapport = true
            this.axios.post('/api/get-ventillations', this.form).then(response => {
                this.isLoadingRapport = false
                window.open(response.data, "_blank");
                this.$toast.success('Operation effectuer avec succes')
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoadingRapport = false
                this.$toast.error('Erreur survenu lors de la generation du fichier de ventilations')
            })
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
