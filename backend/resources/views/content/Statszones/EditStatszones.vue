<template>
    <b-overlay :show="isLoading">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Create'">Ajouter des plannification</div>
            </template>
            <div v-if="formState == 'Create'">
                <AgGridSearch :columnDefs="columnDefs" :filterFields="['Libelle', 'faction']" :url="url"
                              @destruction="finishAddPlanification">
                </AgGridSearch>
            </div>
            <template #modal-footer>
                <div></div>
                <button v-if="formState == 'Create'" class="btn btn-primary" type="button"
                        @click.prevent="finishAddPlanification()">
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
            </template>
        </b-modal>
        <form @submit.prevent="EditLine()">
            <div class="mb-3">

                <!-- <div v-for="i in [1,2,3]" class="row">
                    <div class="form-group col-sm-4">
                        <label>nom {{ i }} </label>
                        <input v-model="form[`nom${i}`]" :class="errors.nom1?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.nom1" class="invalid-feedback">
                            <template v-for=" error in errors.nom1"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>modelslistings {{ i }} jour </label>
                        <CustomSelect
                            :key="form[`modelslistingjour${i}`]"
                            :columnDefs="['Libelle','faction']"
                            :oldValue="form[`modelslistingjour${i}`]"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>{form[`modelslistingjour${i}_id`]=data.id;form[`modelslistingjour${i}`]=data}"
                            :url="`${axios.defaults.baseURL}/api/modelslistings-Aggrid`"
                            filter-key=""
                            filter-value=""
                        />
                        <div v-if="errors.modelslisting_id" class="invalid-feedback">
                            <template v-for=" error in errors.modelslisting_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>modelslistings {{ i }} nuit </label>
                        <CustomSelect
                            :key="form[`modelslistingnuit${i}`]"
                            :columnDefs="['Libelle','faction']"
                            :oldValue="form[`modelslistingnuit${i}`]"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>{form[`modelslistingnuit${i}_id`]=data.id;form[`modelslistingnuit${i}`]=data}"
                            :url="`${axios.defaults.baseURL}/api/modelslistings-Aggrid`"
                            filter-key=""
                            filter-value=""
                        />
                        <div v-if="errors.modelslisting_id" class="invalid-feedback">
                            <template v-for=" error in errors.modelslisting_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div> -->

                <div v-for="i in [1, 2, 3]" class="row">
                    <div class="form-group col-sm-4">
                        <label>nom {{ i }} </label>
                        <input v-model="form[`nom${i}`]"
                               :class="errors.nom1 ? 'form-control is-invalid' : 'form-control'"
                               type="text">

                        <div v-if="errors.nom1" class="invalid-feedback">
                            <template v-for=" error in errors.nom1"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="form-group col-sm-4">

                        <button v-b-tooltip.hover
                                :style="actualPage == `modelslistingjour${i}` ? 'border:3px solid  green' : ''"
                                class="btn mt-2"
                                style="" @click.prevent="togglePage(`modelslistingjour${i}`)">
                            <div class="iconParent">

                                <span> <i class="fa-solid fa-filter"></i> modelslistings {{ i }} jour </span>

                            </div>
                        </button>
                    </div>
                    <div class="form-group col-sm-4">

                        <button v-b-tooltip.hover
                                :style="actualPage == `modelslistingnuit${i}` ? 'border:3px solid  green' : ''"
                                class="btn mt-2"
                                style="" @click.prevent="togglePage(`modelslistingnuit${i}`)">
                            <div class="iconParent">

                                <span> <i class="fa-solid fa-filter"></i> modelslistings {{ i }} nuit </span>

                            </div>
                        </button>
                    </div>
                    <div v-if="actualPage === `modelslistingjour${i}` || actualPage === `modelslistingnuit${i}`"
                         class="col-sm-12">
                        <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs2"
                                     :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache"
                                     :pagination="pagination"
                                     :paginationPageSize="paginationPageSize" :rowData="rowData"
                                     :rowModelType="rowModelType"
                                     :showExport="false" :url="url" className="ag-theme-alpine"
                                     domLayout='autoHeight'
                                     rowSelection="multiple" @gridReady="onGridReady">
                            <template #header_buttons>
                                <div class="btn btn-primary" @click="openCreate"><i class="fa fa-plus"></i> Nouveau
                                </div>
                            </template>

                        </AgGridTable>

                    </div>
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
import AgGridTable from "@/components/AgGridTable.vue"
import AgGridSearch from "@/components/AgGridSearch.vue";

