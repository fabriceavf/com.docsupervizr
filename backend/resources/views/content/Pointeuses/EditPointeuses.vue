<template>
    <b-overlay :show="isLoading">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Create'">Ajouter des postes</div>
            </template>

            <div v-if="formState == 'Create'">
                <AgGridSearch
                    :columnDefs="add.columnDefs"
                    :filterFields="['code', 'libelle']"
                    :url="add.url"
                    @destruction="finishAddPoste"
                >
                </AgGridSearch>
            </div>

            <template #modal-footer>
                <div></div>
                <button
                    v-if="formState == 'Create'"
                    class="btn btn-primary"
                    type="button"
                    @click.prevent="finishAddPoste()"
                >
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
            </template>
        </b-modal>
        <form @submit.prevent="EditLine()">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>code_teleric </label>
                            <input
                                v-model="form.code_teleric"
                                :class="
                                    errors.code_teleric
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                                type="text"
                            />

                            <div v-if="errors.code_teleric" class="invalid-feedback">
                                <template v-for="error in errors.code_teleric">
                                    {{ error[0] }}
                                </template
                                >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>code </label>
                            <input
                                v-model="form.code"
                                :class="
                                    errors.code
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                                type="text"
                            />

                            <div v-if="errors.code" class="invalid-feedback">
                                <template v-for="error in errors.code">
                                    {{ error[0] }}
                                </template
                                >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>libelle </label>
                            <input
                                v-model="form.libelle"
                                :class="
                                    errors.libelle
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                                type="text"
                            />

                            <div v-if="errors.libelle" class="invalid-feedback">
                                <template v-for="error in errors.libelle">
                                    {{ error[0] }}
                                </template
                                >
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-sm-6">
                        <div class="form-group">
                            <label>sites </label>
                            <CustomSelect
                                :key="form.site"
                                :url="`${axios.defaults.baseURL}/api/sites-Aggrid`"
                                :columnDefs="['libelle','client.Selectlabel']"
                                filter-key=""
                                filter-value=""
                                :oldValue="form.site"
                                :renderCallBack="(data)=>`${data.Selectlabel}`"
                                :selectCallBack="(data)=>{form.site_id=data.id;form.site=data}"
                            />
                            <div class="invalid-feedback" v-if="errors.site_id">
                                <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div> -->

                </div>
                <!-- <div class="row">

                    <div class="col-sm">
                        <div class="form-group">
                            <label>sites </label>
                            <CustomSelect
                                :key="form.site"
                                :columnDefs="['libelle']"
                                :oldValue="form.site"
                                :renderCallBack="(data)=>`${data.Selectlabel}`"
                                :selectCallBack="(data)=>{form.site_id=data.id;form.site=data}"
                                :url="`${axios.defaults.baseURL}/api/sitesglobal-Aggrid`"
                                filter-key=""
                                filter-value=""
                            />
                            <div v-if="errors.site_id" class="invalid-feedback">
                                <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>

                </div> -->
            </div>
            <div class="col-sm-12 card">
                <div class="card-body allBoutons">
                    <button v-b-tooltip.hover :style="actualPage == 'Postes' ? 'border: 3px solid  green' : ''"
                            class="btn" style="" @click.prevent="togglePage('Postes')">
                        <div class="iconParent">
                                <span> <i class="fa-solid fa-filter"></i> Postes
                                </span>
                        </div>
                    </button>
                    <button v-b-tooltip.hover :style="actualPage == 'Sites' ? 'border: 3px solid  green' : ''"
                            class="btn" style="" @click.prevent="togglePage('Sites')">
                        <div class="iconParent">
                                <span> <i class="fa-solid fa-filter"></i> Sites
                                </span>
                        </div>
                    </button>
                </div>
            </div>
            <div v-if="actualPage == 'Postes'" class="col-sm-12">
                <div class="form-group">
                    <label>Postes</label>
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
                            :show-pagination="false"
                            :url="url"
                            className="ag-theme-alpine"
                            dom-layout="normal"
                            domLayout="autoHeight"
                            rowSelection="multiple"
                            @gridReady="onGridReady"
                            @newData="newData"
                        >
                            <template #header_buttons>
                                <div
                                    class="btn btn-primary"
                                    @click="openCreate"
                                >
                                    <i class="fa fa-plus"></i> Ajouter des
                                    postes
                                </div>
                            </template>
                        </AgGridTable>
                    </div>
                </div>
            </div>
            <div v-if="actualPage == 'Sites'" class="col-sm-12">
                <SitesPointeuses :pointeuse-select="form.id" @siteId="siteIds"/>
            </div>
            <div class="blockPointages">

                <template>
                    <button v-if="!historique" class="btn btn-secondary" type="button" @click="readhistorique"><i
                        class="fa-solid fa-clipboard-check"></i> Historique Postes
                    </button>
                    <button v-if="historique" class="btn btn-danger" type="button" @click="fermerhistorique"><i
                        class="fas fa-close"></i> Close
                    </button>
                </template>
            </div>
            <historiqueposte v-if="historique===1" :key="form.id" :Type="historiquetype"
                             :pointeuse-select="form.id"/>

            <div class="d-flex justify-content-between mt-2">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button
                    class="btn btn-danger"
                    type="button"
                    @click.prevent="DeleteLine()"
                >
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import AgGridSearch from "@/components/AgGridSearch.vue";
import Files from "@/components/Files.vue";
import VSelect from "vue-select";
import historiqueposte from "./historiquepostes.vue";

