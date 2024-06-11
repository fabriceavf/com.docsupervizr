<template>
    <b-overlay :show="isLoading">
        <div v-for="erreur in Object.keys(errors)">
            <div v-for="message in Object.values(errors[erreur])">
                <b-alert show style="padding: 5px" variant="danger">{{ erreur }} : {{ message[0] }}
                </b-alert>
            </div>
        </div>

        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">
                    Update Modelslistings #{{ formData.id }}
                </div>
                <div v-if="formState == 'Create'">Create Modelslistings</div>
                <div v-if="formState == 'Createdirections'">add Directions</div>
            </template>
            <div v-if="formState == 'Create'">
                <AgGridSearch :columnDefs="add.columnDefs" :filterFields="[]" :filterValue="form.zone_id.toString()"
                              :url="add.url" filterKey="zone_id" @destruction="finishAddPoste">
                </AgGridSearch>
            </div>
            <div v-if="formState == 'Createdirections'">
                <AgGridSearch :columnDefs="adddirections.columnDefs" :filterFields="['libelle']"
                              :url="adddirections.url"
                              filterKey="" filterValue="" @destruction="finishAddDirection">
                </AgGridSearch>
            </div>
            <EditPostes v-if="formState == 'Update'" :key="formKey" :contratsclientsData="contratsclientsData"
                        :data="formData" :gridApi="formGridApi" :modalFormId="formId" :pointeusesData="pointeusesData"
                        :sitesData="sitesData" @close="closeForm"/>

            <template #modal-footer>
                <!-- <div></div> -->
                <button v-if="formState == 'Create'" class="btn btn-primary" type="button"
                        @click.prevent="finishAddPoste()">
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
                <button v-if="formState == 'Createdirections'" class="btn btn-primary" type="button"
                        @click.prevent="finishAddDirection()">
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
            </template>
        </b-modal>
        <div class="header-detail">
            <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                <i class="fas fa-close"></i> Supprimer la planification
            </button>
        </div>

        <form-wizard :subtitle="null" :title="null" back-button-text="Precedent" class="mb-3 formUsers"
                     color="rgb(40, 167, 69)" finish-button-text="Soumettre" next-button-text="Suivant" shape="circle"
                     stepSize="sm" @on-complete="EditLine">
            <tab-content :before-change="validationForm" title="Information planification">
                <div class="row">
                    <div class="form-group col-sm">
                        <label>Libelle </label>
                        <input v-model="form.Libelle" :class="errors.Libelle
        ? 'form-control is-invalid'
        : 'form-control'
        " type="text"/>

                        <div v-if="errors.Libelle" class="invalid-feedback">
                            <template v-for="error in errors.Libelle">
                                {{ error[0] }}
                            </template>
                        </div>
                    </div>
                    <!-- <div class="form-group col-sm">
                        <label>Faction </label>
                        <v-select v-model="form.faction" :options="factionsData"/>
                        <div v-if="errors.faction" class="invalid-feedback">
                            <template v-for="error in errors.faction">
                                {{ error[0] }}
                            </template>
                        </div>
                    </div> -->
                    <div class="form-group col-sm">
                        <label>minimum de pointage</label>
                        <input v-model="form.min_partage" class="form-control" type="number"/>
                    </div>
                    <div class="form-group col-sm">
                        <label>date de debut </label>
                        <input v-model="form.date_debut" class="form-control" required type="date"/>
                    </div>
                    <!-- <div class="form-group col-sm">
                        <label>type de listings </label>
                        <v-select v-model="form.typelistings" :options="validationsData" label="Selectlabel"/>
                    </div> -->
                    <div class="form-group col-sm">
                        <label>zones </label>
                        <CustomSelect :key="form.zone" :columnDefs="['libelle']" :oldValue="form.zone"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.zone_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/zones-Aggrid`" filter-key=""
                                      filter-value=""/>
                        <div v-if="errors.zone_id" class="invalid-feedback">
                            <template v-for="error in errors.zone_id">
                                {{ error[0] }}
                            </template>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm">
                        <label>valideur 1</label>

                        <CustomSelect :key="form.user" :columnDefs="['nom', 'prenom']" :oldValue="form.user"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.user_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/users-Aggrid`" filter-key="type_id"
                                      filter-value="1"/>

                        <div v-if="errors.user_id" class="invalid-feedback">
                            <template v-for="error in errors.user_id">
                                {{ error[0] }}
                            </template>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label>valideur 1 </label>

                        <CustomSelect :key="form.user2" :columnDefs="['nom', 'prenom']" :oldValue="form.user2"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.user_id_2 = data.id"
                                      :url="`${axios.defaults.baseURL}/api/users-Aggrid`" filter-key="type_id"
                                      filter-value="1"/>

                        <div v-if="errors.user_id_2" class="invalid-feedback">
                            <template v-for="error in errors.user_id_2">
                                {{ error[0] }}
                            </template>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label>valideur 2 </label>

                        <CustomSelect :key="form.user3" :columnDefs="['nom', 'prenom']" :oldValue="form.user3"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.user_id_3 = data.id"
                                      :url="`${axios.defaults.baseURL}/api/users-Aggrid`" filter-key="type_id"
                                      filter-value="1"/>

                        <div v-if="errors.user_id_3" class="invalid-feedback">
                            <template v-for="error in errors.user_id_3">
                                {{ error[0] }}
                            </template>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label>valideur 2 </label>

                        <CustomSelect :key="form.user4" :columnDefs="['nom', 'prenom']" :oldValue="form.user4"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.user_id_4 = data.id"
                                      :url="`${axios.defaults.baseURL}/api/users-Aggrid`" filter-key="type_id"
                                      filter-value="1"/>

                        <div v-if="errors.user_id_4" class="invalid-feedback">
                            <template v-for="error in errors.user_id_4">
                                {{ error[0] }}
                            </template>
                        </div>
                    </div>
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
                        <button v-b-tooltip.hover :style="actualPage == 'Directions' ? 'border: 3px solid  green' : ''"
                                class="btn" style="" @click.prevent="togglePage('Directions')">
                            <div class="iconParent">
                                <span> <i class="fa-solid fa-filter"></i> Directions
                                </span>
                            </div>
                        </button>
                    </div>
                </div>
                <div v-if="actualPage == 'Postes'" class="form-group">
                    <label>Postes</label>
                    <div class="col-sm-12">
                        <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                                     :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache"
                                     :pagination="pagination"
                                     :paginationPageSize="paginationPageSize" :rowData="rowData"
                                     :rowModelType="rowModelType"
                                     :show-export="false" :show-pagination="false" :url="url"
                                     className="ag-theme-alpine"
                                     dom-layout="normal" domLayout="autoHeight" rowSelection="multiple"
                                     @gridReady="onGridReady"
                                     @newData="newData">
                            <template #header_buttons>
                                <div class="btn btn-primary" @click="openCreate('horaires')">
                                    <i class="fa fa-plus"></i> Ajouter des
                                    horaires
                                </div>
                            </template>
                        </AgGridTable>
                    </div>
                </div>
                <div v-if="actualPage == 'Directions'" class="form-group">
                    <label>Directions</label>
                    <div class="col-sm-12">
                        <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs3"
                                     :extrasData="extrasData3" :maxBlocksInCache="maxBlocksInCache"
                                     :pagination="pagination"
                                     :paginationPageSize="paginationPageSize" :rowData="rowData"
                                     :rowModelType="rowModelType"
                                     :show-export="false" :show-pagination="false" :url="url3"
                                     className="ag-theme-alpine"
                                     dom-layout="normal" domLayout="autoHeight" rowSelection="multiple"
                                     @gridReady="onGridReady"
                                     @newData="newData">
                            <template #header_buttons>
                                <div class="btn btn-primary" @click="openCreate('directions')">
                                    <i class="fa fa-plus"></i> Ajouter des
                                    directions
                                </div>
                            </template>
                        </AgGridTable>
                    </div>
                </div>
            </tab-content>
            <tab-content :before-change="validationForm" title="Validation">
                <div class="col-sm-12">
                    <h3>Validation </h3>
                    <ValidationsView :parentId="data.id"></ValidationsView>
                </div>
            </tab-content>
            <tab-content :before-change="validationForm" title="Activites Recente">
                <Activitesrecentes :key="form.id" :user-select="form.id"></Activitesrecentes>
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


                <div v-if="historique === 1" class="form-group">
                    <div class="col-sm-12">
                        <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs2"
                                     :extrasData="extrasData2" :in-card="false" :maxBlocksInCache="maxBlocksInCache"
                                     :pagination="pagination" :paginationPageSize="paginationPageSize"
                                     :rowData="rowData"
                                     :rowModelType="rowModelType" :sideBar="false" :url="url2"
                                     className="ag-theme-alpine"
                                     dom-layout="normal" domLayout="autoHeight" rowSelection="multiple"
                                     @gridReady="onGridReady">
                            <template #header_buttons>

                            </template>
                        </AgGridTable>
                    </div>
                </div>

            </tab-content>
        </form-wizard>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import AgGridTable from "@/components/AgGridTable.vue";
