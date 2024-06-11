<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">
                    Update Agents #{{ formData.id }}
                </div>
                <div v-if="formState == 'Create'">Create Agents</div>
                <div v-if="formState == 'Pointages'">
                    Details de pointages de l'agent
                </div>
            </template>

            <EditAgents v-if="formState == 'Update'" :key="formKey" :actifsData="actifsData" :balisesData="balisesData"
                        :categoriesData="categoriesData" :champsAfficher="champsAfficher" :contratsData="contratsData"
                        :data="formData" :directionsData="directionsData" :echelonsData="echelonsData"
                        :factionsData="factionsData" :fonctionsData="fonctionsData" :gridApi="formGridApi"
                        :matrimonialesData="matrimonialesData" :modalFormId="formId"
                        :nationalitesData="nationalitesData"
                        :onlinesData="onlinesData" :postesData="postesData" :sexesData="sexesData"
                        :sitesData="sitesData"
                        :situationsData="situationsData" :typesData="typesData" :usersData="usersData"
                        :villesData="villesData"
                        :zonesData="zonesData" @close="closeForm"/>

            <CreateAgents v-if="formState == 'Create'" :key="formKey" :actifsData="actifsData"
                          :balisesData="balisesData"
                          :categoriesData="categoriesData" :champsAfficher="champsAfficher" :contratsData="contratsData"
                          :directionsData="directionsData" :echelonsData="echelonsData" :factionsData="factionsData"
                          :fonctionsData="fonctionsData" :gridApi="formGridApi" :matrimonialesData="matrimonialesData"
                          :modalFormId="formId" :nationalitesData="nationalitesData"
                          :onlinesData="onlinesData"
                          :postesData="postesData" :sexesData="sexesData" :sitesData="sitesData"
                          :situationsData="situationsData"
                          :typesData="typesData" :usersData="usersData" :villesData="villesData" :zonesData="zonesData"
                          @close="closeForm"/>

            <CreateImports v-if="formState == 'Import'" :key="formKey" :data="formData" :gridApi="formGridApi"
                           :modalFormId="formId" @close="closeForm"/>

            <Pointageagents v-if="formState == 'Pointages'" :key="formKey" :data="formData"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache"
                         :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData" :rowModelType="rowModelType"
                         :url="url"
                         className="ag-theme-alpine"
                         domLayout="autoHeight" rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>
                    <div v-if="!$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate">
                        <i class="fa fa-plus"></i>
                        Ajouter un agent
                    </div>
                    <!-- <div class="btn btn-primary" @click="openImport">
                        <i class="fa fa-plus"></i>
                        Importer des agents a partir d'un fichier excel
                    </div> -->
                </template>
            </AgGridTable>
        </div>
    </div>
</template>

<script>
import DataTable from "@/components/DataTable.vue";
import AgGridTable from "@/components/AgGridTable.vue";
import CreateAgents from "./CreateAgents.vue";
import EditAgents from "./EditAgents.vue";
import DataModal from "@/components/DataModal.vue";
import CustomFiltre from "@/components/CustomFiltre.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import CreateImports from "../Imports/CreateImports.vue";
import Pointageagents from "./Pointageagents.vue";
import CustomSelect from "@/components/CustomSelect.vue";
import moment from "moment";

