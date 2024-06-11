<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">
                    Update Postesagents #{{ formData.id }}
                </div>
                <div v-if="formState == 'Create'">Create Postesagents</div>
            </template>

            <EditPostesagents
                v-if="formState == 'Update'"
                :key="formKey"
                :data="formData"
                :faction="faction"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :parentId="parentId"
                :postesData="postesData"
                :usersData="usersData"
                @close="closeForm"
            />

            <AgGridSearch
                v-if="formState == 'Create'"
                :columnDefs="addListing.columnDefs"
                :extrasData="addListing.extrasData"
                :filterFields="['nom', 'prenom', 'matricule']"
                :url="addListing.url"
                filter-key="type_id"
                filter-value="2"
                @destruction="finishAddUser"
            >
            </AgGridSearch>

            <!--            <CreatePostesagents-->
            <!--                v-if="formState=='Create'"-->
            <!--                :modalFormId="formId"-->
            <!--                :key="formKey"-->
            <!--                :gridApi="formGridApi"-->
            <!--                @close="closeForm"-->
            <!--                :postesData="postesData"-->
            <!--                :usersData="usersData"-->
            <!--                :parentId="parentId"-->
            <!--                :faction="faction"-->
            <!--            />-->

            <template #modal-footer>
                <!-- <div></div> -->
                <button
                    v-if="formState == 'Create'"
                    class="btn btn-primary"
                    type="button"
                    @click.prevent="finishAddUser()"
                >
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
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
                :showExport="false"
                :url="url"
                className="ag-theme-alpine"
                domLayout="autoHeight"
                rowSelection="multiple"
                @gridReady="onGridReady"
                @newData="newData"
            >
                <template #header_buttons>
                    <div
                        v-if="!routeData.meta.hideCreate"
                        class="btn btn-primary"
                        @click="openCreate"
                    >
                        <i class="fa fa-plus"></i> Nouveau
                    </div>
                </template>
            </AgGridTable>
        </div>
    </div>
</template>

<script>
import DataTable from "@/components/DataTable.vue";
import AgGridTable from "@/components/AgGridTable.vue";
import CreatePostesagents from "./CreatePostesagents.vue";
import EditPostesagents from "./EditPostesagents.vue";
import DataModal from "@/components/DataModal.vue";
import DaysTraitements from "./DaysTraitements.vue";

