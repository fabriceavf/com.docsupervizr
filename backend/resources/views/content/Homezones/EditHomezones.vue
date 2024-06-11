<template>
    <b-overlay :show="isLoading">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">
                    Update Modelslistings #{{ formData.id }}
                </div>
                <div v-if="formState == 'Create'">Create Modelslistings</div>
            </template>
            <div v-if="formState == 'Create'">
                <AgGridSearch :columnDefs="ModelslistingcolumnDefs" :filterFields="['libelle']" :sizeColumnsToFit="md"
                              :url="Modelslistingurl" filter-key="" filter-value=""
                              @destruction="finishaddmodelslistingsadd">
                </AgGridSearch>
            </div>

            <EditPostes v-if="formState == 'Update'" :key="formKey" :contratsclientsData="contratsclientsData"
                        :data="formData" :gridApi="formGridApi" :modalFormId="formId" :pointeusesData="pointeusesData"
                        :sitesData="sitesData" @close="closeForm"/>

            <template #modal-footer>
                <!-- <div></div> -->
                <button v-if="formState == 'Create'" class="btn btn-primary" type="button"
                        @click.prevent="finishaddmodelslistingsadd()">
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
            </template>
        </b-modal>
        <form @submit.prevent="EditLine()">
            <div class="mb-3">

                <div class="form-group ">
                    <p>Libelle </p>
                    <input v-model="form.libelle" :class="errors.libelle ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>


                </div>
                <div class="form-group ">
                    <p>type </p>
                    <!-- <input v-model="form.type" :class="errors.type ? 'form-control is-invalid' : 'form-control'"
        type="text"> -->
                    <v-select v-model="form.type" :options="validationsData" label="Selectlabel"/>

                    <div v-if="errors.type" class="invalid-feedback">
                        <template v-for=" error in errors.type"> {{ error[0] }}</template>

                    </div>

                </div>
                <div class="form-group">
                    <label>zones </label>
                    <CustomSelect :key="form.zone" :columnDefs="['libelle']" :oldValue="form.zone"
                                  :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => { form.zone_id = data.id; form.zone = data }"
                                  :url="`${axios.defaults.baseURL}/api/zones-Aggrid`" filter-key="" filter-value=""/>
                    <div v-if="errors.zone_id" class="invalid-feedback">
                        <template v-for=" error in errors.zone_id"> {{ error[0] }}</template>

                    </div>
                </div>

            </div>
            <div class="form-group">
                <label>Plannification</label>
                <div class="col-sm-12">
                    <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                                 :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                                 :paginationPageSize="paginationPageSize" :rowData="rowData"
                                 :rowModelType="rowModelType"
                                 :show-export="false" :show-pagination="false" :url="url" className="ag-theme-alpine"
                                 dom-layout="normal" domLayout="autoHeight" rowSelection="multiple"
                                 @gridReady="onGridReady"
                                 @newData="newData">
                        <template #header_buttons>
                            <div class="btn btn-primary" @click="openCreate">
                                <i class="fa fa-plus"></i> Ajouter des
                                Plannifications
                            </div>
                        </template>
                    </AgGridTable>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"
import VSelect from "vue-select"
import AgGridSearch from "@/components/AgGridSearch.vue"
import AgGridTable from "@/components/AgGridTable.vue"

export default {
    name: 'EditUserszones',
    components: {CustomSelect, VSelect, AgGridTable, AgGridSearch, Files},
    props: ['data', 'gridApi', 'modalFormId',
        'zonesData',
    ],
    data() {
        return {
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/homezones-Aggrid',
            table: 'homezones',
            zonesData: [],
            requette: 1,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 10,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            Modelslistingsadd: 0,
            lastPosteSelectCount: 0,
            posteSelect: [],
            validationsData: [],
            errors: [],
            isLoading: false,
            form: {

                id: "",

                modelslisting_id: "",

                modelslisting: "",

                zone_id: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            }
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

        extrasData: function () {
            let params = {baseFilter: {}};
            params["baseFilter"]["id"] = {
                values: this.posteSelect,
                filterType: "set",
            };
            return params;


        }
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/modelslistings-Aggrid',
            this.Modelslistingurl = this.axios.defaults.baseURL + '/api/modelslistings-Aggrid',
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
                                    this.deletemodellisting(field);
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`,
                            },
                        };
                    },
                },

                {
                    field: "Libelle",
                    sortable: true,
                    filter: "agTextColumnFilter",
                    filterParams: {suppressAndOrCondition: true},
                    headerName: "Libelle",
                },
                {
                    field: "typelistings",
                    sortable: true,
                    filter: "agTextColumnFilter",
                    filterParams: {suppressAndOrCondition: true},
                    headerName: "type de listings",
                },
                {
                    field: "faction",
                    sortable: true,
                    filter: "agTextColumnFilter",
                    filterParams: {suppressAndOrCondition: true},
                    headerName: "faction",
                },

                {
                    headerName: "zone",
                    field: "zone.Selectlabel",
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
                    filter: "CustomFiltre",
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

        this.ModelslistingcolumnDefs = [
            {
                field: null,

                width: 80,
                pinned: "left",
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: "",
                cellRendererSelector: (params) => {
                    let response = {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.addmodelslistings(field);
                            },

                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-add "></i></div>`,
                        },
                    };
                    return response;
                },
            },


            {
                field: "Libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Libelle",
            },
            {
                field: "typelistings",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "type de listings",
            },
            {
                field: "faction",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "faction",
            },

            {
                headerName: "zone",
                field: "zone.Selectlabel",
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
                filter: "CustomFiltre",
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
    },
    mounted() {
        this.form = this.data
        console.log("this.form.postes=>", this.data);
        this.validationsData = ["client", "interne", "operationnel", "GrosClient"]

        // this.posteSelect = this.form.modelslisting.split(",");
        // console.log("this.form.postes=>", this.posteSelect);

    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.form.modelslisting = this.posteSelect.join(",");
            this.axios.post('/api/homezones/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/homezones/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        addmodelslistings(data) {

            const clickedDate = data.Selectvalue;


            const index = this.posteSelect.indexOf(clickedDate);
            if (index > -1) {
                // Si la date est déjà sélectionnée, la supprimer du tableau
                // this.selectedDates.splice(index, 1);
            } else {
                // Si la date n'est pas déjà sélectionnée, l'ajouter au tableau
                this.posteSelect.push(clickedDate);
            }


            // this.posteSelect.push(data.Selectvalue);
            this.$toast.success("Operation effectuer avec succes");
        },
        deletemodellisting(data) {
            const clickedDate = data.Selectvalue;

            const index = this.posteSelect.indexOf(clickedDate);
            if (index > -1) {
                this.posteSelect.splice(index, 1);
                this.tableKey++;
                this.$toast.success("Operation effectuer avec succes");
            }
        },
        finishaddmodelslistingsadd() {
            if (this.posteSelect.length != this.lastPosteSelectCount) {
                this.lastPosteSelectCount = this.posteSelect.length;
                this.tableKey++;
            }
            this.$bvModal.hide(this.formId);
        },
        onGridReady(params) {
            console.log("on demarre", params);
            this.gridApi1 = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false;
            this.calendarKey++; // Incrémente la valeur de calendarKey pour forcer le rendu du composant <FullCalendar>
        },
        showForm(type, data, gridApi, width = 'lg') {
            this.formKey++
            this.formWidth = width
            this.formState = type
            this.formData = data
            this.formGridApi = gridApi
            this.$bvModal.show(this.formId)
        },
        openCreate() {
            this.showForm("Create", {}, this.gridApi, "lg");
        },
    }
}
</script>