import AgGridTable from "@/components/AgGridTable.vue";
import CreatePointeuses from "./CreatePointeuses.vue";
import SitesPointeuses from "./SitesPointeuses.vue";


export default {
    name: "EditPointeuses",
    components: {
        CreatePointeuses,
        VSelect,
        SitesPointeuses,
        CustomSelect,
        Files,
        AgGridTable,
        AgGridSearch,
        historiqueposte
    },
    props: ["data", "gridApi", "modalFormId", "recuperesData"],
    data() {
        return {
            errors: [],
            isLoading: false,
            historique: 0,
            historiquetype: false,
            form: {
                id: "",

                code: "",
                code_teleric: "",

                libelle: "",

                recupere_id: "",

                created_at: "",

                updated_at: "",

                findId: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",
            },
            formId: "users",
            formState: "",
            formData: {},
            formWidth: "lg",
            formGridApi: {},
            formKey: 0,
            actualPage: '',
            tableKey: 0,
            url: "http://127.0.0.1:8000/api/postes-Aggrid",
            table: "users",
            requette: 9,
            columnDefs: null,
            rowData: null,
            gridApi1: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 20,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            agGridData: {},
            dateSelect: [],
            posteSelect: [],
            lastPosteSelectCount: 0,
            read: false,
            add: {
                formId: "listings",
                formState: "",
                formData: {},
                formWidth: "lg",
                formGridApi: {},
                formKey: 0,
                tableKey: 0,
                url: "http://127.0.0.1:8000/api/listings-Aggrid",
                table: "Users",
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
                contratsclientsData: [],
                clientsData: [],
                zonesData: [],
                pointeusesData: [],
                sitesData: [],
            },
        };
    },
    created() {
        (this.url = this.axios.defaults.baseURL + "/api/postes-Aggrid"),
            (this.formId = this.table + "_" + Date.now());
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        let params = {};
        // params['type_id'] = {values: [2, 3], filterType: 'set'}
        // this.extrasData['baseFilter'] = params
        // this.extrasData['selectAllQuery'] = 1

        (this.add.url = this.axios.defaults.baseURL + "/api/postes-Aggrid"),
            (this.add.rowBuffer = 0);
        this.add.rowModelType = "serverSide";
        this.add.cacheBlockSize = 50;
        this.add.maxBlocksInCache = 2;
    },
    computed: {
        extrasData: function () {
            let params = {baseFilter: {}};
            params["baseFilter"]["id"] = {
                values: this.posteSelect,
                filterType: "set",
            };
            return params;
        },
        posteUrl: function () {
            return this.axios.defaults.baseURL + "/api/postes-Aggrid/";
        },
    },
    beforeMount() {
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
                                this.deletePoste(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`,
                        },
                    };
                },
            },

            {
                field: "code",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "code",
            },

            {
                field: "libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "libelle",
            },

            {
                headerName: "contrats",
                field: "contratsclient.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "contratsclient",
                field: "contratsclient_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["contratsclient"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.libelle,
                    values: (params) => {
                        params.success(this.contratsclientsData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                headerName: "client",
                field: "site.client.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "client",
                field: "client_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["client"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.Selectlabel,
                    values: (params) => {
                        params.success(this.clientsData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                headerName: "site",
                field: "site.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "site",
                field: "site_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["site"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.Selectlabel,
                    values: (params) => {
                        params.success(this.sitesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                field: "jours",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "jours couverts",
            },
            {
                field: "maxjours",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Agents Jours",
            },
            {
                field: "maxnuits",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Agents Nuits",
            },

            {
                headerName: "zone",
                field: "site.zone.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "zone",
                field: "zone_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["zone"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.Selectlabel,
                    values: (params) => {
                        params.success(this.zonesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                headerName: "pointeuse",
                field: "pointeuse.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "pointeuse",
                field: "pointeuse_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["pointeuse"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.Selectlabel,
                    values: (params) => {
                        params.success(this.pointeusesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },
        ];
        this.add.columnDefs = [
            {
                field: null,

                width: 100,
                pinned: "left",
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: "",
                cellRendererSelector: (params) => {
                    let response = {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.addPoste(field);
                            },

                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                        },
                    };
                    return response;
                },
            },

            {
                field: "code",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "code",
            },

            {
                field: "libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "libelle",
            },

            {
                headerName: "contrats",
                field: "contratsclient.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "contratsclient",
                field: "contratsclient_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["contratsclient"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.libelle,
                    values: (params) => {
                        params.success(this.contratsclientsData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                headerName: "client",
                field: "site.client.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "client",
                field: "client_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["client"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.Selectlabel,
                    values: (params) => {
                        params.success(this.clientsData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                headerName: "site",
                field: "site.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "site",
                field: "site_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["site"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.Selectlabel,
                    values: (params) => {
                        params.success(this.sitesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                field: "jours",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "jours couverts",
            },
            {
                field: "maxjours",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Agents Jours",
            },
            {
                field: "maxnuits",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Agents Nuits",
            },

            {
                headerName: "zone",
                field: "site.zone.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "zone",
                field: "zone_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["zone"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.Selectlabel,
                    values: (params) => {
                        params.success(this.zonesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                headerName: "pointeuse",
                field: "pointeuse.Selectlabel",
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "pointeuse",
                field: "pointeuse_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["pointeuse"]["Selectlabel"];
                    } catch (e) {
                    }
                    return retour;
                },

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.Selectlabel,
                    values: (params) => {
                        params.success(this.pointeusesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },
        ];
    },

    mounted() {
        this.form = this.data;
        this.posteSelect = this.form.postes.map((data) => data.id);
        this.actualPage = 'Postes'
        // this.getcontratsclients();
        // this.getclients();
        // this.getzones();
        // this.getpointeuses();
        // this.getsites();
    },
    methods: {
        newData(data) {
            console.log("voici la nouvelle data", data);
            this.agGridData = data;
        },
        openCreate() {
            this.showForm("Create", {}, this.gridApi, "xl");
        },
        onGridReady(params) {
            console.log("on demarre", params);
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false;
        },
        showForm(type, data, gridApi, width = "lg") {
            this.formKey++;
            this.formWidth = width;
            this.formState = type;
            this.formData = data;
            this.formGridApi = gridApi;
            this.$bvModal.show(this.formId);
        },
        EditLine() {
            this.form.allPostes = this.posteSelect.join(",");
            this.isLoading = true;
            this.axios
                .post("/api/pointeuses/" + this.form.id + "/update", this.form)
                .then((response) => {
                    this.isLoading = false;
                    this.gridApi.applyServerSideTransaction({
                        update: [response.data],
                    });
                    this.$bvModal.hide(this.modalFormId);
                    this.$toast.success("Operation effectuer avec succes");
                    this.$emit("close");
                    console.log(response.data);
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    this.isLoading = false;
                    this.$toast.error(
                        "Erreur survenue lors de l'enregistrement"
                    );
                });
        },
        DeleteLine() {
            this.isLoading = true;
            this.axios
                .post("/api/pointeuses/" + this.form.id + "/delete")
                .then((response) => {
                    this.isLoading = false;

                    this.gridApi.applyServerSideTransaction({
                        remove: [this.form],
                    });
                    this.gridApi.refreshServerSide();
                    this.$bvModal.hide(this.modalFormId);
                    this.$toast.success("Operation effectuer avec succes");
                    this.$emit("close");
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error.response.data);
                    this.isLoading = false;
                    this.$toast.error("Erreur survenue lors de la suppression");
                });
        },
        siteIds(data) {
            this.form.site_id = data;
            // console.log('siteIds',this.form.site_id)
        },
        finishAddPoste() {
            if (this.posteSelect.length != this.lastPosteSelectCount) {
                this.lastPosteSelectCount = this.posteSelect.length;
                this.tableKey++;
            }
            this.$bvModal.hide(this.formId);
        },
        addAgent() {
        },
        addPoste(data) {
            this.posteSelect.push(data.Selectvalue);
            this.$toast.success("Operation effectuer avec succes");
        },
        deletePoste(data) {
            const clickedDate = data.id;

            const index = this.posteSelect.indexOf(clickedDate);
            if (index > -1) {
                this.posteSelect.splice(index, 1);
                this.tableKey++;
                this.$toast.success("Operation effectuer avec succes");
            }
        },
        getcontratsclients() {
            this.axios.get('/api/contratsclients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.contratsclientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getclients() {
            this.axios.get('/api/clients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.clientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getzones() {
            this.axios.get('/api/zones').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.zonesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
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

        getsites() {
            this.axios.get('/api/sites').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.sitesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        readhistorique() {
            this.historique = 1
            this.historiquetype = 'postePointeuse'
        },
        fermerhistorique() {

            this.historique = false

        },
        togglePage(page) {
            this.actualPage = page
            this.tableKey++
        },
    },
};
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
</style>