import AgGridSearch from "@/components/AgGridSearch.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: "PostesagentsView",
    components: {
        DataTable,
        AgGridTable,
        CreatePostesagents,
        EditPostesagents,
        DataModal,
        AgGridSearch,
        AgGridBtnClicked,
        DaysTraitements
    },
    props: ["parent", "faction"],
    data() {
        return {
            formId: "postesagents",
            formState: "",
            formData: {},
            formWidth: "lg",
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: "http://127.0.0.1:8000/api/postesagents-Aggrid",
            table: "postesagents",
            postesData: [],
            usersData: [],
            requette: 2,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            userAdded: 0,

            addListing: {
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

    computed: {
        routeData: function () {
            let router = {meta: {}};
            if (window.router) {
                try {
                    router = window.router;
                } catch (e) {
                }
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

        parentId: function () {
            let id = 0;
            id = this.parent.id;
            return id;
        },
        extrasData: function () {
            let retour = {};
            let params = {};
            params["faction"] = {values: [this.faction], filterType: "set"};
            params["poste_id"] = {values: [this.parentId], filterType: "set"};
            retour["baseFilter"] = params;

            return retour;
        },
        days: function () {
            return ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']
        }
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
        (this.url = this.axios.defaults.baseURL + "/api/postesagents-Aggrid"),
            (this.formId = this.table + "_" + Date.now());
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        (this.addListing.url =
            this.axios.defaults.baseURL + "/api/users-Aggrid"),
            (this.addListing.rowBuffer = 0);
        this.addListing.rowModelType = "serverSide";
        this.addListing.columnDefs = [
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
                                this.addUser(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa fa-plus"></i></div>`,

                            //  render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                        },
                    };
                    return response;
                },
            },
            {
                field: "matricule",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "matricule",
            },
            {
                field: "nom",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "nom",
            },
            {
                field: "prenom",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "prenom",
            },
            {
                field: "num_badge",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "num_badge",
            },
        ];
        this.addListing.cacheBlockSize = 50;
        this.addListing.maxBlocksInCache = 2;
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
                                this.DeleteLine(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`,
                        },
                    };
                },
            },


            {
                headerName: " Nom",
                field: "user.nom",
                maxWidth: 100
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,
                headerName: "Agent",
                field: "user_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["user"]["nom"];
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
                        params.success(this.usersData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

            {
                headerName: " Prenom ",
                field: "user.prenom",
                maxWidth: 100
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "user",
                field: "user_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["user"]["prenom"];
                    } catch (e) {
                    }
                    return retour;
                },
            },

            {
                headerName: " Matricule ",
                field: "user.matricule",
                maxWidth: 100
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "user",
                field: "user_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["user"]["matricule"];
                    } catch (e) {
                    }
                    return retour;
                },
            }
        ];

        this.days.forEach(day => {
            let donnes = {
                field: day,
                suppressCellSelection: true,
                maxWidth: 60,
                cellRendererSelector: (params) => {
                    return {
                        component: "DaysTraitements",
                        params: {
                            day: day,
                        },
                    };

                },
                headerName: day,
            }
            this.columnDefs.push(donnes)
        })
    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getpostes();
        // this.getusers();
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
        newData(data) {
            this.$emit("newData", data);
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

        getusers() {
            this.axios
                .get("/api/users?filter[actif_id]=1&filter[type_id]=2")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.usersData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },

        addUser(element) {
            console.log("voici les donnees ===>", element);
            let data = {
                faction: this.faction,
                poste_id: this.parentId,
                user_id: element.id,
            };

            this.isLoading = true;
            this.axios
                .post("/api/postesagents", data)
                .then((response) => {
                    this.isLoading = false;
                    this.userAdded++;
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
        finishAddUser() {
            // evenement appeler lorsquon ferme le formulaire dajout des agents
            // on verifie si on ajouter des agents et on met a jour le tableau sinon on ne fait rien
            if (this.userAdded > 0) {
                this.tableKey++;
            }
            this.userAdded = 0;
            this.$bvModal.hide(this.formId);
        },

        DeleteLine(element) {
            this.isLoading = true;
            this.axios
                .post("/api/postesagents/" + element.id + "/delete")
                .then((response) => {
                    this.isLoading = false;
                    this.tableKey++;

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

        present(element, value) {
            let data = {}
            // console.log('element=>',value)
            switch (value) {
                case "lundi":
                    data.lun = true;
                    break;
                case "mardi":
                    data.mar = true;
                    break;
                case "mercredi":
                    data.mer = true;
                    break;
                case "jeudi":
                    data.jeu = true;
                    break;
                case "vendredi":
                    data.ven = true;
                    break;
                case "samedi":
                    data.sam = true;
                    break;
                case "dimanche":
                    data.dim = true;
                    break;
            }

            this.isLoading = true;
            this.axios
                .post("/api/postesagents/" + element.id + "/update", data)
                .then((response) => {
                    this.isLoading = false;
                    this.tableKey++;

                    this.$toast.success("Operation effectuer avec succes");
                    this.$emit("close");
                    // console.log(response.data);
                })
                .catch((error) => {
                    console.log(error.response.data);
                    this.isLoading = false;
                    this.$toast.error("Erreur survenue lors de la suppression");
                });
        },

        nonpresent(element, value) {
            switch (value) {
                case "lundi":
                    element.lun = false;
                    break;
                case "mardi":
                    element.mar = false;
                    break;
                case "mercredi":
                    element.mer = false;
                    break;
                case "jeudi":
                    element.jeu = false;
                    break;
                case "vendredi":
                    element.ven = false;
                    break;
                case "samedi":
                    element.sam = false;
                    break;
                case "dimanche":
                    element.dim = false;
                    break;
            }
            console.log('element=>', element)

            this.isLoading = true;
            this.axios
                .post("/api/postesagents/" + element.id + "/update", element)
                .then((response) => {
                    this.isLoading = false;
                    this.tableKey++;
                    this.$toast.success("Operation effectuer avec succes");
                    this.$emit("close");
                    // console.log(response.data);
                })
                .catch((error) => {
                    console.log(error.response.data);
                    this.isLoading = false;
                    this.$toast.error("Erreur survenue lors de la suppression");
                });
        },
    },
};
</script>
