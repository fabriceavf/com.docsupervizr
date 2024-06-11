<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">
                    Update Rapports #{{ formData.id }}
                </div>
                <div v-if="formState == 'Create'">Create Rapports</div>
            </template>

            <EditRapports v-if="formState == 'Update'" :key="formKey" :clientsData="clientsData" :data="formData"
                          :factionsData="factionsData" :fonctionsData="fonctionsData" :gridApi="formGridApi"
                          :modalFormId="formId"
                          :postesData="postesData" :sitesData="sitesData" :typesData="typesData"
                          :villesData="villesData"
                          :zonesData="zonesData" @close="closeForm"/>

            <CreateRapports v-if="formState == 'Create'" :key="formKey" :clientsData="clientsData"
                            :factionsData="factionsData"
                            :fonctionsData="fonctionsData" :gridApi="formGridApi" :modalFormId="formId"
                            :postesData="postesData"
                            :sitesData="sitesData" :typesData="typesData" :villesData="villesData"
                            :zonesData="zonesData"
                            @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <div class="row col-sm-12" style="display: flex;justify-content: space-around">
            <!-- <div v-if="actualPage == 'Agents'" class="col-sm-12 card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-1" style="text-align: center;
display: flex;
justify-content: center;
align-content: center;
align-items: center;">


                            <h5 class="card-title">Directions</h5>
                        </div>
                        <div class="col-sm-10">

                            <button v-for="items  in directionsget" v-b-tooltip.hover
                                    :style="directionselectionner.includes(items.id) ? 'border: 3px solid  green' : ''"
                                    class="btn card-body"
                                    style=""
                                    @click.prevent="directionsselect(items.id)">
                                <div class="iconParent">
                            <span> <i class="fa-solid fa-filter"></i>

                                {{ items.code }}
                            </span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-12 card">
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

                            <button v-for="items  in zonesgets" v-b-tooltip.hover
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
            <div class="col-sm-12 card">
                <div class="card-body">
                    <button v-b-tooltip.hover :style="actualPage == 'Postes' ? 'border: 3px solid  green' : ''"
                            class="btn card-body"
                            style="" @click.prevent="togglePage('Postes')">
                        <div class="iconParent">
                    <span> <i class="fa-solid fa-filter"></i> Postes
                    </span>
                        </div>
                    </button>
                    <button v-b-tooltip.hover
                            :style="actualPage == 'Agents' ? 'border:3px solid  green' : ''"
                            class="btn" style=""
                            @click.prevent="togglePage('Agents')">
                        <div class="iconParent">

                            <span> <i class="fa-solid fa-filter"></i> Agents</span>

                        </div>
                    </button>
                    <button v-b-tooltip.hover
                            :style="actualPage == 'Agents/Postes' ? 'border:3px solid  green' : ''"
                            class="btn" style=""
                            @click.prevent="togglePage('Agents/Postes')">

                        <div class="iconParent">

                            <span> <i class="fa-solid fa-filter"></i> Agents/Postes</span>

                        </div>
                    </button>
                    <button v-b-tooltip.hover
                            :style="actualPage == 'Retard' ? 'border:3px solid  green' : ''"
                            class="btn" style=""
                            @click.prevent="togglePage('Retard')">

                        <div class="iconParent">

                            <span> <i class="fa-solid fa-filter"></i> Retard</span>

                        </div>
                    </button>
                    <button v-b-tooltip.hover
                            :style="actualPage == 'rapport-totaux' ? 'border:3px solid  green' : ''"
                            class="btn" style=""
                            @click.prevent="togglePage('rapport-totaux')">

                        <div class="iconParent">

                            <span> <i class="fa-solid fa-filter"></i> Synthèse </span>

                        </div>
                    </button>
                </div>

            </div>


        </div>

        <div v-if="actualPage == 'Postes'" class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData"
                         :rowModelType="rowModelType" :url="url" className="ag-theme-alpine"
                         domLayout="autoHeight" rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>
                    <input v-model="month" class="form-control" placeholder="Veuillez selectioner le mois"
                           style="width: auto !important" type="month"/>
                </template>
            </AgGridTable>
        </div>
        <div class="col-sm-12">
            <AgentsrapportsView v-if="actualPage == 'Agents'" :directionselectionner='directionselectionner'
                                :zoneselectionner='zoneselectionner'/>

            <AgentsrapportsView v-if="actualPage == 'Retard'" :directionselectionner='directionselectionner'
                                :statsTypes="'Retard'"
                                :zoneselectionner='zoneselectionner'/>

            <AgentsrapportsView v-if="actualPage == 'rapport-totaux'" :directionselectionner='directionselectionner'
                                :statsTypes="'rapport-totaux'"
                                :zoneselectionner='zoneselectionner'/>

            <AgentsPostes v-if="actualPage == 'Agents/Postes'" :zoneselectionner='zoneselectionner'/>

        </div>
    </div>
</template>

