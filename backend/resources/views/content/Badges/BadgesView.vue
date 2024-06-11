<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Badges #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Badges</div>
            </template>

            <EditBadges v-if="formState == 'Update'" :key="formKey" :clientsData="clientsData" :data="formData"
                        :gridApi="formGridApi" :modalFormId="formId" @close="closeForm"/>


            <CreateBadges v-if="formState == 'Create'" :key="formKey" :clientsData="clientsData" :gridApi="formGridApi"
                          :modalFormId="formId" @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <!--        <div class="col-sm-12">-->
        <!--            <AgGridTable :key="tableKey" domLayout='autoHeight' rowSelection="multiple" className="ag-theme-alpine"-->
        <!--                :columnDefs="columnDefs" :url="url" :rowModelType="rowModelType" :paginationPageSize="paginationPageSize"-->
        <!--                :cacheBlockSize="cacheBlockSize" :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"-->
        <!--                :rowData="rowData" @gridReady="onGridReady">-->
        <!--                <template #header_buttons>-->
        <!--                    <div class="btn btn-primary" v-if="!routeData.meta.hideCreate" @click="openCreate"><i-->
        <!--                            class="fa fa-plus"></i> Nouveau-->
        <!--                    </div>-->
        <!--                </template>-->

        <!--            </AgGridTable>-->

        <!--        </div>-->
        <div class="col-sm-12">
            <AgGridRendu
                :filterColumns="[{column:'type_id',value:[1],type:'set'}]"
                :globalSearchColumns="['nom']"
                :paginationPage="10"
                :url="url"
            >
                <template v-slot="{data,api}">
                    <template v-if="Array.isArray(data)">
                        <p v-for="user in data">
                            {{ user.nom }} {{ user.prenom }} {{ user.email }}
                        </p>

                    </template>

                </template>

            </AgGridRendu>
        </div>
    </div>
</template>


<script>
import CalendrierBadges from './CalendrierBadges.vue'
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import AgGridRendu from "@/components/AgGridRendu.vue"
import CreateBadges from './CreateBadges.vue'
import EditBadges from './EditBadges.vue'
import DataModal from '@/components/DataModal.vue'
import moment from 'moment'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'BadgesView',

    components: {
        DataTable,
        AgGridTable,
        CreateBadges,
        EditBadges,
        DataModal,
        AgGridBtnClicked,
        CalendrierBadges,
        AgGridRendu
    },

    data() {

        return {
            formId: "badges",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/badges-Aggrid',
            table: 'badges',
            clientsData: [],
            requette: 1,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            users: [],
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
        this.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

    },
    beforeMount() {
        this.columnDefs =
            [
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
                    field: "content",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'content',
                },


                {
                    field: "js",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'js',
                },


                {
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },


                {
                    field: "css",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'css',
                },


                {
                    field: "node_version",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'node_version',
                },


                {
                    field: "identifiants_sadge",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'identifiants_sadge',
                },


                {
                    headerName: 'client',
                    field: 'client.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'client',
                    field: 'client_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['client']['Selectlabel']
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
                            params.success(this.clientsData);
                        },
                        refreshValuesOnOpen: true,
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
            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getclients();

        // const readerName = 'DigitalPersona U.are.U 4500';
        //
        // dp.init().then(() => {
        //     console.log('DigitalPersona Cores SDK initialized.');
        //
        //     dp.devices().then((devices) => {
        //         const reader = devices.find((device) => device.name === readerName);
        //
        //         if (!reader) {
        //             console.log(`Device ${readerName} not found.`);
        //             return;
        //         }
        //
        //         dp.acquire(reader.id, dp.DataFormat.Raw, dp.CaptureMode.Finger, dp.Quality.Normal).then((data) => {
        //             console.log('Fingerprint acquired.');
        //
        //             // Send fingerprint data to server for verification/authentication
        //             // ...
        //
        //         }).catch((error) => {
        //             console.error(`Error acquiring fingerprint: ${error}`);
        //         });
        //
        //     }).catch((error) => {
        //         console.error(`Error getting devices: ${error}`);
        //     });
        //
        // }).catch((error) => {
        //     console.error(`Error initializing DigitalPersona Cores SDK: ${error}`);
        // });


        // let server=new Server(this.axios)
        // server.setUrl(this.axios.defaults.baseURL + '/api/users-Aggrid')
        // server.addOn('dataLoadSuccess',(ser,data)=>{
        //    console.log('recuperation de donnees avec succes',data,ser)
        //     this.users=data.rowData
        // })
        // server.addOn('dataLoadError',(ser,data)=>{
        //    console.log('recuperation de donnees sans succes',data,ser)
        // })
        // server.globalSearch('Akandas',['nom','prenom','matricule'],true);

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

    }
}
</script>
