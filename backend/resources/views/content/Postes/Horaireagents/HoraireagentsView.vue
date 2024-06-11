<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">
                    Update Horaireagents #{{ formData.id }}
                </div>
                <div v-if="formState == 'Create'">Create Horaireagents</div>
                <div v-if="formState == 'CreateHoraire'">Create Horaire</div>
            </template>

            <EditHoraireagents v-if="formState == 'Update'" :key="formKey" :HorairesData="HorairesData" :data="formData"
                               :faction="faction" :gridApi="formGridApi" :modalFormId="formId" :parentId="parentId"
                               :usersData="usersData"
                               @close="closeForm"/>

            <CreateHoraires v-if="formState == 'CreateHoraire'" :key="formKey" :gridApi="formGridApi"
                            :modalFormId="formId" :parentId="parentId" @close="closeForm"/>

            <AgGridSearch v-if="formState == 'Create'" :columnDefs="addListing.columnDefs"
                          :extrasData="addListing.extrasData" :filterFields="['nom','prenom','matricule']"
                          :paginationPageSize="10"
                          :url="addListing.url" filter-key="type_id" filter-value="2" @destruction="finishAddUser">
            </AgGridSearch>

            <template #modal-footer>
                <!-- <div></div> -->
                <button v-if="formState == 'Create'" class="btn btn-primary" type="button"
                        @click.prevent="finishAddUser()">
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
            </template>
        </b-modal>

        <div id="titulaires" class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData" :rowModelType="rowModelType" :showExport="false" :sideBar="{}" :url="url"
                         className="ag-theme-alpine" domLayout="autoHeight" rowSelection="multiple"
                         @gridReady="onGridReady"
                         @newData="newData">
                <template #header_buttons>
                    <div v-if="horaireId != 0" class="btn btn-primary" @click="openCreate">
                        <i class="fa fa-plus"></i> Ajouter un agent
                    </div>
                    <div v-for="horaire in horaires" :style="horaireId == horaire.id ? 'border-color:green' : ''"
                         class="btn"
                         @click="selectHoraire(horaire.id)">
                        <i :style="horaireId == horaire.id ? 'color:green' : ''" class="fa-solid fa-check-double"></i>
                        {{ horaire.libelle }} ( {{ horaire.debut }} - {{ horaire.fin }} )
                    </div>

                    <div v-if="horaireId != 0" class="btn btn-primary" @click="openCreateHoraire">
                        <i class="fa fa-plus"></i> Ajouter une horaire
                    </div>
                </template>
            </AgGridTable>
        </div>
    </div>
</template>

<script>
import DataTable from "@/components/DataTable.vue";
import AgGridTable from "@/components/AgGridTable.vue";
import CreateHoraireagents from "./CreateHoraireagents.vue";
import EditHoraireagents from "./EditHoraireagents.vue";
import DataModal from "@/components/DataModal.vue";
import DaysTraitements from "./DaysTraitements.vue";
import TypeAgentsTraitements from "./TypeAgentsTraitements.vue";

import AgGridSearch from "@/components/AgGridSearch.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import CreateHoraires from "../../Horaires/CreateHoraires.vue";

export default {
    name: "HoraireagentsView",
    components: {
        DataTable,
        AgGridTable,
        CreateHoraireagents,
        EditHoraireagents,
        DataModal,
        AgGridSearch,
        AgGridBtnClicked,
        DaysTraitements,
        TypeAgentsTraitements,
        CreateHoraires
    },
    props: ["parent", "horaireId", "horaires", "typespostes"],
    data() {
        return {
            formId: "Horaireagents",
            formState: "",
            formData: {},
            formWidth: "lg",
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: "http://127.0.0.1:8000/api/horaireagents-Aggrid",
            table: "Horaireagents",
            HorairesData: [],
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
                paginationPageSize: 10,
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
            params["horaire_id"] = {values: [this.horaireId], filterType: "set"};
            retour["baseFilter"] = params;
            this.tableKey++;
            return retour;
        },
        days: function () {
            return ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']
        },
        typeAgents: function () {
            return ['Type Agents']
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
        'actualHoraire': {
            handler: function (after, before) {
                this.gridApi.sizeColumnsToFit();
            }
        }
    },

    created() {
        (this.url = this.axios.defaults.baseURL + "/api/horaireagents-Aggrid"),
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
                maxminWidth: 80, maxWidth: 80,
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
                headerName: " Matricule ",
                field: "user.matricule",
                // maxWidth: 100
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
            },
            {
                headerName: " Nom",
                field: "user.nom",
                // maxWidth: 100
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
                // maxWidth: 100
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
                headerName: " Fonction ",
                field: "user.fonction.libelle",
                // maxWidth: 100
                hide: this.typespostes,
            },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: "user",
                field: "user_id",
                valueFormatter: (params) => {
                    let retour = "";
                    try {
                        return params.data["user"]["fonction"];
                    } catch (e) {
                    }
                    return retour;
                },
            },
        ];
        this.typeAgents.forEach(day => {
            let donnes = {
                field: day,
                suppressCellSelection: true,
                minWidth: 250,
                maxWidth: 250,
                cellRendererSelector: (params) => {
                    return {
                        component: "TypeAgentsTraitements",
                        params: {
                            dropdownOptions: [
                                {value: 1, label: 'Titulaire'},
                                {value: 2, label: 'Remplacant'},
                                {value: 3, label: 'Conge'},
                                // ... Ajoutez d'autres options si nécessaire
                            ],
                        },
                    };

                },
                headerName: day,
            }
            this.columnDefs.push(donnes)
        })
        this.days.forEach(day => {
            let donnes = {
                field: day,
                suppressCellSelection: true,
                maxminWidth: 80,
                maxWidth: 80,
                cellRendererSelector: (params) => {
                    return {
                        component: "DaysTraitements",
                        params: {
                            day: day,
                        },
                    };

                },
                headerName: day[0],
            }
            this.columnDefs.push(donnes)
        })

    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getHoraires();
        this.selectHoraires();
    },
    methods: {
        closeForm() {
            this.tableKey++;
        },
        openCreate() {
            this.showForm("Create", {}, this.gridApi);
        },
        openCreateHoraire() {
            this.showForm("CreateHoraire", {}, this.gridApi);
        },
        selectHoraire(horaireId) {
            this.horaireId = horaireId;
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
            this.gridApi.sizeColumnsToFit();
        },
        newData(data) {
            this.$emit("newData", data);
        },
        getHoraires() {
            this.axios
                .get("/api/horaires")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.HorairesData = response.data;
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
                horaire_id: this.horaireId,
                user_id: element.id,
            };

            this.isLoading = true;
            this.axios
                .post("/api/horaireagents", data)
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
                .post("/api/horaireagents/" + element.id + "/delete")
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
                .post("/api/horaireagents/" + element.id + "/update", data)
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
                .post("/api/horaireagents/" + element.id + "/update", element)
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
<style>
#titulaires .ag-theme-alpine .ag-layout-auto-height .ag-center-cols-container {
    min-height: 0px !important;
}

#titulaires .ag-theme-alpine .ag-layout-auto-height .ag-center-cols-clipper {
    min-height: 0px !important;
}
</style>
