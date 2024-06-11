<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Agentsrapports #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Agentsrapports</div>
            </template>

            <EditAgentsrapports v-if="formState == 'Update'" :key="formKey" :data="formData" :gridApi="formGridApi"
                                :modalFormId="formId" :usersData="usersData" @close="closeForm"/>


            <CreateAgentsrapports v-if="formState == 'Create'" :key="formKey" :gridApi="formGridApi"
                                  :modalFormId="formId"
                                  :usersData="usersData" @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData"
                         :rowModelType="rowModelType" :url="url" className="ag-theme-alpine"
                         domLayout='autoHeight' rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>
                    <input v-model="month" class="form-control" placeholder="Veuillez selectioner le mois"
                           style="width: auto !important" type="month"/>
                    <!-- <v-select :options="postesData" v-model="poste_id"/> -->
                    <!-- <div class="row"> -->
                    <div class="col-xxl">
                        <CustomSelect
                            :key="poste_id"
                            :columnDefs="['libelle','site.Selectlabel','site.client.Selectlabel']"
                            :oldValue="poste_id"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>poste_id=data.id"
                            :url="`${axios.defaults.baseURL}/api/postes-Aggrid`"
                            filter-key=""
                            filter-value=""
                        />
                    </div>
                    <!-- </div> -->


                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateAgentsrapports from './CreateAgentsrapports.vue'
import EditAgentsrapports from './EditAgentsrapports.vue'
import DataModal from '@/components/DataModal.vue'
import VSelect from "vue-select";
import CustomSelect from "@/components/CustomSelect.vue";
import CustomFiltre from "@/components/CustomFiltre.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'AgentsrapportsView',
    components: {
        DataTable,
        AgGridTable,
        CreateAgentsrapports,
        EditAgentsrapports,
        DataModal,
        AgGridBtnClicked,
        VSelect,
        CustomFiltre,
        CustomSelect

    },
    props: ['zoneselectionner', 'directionselectionner', 'statsTypes'],
    data() {

        return {
            month: null,
            poste_id: null,
            formId: "agentsrapports",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/agentsrapports-Aggrid',
            table: 'agentsrapports',
            postesData: [],
            directionselectionner: [],
            directionsget: [],
            usersData: [],
            zonesget: [],
            requette: 1,
            // columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
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
            let columnDefs = [];
            if (this.statsTypes == "Retard") {
                columnDefs = [

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
                        field: "retard",
                        maxWidth: 110,
                        sortable: true,
                        // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'jours retard',
                        cellClassRules: {
                            orangeBackground: params => params.value != 0,
                        },
                        cellStyle: params => {
                            if (params.value != 0) {
                                return {color: 'white', backgroundColor: '#ffa700', textAlign: 'center'};
                            }
                            return {textAlign: 'center'};
                        }
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
                    {
                        hide: true,
                        suppressColumnsToolPanel: true,

                        headerName: 'direction',
                        field: 'direction_id',
                        valueFormatter: params => {
                            let retour = ''
                            try {
                                return params.data['direction']['Selectlabel']
                            } catch (e) {

                            }
                            return retour
                        },
                        filter: "FiltreEntete",
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
                ];
                for (let i = 1; i <= 31; i++) {
                    let newChamp = {
                        field: `J${i}`,
                        maxWidth: 110,
                        headerName: `J${i}`,
                        cellClassRules: {
                            orangeBackground: params => params.value != '0H:0M',
                        },
                        cellStyle: params => {
                            if (params.value != '0H:0M') {
                                return {color: 'white', backgroundColor: '#ffa700', textAlign: 'center'};
                            }
                            return {textAlign: 'center'};
                        }
                    };
                    columnDefs.push(newChamp);
                }
            } else if (this.statsTypes == "rapport-totaux") {
                columnDefs = [

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
                        headerName: 'Nom',
                    },
                    {
                        field: "prenom",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'prenom',
                    },
                    {
                        field: "compteurretard",
                        sortable: true,
                        // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'compteur cumul des retard',
                        cellClassRules: {
                            orangeBackground: params => params.value != 0,
                        },
                        cellStyle: params => {
                            if (params.value != 0) {
                                return {color: 'white', backgroundColor: '#ffa700', textAlign: 'center'};
                            }
                            return {textAlign: 'center'};
                        }
                    },
                    {
                        field: "retard",
                        sortable: true,
                        // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'volume cumul retard',
                        cellClassRules: {
                            orangeBackground: params => params.value != "0H:0M",
                        },
                        cellStyle: params => {
                            if (params.value != "0H:0M") {
                                return {color: 'white', backgroundColor: '#ffa700', textAlign: 'center'};
                            }
                            return {textAlign: 'center'};
                        }
                    },
                    {
                        field: "compteurabscence",
                        sortable: true,
                        // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'compteur cumul absence,',
                        cellClassRules: {
                            orangeBackground: params => params.value != 0,
                        },
                        cellStyle: params => {
                            if (params.value != 0) {
                                return {color: 'white', backgroundColor: '#ffa700', textAlign: 'center'};
                            }
                            return {textAlign: 'center'};
                        }
                    },
                    {
                        field: "collecter",
                        sortable: true,
                        // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'volume heure travaillé',
                        cellClassRules: {
                            orangeBackground: params => params.value != "0H:0M",
                        },
                        cellStyle: params => {
                            if (params.value != "0H:0M") {
                                return {color: 'white', backgroundColor: '#ffa700', textAlign: 'center'};
                            }
                            return {textAlign: 'center'};
                        }
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
                    {
                        hide: true,
                        suppressColumnsToolPanel: true,

                        headerName: 'direction',
                        field: 'direction_id',
                        valueFormatter: params => {
                            let retour = ''
                            try {
                                return params.data['direction']['Selectlabel']
                            } catch (e) {

                            }
                            return retour
                        },
                        filter: "FiltreEntete",
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
                ];
            } else {
                columnDefs = [

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
                        cellStyle: params => {
                            return {color: 'white', backgroundColor: '#c0c0c0', textAlign: 'center'};
                        },
                        maxWidth: 110,
                        sortable: true,
                        // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'jours abscences',
                    },

                    {
                        field: "jour_presences",
                        cellStyle: params => {
                            return {color: 'white', backgroundColor: '#c0c0c0', textAlign: 'center'};
                        },
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
                    {
                        hide: true,
                        suppressColumnsToolPanel: true,

                        headerName: 'direction',
                        field: 'direction_id',
                        valueFormatter: params => {
                            let retour = ''
                            try {
                                return params.data['direction']['Selectlabel']
                            } catch (e) {

                            }
                            return retour
                        },
                        filter: "FiltreEntete",
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
            if (!this.statsTypes) {
                this.statsTypes = this.$routeData.meta.statsType;

            }
            return {
                baseFilter: params,
                month: this.month,
                poste: this.poste_id,
                directionselectionner: this.directionselectionner,
                zoneselectionner: this.zoneselectionner,
                type: this.statsTypes
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
        console.log('this.zonesget', this.$routeData.meta.statsType);
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