export default {
    name: "AgentsView",
    components: {
        DataTable,
        AgGridTable,
        CreateAgents,
        EditAgents,
        DataModal,
        AgGridBtnClicked,
        CustomFiltre,
        Pointageagents,
        CreateImports,
        CustomSelect
    },
    data() {
        return {
            importParams: {
                type: "agents",
                allChamps: [
                    "nom",
                    "prenom",
                    "matricule",
                    "naissance",
                    "embauche",
                    "badge",
                    "cnamgs",
                    "cnss",
                    "code nationalite",
                    "nationalite",
                    "code fonction",
                    "fonction",
                    "code direction",
                    "direction",
                    "code echelon",
                    "echelon",
                    "code categorie",
                    "categorie",
                    "code contrat",
                    "contrat",
                ],
            },
            test: "users",
            formId: "users",
            formState: "",
            formData: {},
            formWidth: "xl",
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: "http://127.0.0.1:8000/api/users-Aggrid",
            table: "users",
            actifsData: [],
            balisesData: [],
            categoriesData: [],
            contratsData: [],
            directionsget: [],
            zonesget: [],
            directionsData: [],
            echelonsData: [],
            factionsData: [],
            fonctionsData: [],
            matrimonialesData: [],
            nationalitesData: [],
            onlinesData: [],
            postesData: [],
            sexesData: [],
            directionselectionner: [],
            sitesData: [],
            situationsData: [],
            zoneselectionner: [],
            typesData: [],
            usersData: [],
            villesData: [],
            typesget: [],
            typeselectionner: [],
            zonesData: [],
            requette: 19,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            champsAfficher: [
                //LISTE DES CHAMP à MASQUER
            ],
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
        extrasData: function () {


            this.tableKey++;

            return {
                zoneselectionner: this.zoneselectionner,
                typeselectionner: this.typeselectionner,
                directionselectionner: this.directionselectionner,
            };

        },
    },
    watch: {
        $route: {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null);
                this.gridApi.refreshServerSide();
                this.getcontrats();
                this.tableKey++;
            },
            deep: true,
        },
    },
    created() {
        this.url = this.axios.defaults.baseURL + "/api/users-Aggrid"
        // this.url = 'http://127.0.0.1:8000/users-Aggrid'
        // this.url = "http://127.0.0.1:8000/users-Aggrid"
        this.formId = this.table + "_" + Date.now();
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        console.log('this.zonesget', this.rowData)
// this.champsAfficher = JSON.parse(this.$routeData.meta.champsHide)


        this.champsAfficher = [
            //LISTE DES CHAMP à MASQUER POUR sgs
            "emp_code",
            "service",
            "telephone1",
            "nombre_enfant",
            "balise_id",
            "categorie_id",
            "contrat_id",
            "echelon_id",
            "faction_id",
            "matrimoniale_id",
            "poste_id",
            "situation_id",
            "ville_id",
            "zone_id",
            //    "date_naissance",
            "num_cnss",
            "num_cnamgs",
            "nationalite_id",
            "sexe_id",
        ];
    },
    beforeMount() {
        // if (this.$routeData.meta.domain != 'sgs') {
        //     this.columnDefs = [
        //         {
        //             field: null,
        //             headerName: "",
        //             suppressCellSelection: true,
        //             minWidth: 80,maxWidth: 80,
        //             pinned: "left",
        //             cellRendererSelector: (params) => {
        //                 return {
        //                     component: "AgGridBtnClicked",
        //                     params: {
        //                         clicked: (field) => {
        //                             this.showForm("Update", field, params.api);
        //                         },
        //                         render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
        //                     },
        //                 };
        //             },
        //         },

        //         {
        //             field: "nom",
        //             sortable: true,
        //             filter: "agTextColumnFilter",
        //             filterParams: { suppressAndOrCondition: true },
        //             headerName: "nom",
        //             hide: this.isShow("nom"),
        //         },

        //         {
        //             field: "prenom",
        //             sortable: true,
        //             filter: "agTextColumnFilter",
        //             filterParams: { suppressAndOrCondition: true },
        //             headerName: "prenom",
        //             hide: this.isShow("prenom"),
        //         },

        //         {
        //             field: "matricule",
        //             sortable: true,
        //             filter: "agTextColumnFilter",
        //             filterParams: { suppressAndOrCondition: true },
        //             headerName: "matricule",
        //             hide: this.isShow("matricule"),
        //         },

        //         {
        //             field: "num_badge",
        //             sortable: true,
        //             filter: "agTextColumnFilter",
        //             filterParams: { suppressAndOrCondition: true },
        //             headerName: "badge",
        //             hide: this.isShow("num_badge"),
        //         },

        //         {
        //             field: "date_naissance",
        //             sortable: true,
        //             filter: "agTextColumnFilter",
        //             filterParams: { suppressAndOrCondition: true },
        //             headerName: "date de naissance",
        //             hide: this.isShow("date_naissance"),
        //             valueFormatter: (params) => {
        //                 let retour = params.value;
        //                 try {
        //                     retour = params.value.split(" ")[0];
        //                 } catch (e) {}
        //                 return retour;
        //             },
        //         },

        //         {
        //             field: "telephone1",
        //             sortable: true,
        //             filter: "agTextColumnFilter",
        //             filterParams: { suppressAndOrCondition: true },
        //             headerName: "telephone",
        //             hide: this.isShow("telephone1"),
        //         },


        //         {
        //             headerName: "direction",
        //             field: "direction.Selectlabel",
        //             hide: this.isShow("direction_id"),
        //         },
        //         {
        //             headerName: "direction",
        //             field: "direction_id",
        //             hide: true,
        //             suppressColumnsToolPanel: true,
        //             valueFormatter: (params) => {
        //                 let retour = "";
        //                 try {
        //                     return params.data["direction"]["Selectlabel"];
        //                 } catch (e) {}
        //                 return retour;
        //             },

        //             filter: "agSetColumnFilter",
        //             filterParams: {
        //                 suppressAndOrCondition: true,
        //                 keyCreator: (params) => params.value.id,
        //                 valueFormatter: (params) => params.value.Selectlabel,
        //                 values: (params) => {
        //                     params.success(this.directionsData);
        //                 },
        //                 refreshValuesOnOpen: true,
        //             },
        //         },


        //         {
        //             headerName: "fonction",
        //             field: "fonction.Selectlabel",
        //             hide: this.isShow("fonction_id"),
        //         },
        //         {
        //             headerName: "fonction",
        //             field: "fonction_id",
        //             hide: true,
        //             suppressColumnsToolPanel: true,
        //             valueFormatter: (params) => {
        //                 let retour = "";
        //                 try {
        //                     return params.data["fonction"]["Selectlabel"];
        //                 } catch (e) {}
        //                 return retour;
        //             },

        //             filter: "agSetColumnFilter",
        //             filterParams: {
        //                 suppressAndOrCondition: true,
        //                 keyCreator: (params) => params.value.id,
        //                 valueFormatter: (params) => params.value.Selectlabel,
        //                 values: (params) => {
        //                     params.success(this.fonctionsData);
        //                 },
        //                 refreshValuesOnOpen: true,
        //             },
        //         },


        //         {
        //             headerName: "nationalite",
        //             field: "nationalite.Selectlabel",
        //             hide: this.isShow("nationalite_id"),
        //         },
        //         {
        //             headerName: "nationalite",
        //             field: "nationalite_id",
        //             hide: true,
        //             suppressColumnsToolPanel: true,
        //             valueFormatter: (params) => {
        //                 let retour = "";
        //                 try {
        //                     return params.data["nationalite"]["Selectlabel"];
        //                 } catch (e) {}
        //                 return retour;
        //             },

        //             filter: "agSetColumnFilter",
        //             filterParams: {
        //                 suppressAndOrCondition: true,
        //                 keyCreator: (params) => params.value.id,
        //                 valueFormatter: (params) => params.value.Selectlabel,
        //                 values: (params) => {
        //                     params.success(this.nationalitesData);
        //                 },
        //                 refreshValuesOnOpen: true,
        //             },
        //         },


        //         {
        //             headerName: "sexe",
        //             field: "sexe.Selectlabel",
        //             hide: this.isShow("sexe_id"),
        //         },
        //         {
        //             headerName: "sexe",
        //             field: "sexe_id",
        //             hide: true,
        //             suppressColumnsToolPanel: true,
        //             valueFormatter: (params) => {
        //                 let retour = "";
        //                 try {
        //                     return params.data["sexe"]["Selectlabel"];
        //                 } catch (e) {}
        //                 return retour;
        //             },

        //             filter: "agSetColumnFilter",
        //             filterParams: {
        //                 suppressAndOrCondition: true,
        //                 keyCreator: (params) => params.value.id,
        //                 valueFormatter: (params) => params.value.Selectlabel,
        //                 values: (params) => {
        //                     params.success(this.sexesData);
        //                 },
        //                 refreshValuesOnOpen: true,
        //             },
        //         },

        //     ];
        // } else {
        this.columnDefs = [
            {
                field: null,
                headerName: "",
                suppressCellSelection: true,
                minWidth: 80, maxWidth: 80,
                pinned: "left",
                cellRendererSelector: (params) => {
                    return {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.showForm("Update", field, params.api);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                        },
                    };
                },
            },

            // {
            //   field: "name",
            //   sortable: true,
            //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            //   headerName: 'name',
            // },

            {
                field: "nom",
                sortable: true,
                filter: this.havefilter("nom"),
                filterParams: {suppressAndOrCondition: true},
                headerName: "nom",
                hide: this.isShow("nom"),
                suppressColumnsToolPanel: this.isShow("nom"),
            },

            {
                field: "prenom",
                sortable: true,
                filter: this.havefilter("prenom"),
                filterParams: {suppressAndOrCondition: true},
                headerName: "prenom",
                hide: this.isShow("prenom"),
                suppressColumnsToolPanel: this.isShow("prenom"),
            },

            {
                field: "matricule",
                sortable: true,
                filter: this.havefilter("matricule"),
                filterParams: {suppressAndOrCondition: true},
                headerName: "matricule",
                hide: this.isShow("matricule"),
                suppressColumnsToolPanel: this.isShow("matricule"),
            },

            {
                field: "num_badge",
                sortable: true,
                filter: this.havefilter("num_badge"),
                filterParams: {suppressAndOrCondition: true},
                headerName: "badge",
                hide: this.isShow("num_badge"),
                suppressColumnsToolPanel: this.isShow("num_badge"),
            },
            {
                hide: true,
                suppressColumnsToolPanel: this.isShow("client_id"),

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
                field: "date_naissance",
                sortable: true,
                filter: this.havefilter("date_naissance"),
                filterParams: {suppressAndOrCondition: true},
                headerName: "date de naissance",
                hide: this.isShow("date_naissance"),
                valueFormatter: (params) => {
                    let retour = params.value;
                    try {
                        retour = params.value.split(" ")[0];
                    } catch (e) {
                    }
                    return retour;
                },
                suppressColumnsToolPanel: this.isShow("date_naissance"),
            },

            {
                field: "num_cnss",
                sortable: true,
                filter: this.havefilter("num_cnss"),
                filterParams: {suppressAndOrCondition: true},
                headerName: "cnss",
                hide: this.isShow("num_cnss"),
                suppressColumnsToolPanel: this.isShow("num_cnss"),
            },

            {
                field: "num_cnamgs",
                sortable: true,
                filter: this.havefilter("num_cnamgs"),
                filterParams: {suppressAndOrCondition: true},
                headerName: "cnamgs",
                hide: this.isShow("num_cnamgs"),
                suppressColumnsToolPanel: this.isShow("num_cnamgs"),
            },

            {
                field: "telephone1",
                sortable: true,
                filter: this.havefilter("telephone1"),
                filterParams: {suppressAndOrCondition: true},
                headerName: "telephone",
                hide: this.isShow("telephone1"),
                suppressColumnsToolPanel: this.isShow("telephone1"),

            },

            {
                field: "nombre_enfant",
                sortable: true,
                filter: this.havefilter("nombre_enfant"),
                filterParams: {suppressAndOrCondition: true},
                headerName: "nombre_enfant",
                hide: this.isShow("nombre_enfant"),
                suppressColumnsToolPanel: this.isShow("nombre_enfant"),
            },

            {
                headerName: "balise",
                field: "balise.Selectlabel",
                hide: this.isShow("balise_id"),
                suppressColumnsToolPanel: this.isShow("balise_id"),
            },
            {
                headerName: "balise",
                field: "balise_id",

                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["balise"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("balise_id"),
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/balises-Aggrid',
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
                headerName: "categorie",
                field: "categorie.Selectlabel",
                hide: this.isShow("categorie_id"),
                suppressColumnsToolPanel: this.isShow("categorie_id"),
            },
            {
                headerName: "categorie",
                field: "categorie_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["categorie"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("categorie_id"),
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
                                    return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
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
                headerName: "contrat",
                field: "contrat.Selectlabel",
                hide: this.isShow("contrat_id"),
                suppressColumnsToolPanel: this.isShow("contrat_id"),
            },
            {
                headerName: "contrat",
                field: "contrat_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["contrat"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("contrat_id"),
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/contrats-Aggrid',
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

                headerName: 'type',
                field: 'typeseffectif_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['typeseffectif']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },
                filter: "FiltreEntete",
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/typeseffectifs-Aggrid',
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
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: 'situations',
                field: 'typesagentshoraires',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['typesagentshoraire']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },
                filter: "FiltreEntete",
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/typesagentshoraires-Aggrid',
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
                headerName: "service",
                field: "fonction.service.Selectlabel",
                hide: this.isShow("service"),
                suppressColumnsToolPanel: this.isShow("service"),
            },
            {
                headerName: "service",
                field: "service",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["services"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("service"),
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/services-Aggrid',
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
                headerName: "direction",
                field: "direction.Selectlabel",
                hide: this.isShow("direction_id"),
                suppressColumnsToolPanel: this.isShow("direction_id"),
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
                filter: this.havecustomfilter("direction_id"),
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
                headerName: "echelon",
                field: "echelon.Selectlabel",
                hide: this.isShow("echelon_id"),
                suppressColumnsToolPanel: this.isShow("echelon_id"),
            },
            {
                headerName: "echelon",
                field: "echelon_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["echelon"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("echelon_id"),
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/echelons-Aggrid',
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
                headerName: "faction",
                field: "faction.Selectlabel",
                hide: this.isShow("faction_id"),
                suppressColumnsToolPanel: this.isShow("faction_id"),
            },
            {
                headerName: "faction",
                field: "faction_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["faction"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("faction_id"),
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/factions-Aggrid',
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
                field: "fonction.Selectlabel",
                hide: this.isShow("fonction_id"),
                suppressColumnsToolPanel: this.isShow("fonction_id"),
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
                filter: this.havecustomfilter("fonction_id"),
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
                headerName: "matrimoniale",
                field: "matrimoniale.Selectlabel",
                hide: this.isShow("matrimoniale_id"),
                suppressColumnsToolPanel: this.isShow("matrimoniale_id"),
            },
            {
                headerName: "matrimoniale",
                field: "matrimoniale_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["matrimoniale"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("matrimoniale_id"),
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/matrimoniales-Aggrid',
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
                field: "nationalite.Selectlabel",
                hide: this.isShow("nationalite_id"),
                suppressColumnsToolPanel: this.isShow("nationalite_id"),
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
                filter: this.havecustomfilter("nationalite_id"),
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
                headerName: "poste",
                field: "poste.Selectlabel",
                hide: this.isShow("poste_id"),
                suppressColumnsToolPanel: this.isShow("poste_id"),
            },
            {
                headerName: "poste",
                field: "poste_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["poste"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("poste_id"),
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/postes-Aggrid',
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
                field: "sexe.Selectlabel",
                hide: this.isShow("sexe_id"),
                suppressColumnsToolPanel: this.isShow("sexe_id"),
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
                filter: this.havecustomfilter("sexe_id"),
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

            // {
            //   headerName: 'site',
            //   field: 'site.Selectlabel',
            // },
            // {

            //   headerName: 'site',
            //   field: 'site_id',
            //   hide: true,
            //   suppressColumnsToolPanel: true,
            //   valueFormatter: params => {
            //     let retour = ''
            //     try {
            //       return params.data['site']['Selectlabel']
            //     } catch (e) {

            //     }
            //     return retour
            //   },
            //   filter: "CustomFiltre",
            //     filterParams: {
            //         url: this.axios.defaults.baseURL + '/api/sites-Aggrid',
            //         columnDefs: [
            //             {
            //                 field: "",
            //                 sortable: true,
            //                 filter: "agTextColumnFilter",
            //                 filterParams: {suppressAndOrCondition: true},
            //                 headerName: "",
            //                 cellStyle: {fontSize: '11px'},
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

            {
                headerName: "situation",
                field: "situation.Selectlabel",
                hide: this.isShow("situation_id"),
                suppressColumnsToolPanel: this.isShow("situation_id"),
            },
            {
                headerName: "situation",
                field: "situation_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["situation"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("situation_id"),
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/situations-Aggrid',
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
                headerName: "ville",
                field: "ville.Selectlabel",
                hide: this.isShow("ville_id"),
                suppressColumnsToolPanel: this.isShow("ville_id"),
            },
            {
                headerName: "ville",
                field: "ville_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["ville"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("ville_id"),
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/villes-Aggrid',
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
                headerName: "zone",
                field: "zone.Selectlabel",
                hide: this.isShow("zone_id"),
                suppressColumnsToolPanel: this.isShow("zone_id"),
            },
            {
                headerName: "zone",
                field: "zone_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["zone"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },
                filter: this.havecustomfilter("zone_id"),
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
                field: "created_at",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'Créer le',
                valueFormatter: params => {
                    let retour = params.value
                    try {
                        if (retour) {
                            retour = moment(params.value).format('DD/MM/YYYY à HH:mm')

                        } else {
                            retour = 'Date inconnue'
                        }
                    } catch (e) {

                    }
                    return retour
                }
            },
        ];
        if (this.$routeData.meta.isOne) {
            this.importParams["type"] = "agents-one";
        }
        // }
    },
    mounted() {


        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.typesget = this.$routeData.meta.typesGet
        console.log('voila le windows', window)
        window.Echo
            .channel('user-channel')
            .listen('SendMessage', (data) => {
                console.log('nouvelle evenements')
            });
        this.directionsget = this.$routeData.meta.directionsGet
        // this.zonesget = this.$routeData.meta.champsHide
// console.log('this.zonesget',this.zonesget);

        // this.getactifs();
        // this.getbalises();
        // this.getcategories();
        // this.getcontrats();
        // this.getdirections();
        // this.getechelons();
        // this.getfactions();
        // this.getfonctions();
        // this.getmatrimoniales();
        // this.getnationalites();
        // this.getonlines();
        // this.getpostes();
        // this.getsexes();
        // this.getsites();
        // this.getusers();
        // this.getsituations();
        // this.gettypes();
        // this.getvilles();
        // this.getzones();
        console.log('this.champsAfficher =', this.champsAfficher)

    },
    methods: {
        isShow(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            return this.champsAfficher.includes(fieldName); // si le champ existe return prend la valeur *true*
        },
        havefilter(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            if (this.champsAfficher.includes(fieldName)) {
                return null
            } else {
                return "agTextColumnFilter"
            }
        },
        havecustomfilter(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            if (this.champsAfficher.includes(fieldName)) {
                return null
            } else {
                return "CustomFiltre"
            }
        },
        openCreate() {
            this.showForm("Create", {}, this.gridApi);
        },
        openImport() {
            this.showForm("Import", this.importParams, this.gridApi, "lg");
        },
        closeForm() {
            this.tableKey++;
        },
        showForm(type, data, gridApi, width = "xl") {
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
        getactifs() {
            this.axios
                .get("/api/actifs")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.actifsData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getbalises() {
            this.axios
                .get("/api/balises")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.balisesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getcategories() {
            this.axios
                .get("/api/categories")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.categoriesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getcontrats() {
            if (this.$routeData.meta.isOne) {
                // console.log('one')
                this.axios
                    .get("/api/contrats/typeView/one")
                    .then((response) => {
                        this.requette--;
                        if (this.requette == 0) {
                            // // this.$store.commit('setIsLoading', false)
                        }
                        this.contratsData = response.data;
                    })
                    .catch((error) => {
                        console.log(error.response.data);
                        // // this.$store.commit('setIsLoading', false)
                        this.$toast.error(
                            "Erreur survenue lors de la récuperation"
                        );
                    });
            } else {
                // console.log('!one')
                this.axios
                    .get("/api/contrats/typeView/sgs")
                    .then((response) => {
                        this.requette--;
                        if (this.requette == 0) {
                            // // this.$store.commit('setIsLoading', false)
                        }
                        this.contratsData = response.data;
                    })
                    .catch((error) => {
                        console.log(error.response.data);
                        // // this.$store.commit('setIsLoading', false)
                        this.$toast.error(
                            "Erreur survenue lors de la récuperation"
                        );
                    });
            }
        },

        getdirections() {
            this.axios
                .get("/api/directions")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.directionsData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getechelons() {
            this.axios
                .get("/api/echelons")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.echelonsData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
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
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.factionsData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
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
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.fonctionsData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getmatrimoniales() {
            this.axios
                .get("/api/matrimoniales")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.matrimonialesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getnationalites() {
            this.axios
                .get("/api/nationalites")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.nationalitesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getonlines() {
            this.axios
                .get("/api/onlines")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.onlinesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
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

        getsexes() {
            this.axios
                .get("/api/sexes")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.sexesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        // getsites() {
        //   this.axios.get('/api/sites').then((response) => {
        //     this.requette--
        //     if (this.requette == 0) {
        //       // // this.$store.commit('setIsLoading', false)
        //     }
        //     this.sitesData = response.data

        //   }).catch(error => {
        //     console.log(error.response.data)
        //     // // this.$store.commit('setIsLoading', false)
        //     this.$toast.error('Erreur survenue lors de la récuperation')
        //   })
        // },

        getsites() {
            this.axios
                .get("/api/sites")
                .then((response) => {
                    // console.log('yannfiltre=>',response.data)
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    // console.log('yannfiltre=>', response.data)
                    this.sitesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getsituations() {
            this.axios
                .get("/api/situations")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.situationsData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        gettypes() {
            this.axios
                .get("/api/types")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.typesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        getusers() {
            this.axios
                .get("/api/users?filter[actif_id]=1&filter[type_id]=2")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    // this.usersData = response.data
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
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
                        // // this.$store.commit('setIsLoading', false)
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
            this.extrasData1.zoneselectionner = this.zoneselectionner

            // console.log('this.zoneselectionner', this.zoneselectionner)
        },
        typeselect(type) {
            if (this.typeselectionner.includes(type)) {
                // type is already selected, so we want to deselect it
                const index = this.typeselectionner.indexOf(type);
                if (index !== -1) {
                    this.typeselectionner.splice(index, 1); // Remove the zone from the array
                }
            } else {
                // type is not selected, so we want to select it
                this.typeselectionner.push(type);
            }

        },
    },
};
</script>