export default {
    name: 'EditStatszones',
    components: {CustomSelect, AgGridSearch, AgGridTable, Files},
    props: ['data', 'gridApi', 'modalFormId',
        'modelslistingsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                nom1: "",

                modelslisting_id: "",

                modelslistingjour1_id: "",

                nom2: "",

                modelslistingnuit2_id: "",

                modelslistingjour2_id: "",

                nom3: "",

                modelslistingnuit3_id: "",

                modelslistingjour3_id: "",

                creat_by: "",

                modelslistingnuit1: "",

                modelslistingjour1: "",

                modelslistingnuit2: "",

                modelslistingjour2: "",

                modelslistingnuit3: "",

                modelslistingjour3: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            },

            actualPage: '',
            formId: "statszones",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/statszones-Aggrid',
            table: 'statszones',
            modelslistingsData: [],
            requette: 1,
            columnDefs: null,
            columnDefs2: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            posteSelect: [],
            lastPosteSelectCount: 0,
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
        },
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/modelslistings-Aggrid',
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

                    width: 60,
                    pinned: "left",
                    suppressColumnsToolPanel: true,
                    sortable: false,
                    headerName: "",
                    cellRendererSelector: (params) => {
                        let response = {
                            component: "AgGridBtnClicked",
                            params: {
                                clicked: (field) => {
                                    this.addPlanification(field);
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa fa-plus"></i></div>`,
                                // render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                            },
                        };
                        return response;
                    },
                },

                {
                    field: "Libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },


                {
                    field: "faction",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'faction',
                },

            ];

        this.columnDefs2 =
            [
                {
                    field: null,

                    width: 60,
                    pinned: "left",
                    suppressColumnsToolPanel: true,
                    sortable: false,
                    headerName: "",
                    cellRendererSelector: (params) => {
                        let response = {
                            component: "AgGridBtnClicked",
                            params: {
                                clicked: (field) => {
                                    this.deletPlanification(field);
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa fa-plus"></i></div>`,
                                // render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                            },
                        };
                        return response;
                    },
                },

                {
                    field: "Libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },


                {
                    field: "faction",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'faction',
                },

            ];
    },
    mounted() {
        this.form = this.data
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
        EditLine() {
            // this.form[this.actualPage] = this.posteSelect.join(",");
            this.isLoading = true
            this.axios.post('/api/statszones/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/statszones/' + this.form.id + '/delete').then(response => {
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
        togglePage(page) {

            this.actualPage = page
            if (this.form[this.actualPage]) {
                this.posteSelect = this.form[this.actualPage].split(",");
            } else {
                this.posteSelect = []
            }

            this.finishAddPlanification();
            console.log('page', this.posteSelect)

        },
        finishAddPlanification() {
            if (this.posteSelect.length != this.lastPosteSelectCount) {
                this.lastPosteSelectCount = this.posteSelect.length;
                this.tableKey++;
            }
            this.$bvModal.hide(this.formId);
        },
        addPlanification(data) {

            const clickedDate = data.Selectvalue;


            const index = this.posteSelect.indexOf(clickedDate);
            if (index > -1) {
                // Si la date est déjà sélectionnée, la supprimer du tableau
                // this.selectedDates.splice(index, 1);
            } else {
                // Si la date n'est pas déjà sélectionnée, l'ajouter au tableau
                this.posteSelect.push(clickedDate);
            }

            this.form[this.actualPage] = this.posteSelect.join(",");
            this.isLoading = true
            this.axios.post('/api/statszones/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
            // this.posteSelect.push(data.Selectvalue);
            this.$toast.success("Operation effectuer avec succes");


        },
        deletPlanification(data) {
            const clickedDate = data.Selectvalue;

            const index = this.posteSelect.indexOf(clickedDate);
            if (index > -1) {
                this.posteSelect.splice(index, 1);
                this.form[this.actualPage] = this.posteSelect.join(",");
                this.isLoading = true
                this.axios.post('/api/statszones/' + this.form.id + '/update', this.form).then(response => {
                    this.isLoading = false
                    this.gridApi.applyServerSideTransaction({
                        update: [
                            response.data
                        ],
                    });
                }).catch(error => {
                    this.errors = error.response.data.errors
                    this.isLoading = false
                    this.$toast.error('Erreur survenue lors de l\'enregistrement')
                })
                this.tableKey++;
                this.$toast.success("Operation effectuer avec succes");
            }
        },
    }
}
</script>