import {FormWizard, TabContent} from "vue-form-wizard";
import ValidationsView from "./Validations/ValidationsView.vue";
import AgGridSearch from "@/components/AgGridSearch.vue";

import ListingspostesView from "./Listingspostes/ListingspostesView.vue";

import Files from "@/components/Files.vue";
import VSelect from "vue-select";
import calendrierModelslistings from "./calendrierModelslistings.vue";
import Activitesrecentes from "./Activitesrecentes.vue";
import EditPostes from "../Postes/EditPostes.vue";
import WeekdayCheckbox from "./WeekdayCheckbox.vue";
import moment from 'moment'

export default {
    name: "CreateModelslistings",
    components: {
        VSelect, CustomSelect,
        Files,
        FormWizard,
        TabContent,
        AgGridTable,
        calendrierModelslistings,
        Activitesrecentes,
        ListingspostesView,
        AgGridSearch,
        EditPostes,
        WeekdayCheckbox,
        ValidationsView
    },
    props: [
        "data",
        "gridApi",
        "modalFormId",
        "actifsData",
        "balisesData",
        "categoriesData",
        "contratsData",
        "directionsData",
        "echelonsData",
        "factionsData",
        "fonctionsData",
        "matrimonialesData",
        "nationalitesData",
        "onlinesData",
        "postesData",
        "sexesData",
        "sitesData",
        "situationsData",
        "typesData",
        "usersData",
        "villesData",
        "zonesData",
    ],
    data() {
        return {
            calendarKey: 0,
            errors: [],
            isLoading: false,
            historique: 0,
            validationsData: [],
            selectedDays: [],
            form: {
                id: "",

                Libelle: "",

                faction: "",

                user_id: "",

                user_id_2: "",

                user_id_3: "",

                user_id_4: "",

                userFiltre: "",

                userMatricule: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",
            },
            defaultEntite: "User",
            formId: "users",
            formState: "",
            formData: {},
            formWidth: "lg",
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: "http://127.0.0.1:8000/api/users-Aggrid",
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
            agGridData: null,
            dateSelect: [],
            read: false,
            posteSelect: [],
            directionSelect: [],
            lastPosteSelectCount: 0,
            lastdirectionSelectCount: 0,
            actualPage: '',
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
                extrasData2: {},
            },
            adddirections: {
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
                extrasData2: {},
            },
        };
    },
    watch: {
        'form.zone_id': {
            handler(nouvelleValeur, ancienneValeur) {
                console.log('Le formulaire a changé :', ancienneValeur);
                if (ancienneValeur) {
                    this.posteSelect = [];
                    this.lastPosteSelectCount = 0;
                }

            },
            deep: true, // Surveiller les changements profonds dans l'objet form.
        },
    },
    methods: {
        // handleTabChange() {
        //     this.read = true;
        // },
        togglePage(page) {
            this.actualPage = page
            this.tableKey++
        },
        EditLine() {
            this.isLoading = true;
            if (this.dateSelect.length == 0) {
                this.form.date = this.form.date;
            } else {
                this.form.date = JSON.stringify(this.dateSelect);
            }
            this.selectedDays.forEach((element) => {
                switch (element) {
                    case "Lundi":
                        this.form.lun = true;

                        break;

                    case "Mardi":
                        this.form.mar = true;

                        break;
                    case "Mercredi":
                        this.form.mer = true;
                        break;

                    case "Jeudi":
                        this.form.jeu = true;
                        break;
                    case "Vendredi":
                        this.form.ven = true;
                        break;

                    case "Samedi":
                        this.form.sam = true;

                        break;
                    case "Dimanche":
                        this.form.dim = true;
                        break;
                }
            });
            // this.form.postes = this.posteSelect.join(",");
            this.form.horaires = this.posteSelect.join(",");
            this.form.directions = this.directionSelect.join(",");
            this.form.userFiltre = JSON.stringify(this.form.userFiltre);
            this.axios
                .post(
                    "/api/modelslistings/" + this.form.id + "/update",
                    this.form
                )
                .then((response) => {
                    this.isLoading = false;
                    this.gridApi.applyServerSideTransaction({
                        update: [response.data],
                    });
                    this.$bvModal.hide(this.modalFormId);
                    this.$toast.success("Operation effectuer avec succes");
                    // this.$emit("close");
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
                .post("/api/modelslistings/" + this.form.id + "/delete")
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
        onGridReady(params) {
            console.log("on demarre", params);
            this.gridApi1 = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false;
            this.calendarKey++; // Incrémente la valeur de calendarKey pour forcer le rendu du composant <FullCalendar>
        },
        openCreate(data) {
            if (data == 'directions') {
                this.showForm("Createdirections", {}, this.gridApi, "lg");

            } else {
                this.showForm("Create", {}, this.gridApi, "xl");

            }
        },
        newData(data) {
            console.log("voici la nouvelle data", data);
            this.agGridData = data;
            try {
                this.form.userFiltre = data.__allFilters;
            } catch (e) {
            }
        },
        createLine() {
            this.isLoading = true;
            const model = this.gridApi1.getFilterModel();
            console.log("model ===>", model);
            this.form.userFiltre = JSON.stringify(this.form.userFiltre);
            this.axios
                .post("/api/modelslistings", this.form)
                .then((response) => {
                    this.isLoading = false;
                    this.resetForm();
                    this.gridApi.applyServerSideTransaction({
                        add: [response.data],
                    });
                    this.gridApi.refreshServerSide();
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
        resetForm() {
            this.form = {
                id: "",
                Libelle: "",
                userFiltre: "",
                userMatricule: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
                identifiants_sadge: "",
            };
        },
        addPoste(data) {

            const clickedDate = data.Selectvalue;


            const index = this.posteSelect.indexOf(clickedDate);
            if (index > -1) {
                // Si la date est déjà sélectionnée, la supprimer du tableau
                // this.selectedDates.splice(index, 1);
            } else {
                // Si la date n'est pas déjà sélectionnée, l'ajouter au tableau
                this.posteSelect.push(clickedDate);
            }

            console.log('this.posteSelect', this.posteSelect);
            // this.posteSelect.push(data.Selectvalue);
            this.$toast.success("Operation effectuer avec succes");
        },
        addDirection(data) {

            const clickedDate = data.Selectvalue;


            const index = this.directionSelect.indexOf(clickedDate);
            if (index > -1) {
                // Si la date est déjà sélectionnée, la supprimer du tableau
                // this.selectedDates.splice(index, 1);
            } else {
                // Si la date n'est pas déjà sélectionnée, l'ajouter au tableau
                this.directionSelect.push(clickedDate);
            }
            this.$toast.success("Operation effectuer avec succes");
        },
        deletePoste(data) {
            const clickedDate = data.Selectvalue;

            const index = this.posteSelect.indexOf(clickedDate);
            if (index > -1) {
                this.posteSelect.splice(index, 1);
                this.tableKey++;
                this.$toast.success("Operation effectuer avec succes");
            }
        },
        deleteDirection(data) {
            const clickedDate = data.Selectvalue;

            const index = this.directionSelect.indexOf(clickedDate);
            if (index > -1) {
                this.directionSelect.splice(index, 1);
                this.tableKey++;
                this.$toast.success("Operation effectuer avec succes");
            }
        },
        finishAddPoste() {
            if (this.posteSelect.length != this.lastPosteSelectCount) {
                this.lastPosteSelectCount = this.posteSelect.length;
                this.tableKey++;
            }
            this.$bvModal.hide(this.formId);
        },
        finishAddDirection() {
            if (this.directionSelect.length != this.lastdirectionSelectCount) {
                this.lastdirectionSelectCount = this.directionSelect.length;
                this.tableKey++;
            }
            this.$bvModal.hide(this.formId);
        },
        readhistorique() {
            this.historique = 1
            this.historiquetype = 'postePointeuse'
        },
        fermerhistorique() {

            this.historique = false

        },
        showForm(type, data, gridApi, width = "lg") {
            this.formKey++;
            this.formWidth = width;
            this.formState = type;
            this.formData = data;
            this.formGridApi = gridApi;
            this.$bvModal.show(this.formId);
        },
        getselectedDays() {
            if (this.form.lun === 1) {
                this.selectedDays.push("Lundi");
            }
            if (this.form.mar === 1) {
                this.selectedDays.push("Mardi");
            }
            if (this.form.mer === 1) {
                this.selectedDays.push("Mercredi");
            }
            if (this.form.jeu === 1) {
                this.selectedDays.push("Jeudi");
            }
            if (this.form.ven === 1) {
                this.selectedDays.push("Vendredi");
            }
            if (this.form.sam === 1) {
                this.selectedDays.push("Samedi");
            }
            if (this.form.dim === 1) {
                this.selectedDays.push("Dimanche");
            }
            // console.log("selectedDays ==>", this.selectedDays);
        },
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
        extrasData2: function () {
            let params = {}
            params['cle'] = {values: [this.form.id], filterType: 'set'}
            params['type'] = {values: ['posteModelslisting'], filterType: 'set'}

            if (this.search !== "") {
                params['filterFields'] = ['action'];
                params['globalSearch'] = this.search;
            }
            return {baseFilter: params}
        },
        extrasData3: function () {
            let params = {baseFilter: {}};
            params["baseFilter"]["id"] = {
                values: this.directionSelect,
                filterType: "set",
            };
            return params;
        },
    },
    created() {
        // (this.url = this.axios.defaults.baseURL + "/api/postes-Aggrid"),
        (this.url = this.axios.defaults.baseURL + "/api/horaires-Aggrid"),
            (this.url2 = this.axios.defaults.baseURL + "/api/historiques-Aggrid"),
            (this.url3 = this.axios.defaults.baseURL + "/api/directions-Aggrid"),
            (this.formId = this.table + "_" + Date.now());
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        let params = {};
        // params['type_id'] = {values: [2, 3], filterType: 'set'}
        // this.extrasData['baseFilter'] = params
        // this.extrasData['selectAllQuery'] = 1

        // (this.add.url = this.axios.defaults.baseURL + "/api/postes-Aggrid"),
        (this.add.url = this.axios.defaults.baseURL + "/api/horaires-Aggrid"),
            (this.adddirections.url = this.axios.defaults.baseURL + "/api/directions-Aggrid"),
            (this.add.rowBuffer = 0);
        this.add.rowModelType = "serverSide";
        this.add.cacheBlockSize = 50;
        this.add.maxBlocksInCache = 2;
    },
    beforeMount() {
        this.columnDefs = [
            {
                field: null,
                headerName: "",
                suppressCellSelection: true,
                minWidth: 80,
                maxWidth: 80,
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
                field: "poste.CodeConcat",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "code",
            },

            {
                field: "poste.libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "libelle",
            },

            {
                field: "SelectlabelPoste",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "horaire",
            },

            {
                field: "poste.site.Selectlabel",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "site",
            },

            {
                field: "poste.site.client.Selectlabel",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "client",
            },

            // {
            //     field: "poste.jours",
            //     sortable: true,
            //     filter: "agTextColumnFilter",
            //     filterParams: {suppressAndOrCondition: true},
            //     headerName: "jours",
            // },
            // {
            //     field: "poste.maxjours",
            //     sortable: true,
            //     filter: "agTextColumnFilter",
            //     filterParams: {suppressAndOrCondition: true},
            //     headerName: "Agents Jours",
            // },
            // {
            //     field: "poste.maxnuits",
            //     sortable: true,
            //     filter: "agTextColumnFilter",
            //     filterParams: {suppressAndOrCondition: true},
            //     headerName: "Agents Nuits",
            // },

            // {
            //     headerName: "poste.pointeuse",
            //     field: "pointeuse.Selectlabel",
            // },
            // {
            //     hide: true,
            //     suppressColumnsToolPanel: true,

            //     headerName: "pointeuse",
            //     field: "pointeuse_id",
            //     valueFormatter: (params) => {
            //         let retour = "";
            //         try {
            //             return params.data["pointeuse"]["Selectlabel"];
            //         } catch (e) {
            //         }
            //         return retour;
            //     },

            //     filter: "agSetColumnFilter",
            //     filterParams: {
            //         suppressAndOrCondition: true,
            //         keyCreator: (params) => params.value.id,
            //         valueFormatter: (params) => params.value.Selectlabel,
            //         values: (params) => {
            //             params.success(this.pointeusesData);
            //         },
            //         refreshValuesOnOpen: true,
            //     },
            // },
        ];
        this.add.columnDefs = [
            {
                field: null,

                maxWidth: 60,
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
                field: "poste.CodeConcat",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "code",
                width: 60,
            },

            {
                field: "poste.libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "libelle",
            },

            {
                field: "SelectlabelPoste",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "horaire",
            },

            {
                field: "poste.site.Selectlabel",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "site",
            },

            {
                field: "poste.site.client.Selectlabel",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "client",
            },
            {
                field: "poste.Agentjour",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Agents Jours",
                width: 60,
            },
            {
                field: "poste.Agentnuit",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Agents Nuits",
                width: 60,
            },


        ];
        this.columnDefs2 = [

            {
                headerName: 'Poste',
                field: 'poste.Selectlabel',
            },
            {

                headerName: 'poste',
                field: 'valeur',
                hide: true,
                suppressColumnsToolPanel: true,
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['poste']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },
            },

            {
                field: "created_at",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'Attribuer le',
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
        this.columnDefs3 = [
            {
                field: null,
                headerName: "",
                suppressCellSelection: true,
                minWidth: 80,
                maxWidth: 80,
                pinned: "left",
                cellRendererSelector: (params) => {
                    return {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.deleteDirection(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`,
                        },
                    };
                },
            },

            {
                field: "libelle",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'libelle',
            },


            {
                field: "code",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'code',
            },
        ];
        this.adddirections.columnDefs = [
            {
                field: null,
                headerName: "",
                suppressCellSelection: true,
                minWidth: 80,
                maxWidth: 80,
                pinned: "left",
                cellRendererSelector: (params) => {
                    return {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.addDirection(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                        },
                    };
                },
            },

            {
                field: "libelle",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'libelle',
            },


            {
                field: "code",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'code',
            },
        ];
    },
    mounted() {
        this.form = this.data;
        // this.getselectedDays();
        console.log("voici la data transmise ==>", this.data);
        // this.posteSelect = this.data.postes.split(",");
        if (this.data.horaires) {
            this.posteSelect = this.data.horaires.split(",");
        }
        if (this.data.directions) {
            this.directionSelect = this.data.directions.split(",");

        }
        console.log("this.form.postes=>", this.posteSelect, this.directionSelect);
        // this.validationsData = ["client", "interne", "operationnel"]
        this.actualPage = 'Postes'
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

.allBoutons {
    display: flex;
    gap: 10px
}
</style>
