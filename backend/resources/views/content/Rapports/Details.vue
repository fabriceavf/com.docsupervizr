<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
            </template>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <!-- <div  class="col-sm-12 card">
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
                                class="btn card-body" style="" @click.prevent="zoneselect(items.id)">
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
                         :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData" :rowModelType="rowModelType"
                         :showExport="false"
                         :sideBar="false" :url="url" className="ag-theme-alpine" domLayout='autoHeight'
                         rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>
                    <!-- <input v-model="month" class="form-control" placeholder="Veuillez selectioner le mois"
                           style="width: auto !important" type="month"/> -->

                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import DataModal from '@/components/DataModal.vue'
import VSelect from "vue-select";
import CustomSelect from "@/components/CustomSelect.vue";
import CustomFiltre from "@/components/CustomFiltre.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'Details',
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked,
        VSelect,
        CustomFiltre,
        CustomSelect

    },
    data() {

        return {
            month: null,
            poste_id: null,
            formId: "Details",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/Details-Aggrid',
            table: 'Details',
            postesData: [],
            directionselectionner: [],
            directionsget: [],
            usersData: [],
            zonesget: [],
            zoneselectionner: [],
            requette: 1,
            // columnDefs: null,
            postedebase: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 5,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
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
                if (typeof window.routeData != "undefined") {
                    router = window.routeData;
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
        columnDefs: function () {
            let columnDefs = [

                {
                    field: "matricule",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'matricule',
                    pinned: 'left',
                },
                {
                    field: "nom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Nom',
                    pinned: 'left',
                },
                {
                    field: "prenom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'prenom',
                    pinned: 'left',
                },
                {
                    field: "jour_abscences",
                    cellStyle: {textAlign: 'center'},
                    maxWidth: 110,
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'jours abscences',
                },

                {
                    field: "jour_presences",
                    cellStyle: {textAlign: 'center'},
                    maxWidth: 110,
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'jours presences',
                },

                {
                    headerName: "direction",
                    field: "direction_id",
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: (params) => {
                        let retour = "";
                        try {
                            return params.data["direction"]["Selectlabel"];
                        } catch (e) {
                        }
                        return retour;
                    },
                    filter: "CustomFiltre",
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
                {
                    headerName: "fonction",
                    field: "fonction_id",
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: (params) => {
                        let retour = "";
                        try {
                            return params.data["fonction"]["Selectlabel"];
                        } catch (e) {
                        }
                        return retour;
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/fonctions-Aggrid',
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
                    headerName: "nationalite",
                    field: "nationalite_id",
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: (params) => {
                        let retour = "";
                        try {
                            return params.data["nationalite"]["Selectlabel"];
                        } catch (e) {
                        }
                        return retour;
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/nationalites-Aggrid',
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
                    headerName: "sexe",
                    field: "sexe_id",
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: (params) => {
                        let retour = "";
                        try {
                            return params.data["sexe"]["Selectlabel"];
                        } catch (e) {
                        }
                        return retour;
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/sexes-Aggrid',
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
                    maxWidth: 70,
                    headerName: `J${i}`,
                    cellStyle: params => {
                        if (parseInt(params.value) > 0) {
                            return {color: 'white', backgroundColor: 'green', textAlign: 'center'};
                        }
                        return {textAlign: 'center'};
                    }
                };
                columnDefs.push(newChamp);
            }
            return columnDefs;
        },
        extrasData: function () {

            let params = {};
            if (!this.month && !this.poste_id) {
                params["id"] = {values: [0], filterType: "set"};
            } else {
                // params["type_id"] = {values: [2, 3], filterType: "set"};

            }
            this.tableKey++;

            return {
                baseFilter: params,
                month: this.month,
                // poste: this.poste_id,
                // directionselectionner: this.directionselectionner,
                postedebase: this.postedebase,
                // zoneselectionner: this.zoneselectionner,
                type: this.$routeData.meta.statsType
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
        this.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

    },
    beforeMount() {

    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.directionsget = this.$routeData.meta.directionsGet
        this.zonesget = this.$routeData.meta.zonesGet
        this.postedebase = this.params.data.id
        // this.month = this.params.data.calls;
        this.month = this.$routeData.meta.months
        console.log('parentId', this.params.data ? this.params.data : null, this.$routeData.meta)
        // this.getusers();
        // this.getpostes();
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
        getusers() {
            this.axios.get('/api/users').then((response) => {
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
        getpostes() {
            this.axios
                .get("/api/postes")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.postesData = response.data;
                    // console.log('yannfiltreP=>', response.data)
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
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
    }
}
</script>