<script>
import DataTable from "@/components/DataTable.vue";
import AgGridTable from "@/components/AgGridTable.vue";
import AgentsPostes from './AgentsPostes.vue';
import CreateRapports from "./CreateRapports.vue";
import EditRapports from "./EditRapports.vue";
import DataModal from "@/components/DataModal.vue";
import CustomFiltre from "@/components/CustomFiltre.vue";
import AgentsrapportsView from '../Agentsrapports/AgentsrapportsView.vue';

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: "RapportsView",
    components: {
        DataTable,
        AgGridTable,
        CreateRapports,
        EditRapports,
        DataModal,
        AgGridBtnClicked,
        CustomFiltre,
        AgentsrapportsView,
        AgentsPostes
    },
    data() {
        return {
            month: null,
            formId: "rapports",
            formState: "",
            formData: {},
            formWidth: "lg",
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: "http://127.0.0.1:8000/api/rapports-Aggrid",
            table: "rapports",
            clientsData: [],
            factionsData: [],
            fonctionsData: [],
            postesData: [],
            pointeusesData: [],
            zonesgets: [],
            directionsget: [],
            zoneselectionner: [],
            sitesData: [],
            typesData: [],
            directionselectionner: [],
            villesData: [],
            zonesData: [],
            requette: 8,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            actualPage: '',
            maxBlocksInCache: 1,
        };
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
                if (typeof window.routeData != "undefined") {
                    router = window.routeData;
                }
            } catch (e) {
            }
            return router;
        },
        taille: function () {
            let result = "col-sm-12";
            if (this.filtre) {
                result = "col-sm-9";
            }
            return result;
        },
        columnDefs: function () {
            let columnDefs =
                [


                    {
                        field: "libelle",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'libelle',
                        pinned: 'left',
                        width: 200,
                    },
                    {
                        headerName: 'client',
                        field: 'site.client.Selectlabel',
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
                        filter: "CustomFiltre",
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
                        headerName: 'site',
                        field: 'site.Selectlabel',
                    },
                    {
                        hide: true,
                        suppressColumnsToolPanel: true,

                        headerName: 'site',
                        field: 'site_id',
                        valueFormatter: params => {
                            let retour = ''
                            try {
                                return params.data['site']['Selectlabel']
                            } catch (e) {

                            }
                            return retour
                        },
                        filter: "CustomFiltre",
                        filterParams: {
                            url: this.axios.defaults.baseURL + '/api/sites-Aggrid',
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

                ];

            for (let i = 1; i <= 31; i++) {
                let newChamp = {
                    field: `J${i}`,
                    maxWidth: 90,
                    headerName: `J${i}`,
                    cellStyle: params => {
                        if (parseInt(params.value) > 0) {
                            return {color: 'white', backgroundColor: 'green'};
                        }
                        return null;
                    }
                };
                columnDefs.push(newChamp);
            }
            return columnDefs;
        },
        extrasData: function () {
            let params = {};
            if (!this.month) {
                params["id"] = {values: [0], filterType: "set"};
            }
            this.tableKey++;

            return {
                baseFilter: params,
                directionselectionner: this.directionselectionner,
                zoneselectionner: this.zoneselectionner,
                month: this.month,
                type: this.$routeData.meta.statsType
            };
        },
    },
    watch: {
        routeData: {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null);
                this.gridApi.refreshServerSide();
            },
            deep: true,
        },
    },
    created() {
        (this.url = this.axios.defaults.baseURL + "/api/postes-Aggrid"),
            (this.formId = this.table + "_" + Date.now());
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
    },
    beforeMount() {
    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.actualPage = 'Postes'
        this.zonesgets = this.$routeData.meta.zonesGet
        this.directionsget = this.$routeData.meta.directionsGet

        console.log('this.zonesget', this.$routeData.meta.statsType);

        // this.getclients();
        // this.getfactions();
        // this.getfonctions();
        // this.getpostes();
        // this.getsites();
        // this.gettypes();
        // this.getvilles();
        // this.getzones();
        // this.getpointeuses();

    },
    methods: {
        closeForm() {
            this.tableKey++;
        },
        openCreate() {
            this.showForm("Create", {}, this.gridApi);
        },
        showForm(type, data, gridApi, width = "lg") {
            this.formKey++;
            this.formWidth = width;
            this.formState = type;
            this.formData = data;
            this.formGridApi = gridApi;
            this.$bvModal.show(this.formId);
        },
        onGridReady(params) {
            console.log("on demarre", params);
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false;
        },
        getclients() {
            this.axios
                .get("/api/clients")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.clientsData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getfactions() {
            this.axios
                .get("/api/factions")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.factionsData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getfonctions() {
            this.axios
                .get("/api/fonctions")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.fonctionsData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getpostes() {
            this.axios
                .get("/api/postes")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.postesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getsites() {
            this.axios
                .get("/api/sites")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.sitesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },
        getpointeuses() {
            this.axios.get('/api/pointeuses').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.pointeusesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        gettypes() {
            this.axios
                .get("/api/types")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.typesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getvilles() {
            this.axios
                .get("/api/villes")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.villesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getzones() {
            this.axios
                .get("/api/zones")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.zonesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },
        togglePage(page) {
            this.actualPage = page
            // this.type = page
        },
        directionsselect(direction) {

            if (this.directionselectionner.includes(direction)) {
                const index = this.directionselectionner.indexOf(direction);
                if (index !== -1) {
                    this.directionselectionner.splice(index, 1);
                }
            } else {
                this.directionselectionner.push(direction);
            }

            this.extrasData1.directionselectionner = this.directionselectionner

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
        },
    },
};
</script>
