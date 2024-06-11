<template>
    <b-overlay :show="isLoading">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Create'">Ajouter des taches</div>
            </template>

            <div v-if="formState == 'Create'">
                <AgGridSearch
                    :columnDefs="add.columnDefs"
                    :filterFields="['type', 'libelle']"
                    :url="add.url"
                    @destruction="finishAddTache"
                >
                </AgGridSearch>
            </div>

            <template #modal-footer>
                <div></div>
                <button
                    v-if="formState == 'Create'"
                    class="btn btn-primary"
                    type="button"
                    @click.prevent="finishAddTache()"
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
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>Taches</label>
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
                                    taches
                                </div>
                            </template>
                        </AgGridTable>
                    </div>
                </div>
            </div>
            <div class="blockPointages">
                <template>
                    <button
                        v-if="!historique"
                        class="btn btn-secondary"
                        type="button"
                        @click="readhistorique"
                    >
                        <i class="fa-solid fa-clipboard-check"></i> Historique
                        Taches
                    </button>
                    <button
                        v-if="historique"
                        class="btn btn-danger"
                        type="button"
                        @click="fermerhistorique"
                    >
                        <i class="fas fa-close"></i> Close
                    </button>
                </template>
            </div>
            <historiqueposte
                v-if="historique === 1"
                :key="form.id"
                :Type="historiquetype"
                :pointeuse-select="form.id"
            />
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
import moment from "moment";
import historiqueposte from "./historiquepostes.vue";

import AgGridTable from "@/components/AgGridTable.vue";
import CreatePointeuses from "./CreatePointeuses.vue";

export default {
    name: "EditPointeuses",
    components: {
        CreatePointeuses,
        VSelect, CustomSelect,
        Files,
        AgGridTable,
        AgGridSearch,
        historiqueposte,
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
            tableKey: 0,
            url: "http://127.0.0.1:8000/api/taches-Aggrid",
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
            tacheSelect: [],
            lastTacheSelectCount: 0,
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
            },
        };
    },
    created() {
        (this.url = this.axios.defaults.baseURL + "/api/taches-Aggrid"),
            (this.formId = this.table + "_" + Date.now());
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        let params = {};
        // params['type_id'] = {values: [2, 3], filterType: 'set'}
        // this.extrasData['baseFilter'] = params
        // this.extrasData['selectAllQuery'] = 1

        (this.add.url = this.axios.defaults.baseURL + "/api/taches-Aggrid"),
            (this.add.rowBuffer = 0);
        this.add.rowModelType = "serverSide";
        this.add.cacheBlockSize = 50;
        this.add.maxBlocksInCache = 2;
    },
    computed: {
        extrasData: function () {
            let params = {baseFilter: {}};
            params["baseFilter"]["id"] = {
                values: this.tacheSelect,
                filterType: "set",
            };
            return params;
        },
        tacheUrl: function () {
            return this.axios.defaults.baseURL + "/api/taches-Aggrid/";
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
                                this.deleteTache(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`,
                        },
                    };
                },
            },

            {
                field: "libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "libelle",
            },

            {
                headerName: "type",
                field: "typestache.Selectlabel",
            },
            {
                headerName: "type",
                field: "typestache_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["typestache"]["Selectlabel"];
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
                        params.success(this.typestachesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                headerName: "ville",
                field: "ville.Selectlabel",
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

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.Selectlabel,
                    values: (params) => {
                        params.success(this.villesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },
            {
                field: "created_at",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Créer le",
                valueFormatter: (params) => {
                    let retour = params.value;
                    try {
                        if (retour) {
                            retour = moment(params.value).format(
                                "DD/MM/YYYY à HH:mm"
                            );
                        } else {
                            retour = "Date inconnue";
                        }
                    } catch (e) {
                    }
                    return retour;
                },
            },
        ];
        this.add.columnDefs = [
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
                                this.addTache(field);
                            },

                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                        },
                    };
                },
            },

            {
                field: "libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "libelle",
            },

            {
                headerName: "type",
                field: "typestache.Selectlabel",
            },
            {
                headerName: "type",
                field: "typestache_id",
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["typestache"]["Selectlabel"];
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
                        params.success(this.typestachesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                headerName: "ville",
                field: "ville.Selectlabel",
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

                filter: "agSetColumnFilter",
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: (params) => params.value.id,
                    valueFormatter: (params) => params.value.Selectlabel,
                    values: (params) => {
                        params.success(this.villesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },
            {
                field: "created_at",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Créer le",
                valueFormatter: (params) => {
                    let retour = params.value;
                    try {
                        if (retour) {
                            retour = moment(params.value).format(
                                "DD/MM/YYYY à HH:mm"
                            );
                        } else {
                            retour = "Date inconnue";
                        }
                    } catch (e) {
                    }
                    return retour;
                },
            },
        ];
    },

    mounted() {
        this.form = this.data;
        // console.log('this.form=>',this.form.Taches.map(data => data.id))
        this.tacheSelect = this.form.Taches.map((data) => data.id);
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
            this.form.alltaches = this.tacheSelect.join(",");
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
        finishAddTache() {
            if (this.tacheSelect.length != this.lastTacheSelectCount) {
                this.lastTacheSelectCount = this.tacheSelect.length;
                this.tableKey++;
            }
            this.$bvModal.hide(this.formId);
        },
        addTache(data) {
            this.tacheSelect.push(data.Selectvalue);
            this.$toast.success("Operation effectuer avec succes");
        },
        deleteTache(data) {
            const clickedDate = data.id;

            const index = this.tacheSelect.indexOf(clickedDate);
            console.log("error.response.data", index);

            if (index > -1) {
                this.tacheSelect.splice(index, 1);
                this.tableKey++;
                this.$toast.success("Operation effectuer avec succes");
            }
        },
        readhistorique() {
            this.historique = 1
            this.historiquetype = 'tachePointeuse'
        },
        fermerhistorique() {

            this.historique = false

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
