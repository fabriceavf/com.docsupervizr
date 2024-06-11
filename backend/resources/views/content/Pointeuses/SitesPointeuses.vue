<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Create'">Ajouter des sites</div>
            </template>
            <div v-if="formState == 'Create'">
                <AgGridSearch
                    :columnDefs="add.columnDefs"
                    :filterFields="['libelle','zone.libelle','client.libelle']"
                    :url="add.url"
                    @destruction="finishAddPointeuse"
                >
                </AgGridSearch>
            </div>
            <template #modal-footer>
                <div>
                    <button
                        v-if="formState == 'Create'"
                        class="btn btn-primary"
                        type="button"
                        @click.prevent="finishAddPointeuse()"
                    >
                        <i class="fas fa-floppy-disk"></i> Valider
                    </button>
                </div>
            </template>
        </b-modal>


        <div class="col-sm-12">
            <div class="form-group">
                <label>Site</label>
                <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                             :extras-data="extrasData"
                             :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                             :paginationPageSize="paginationPageSize" :rowData="rowData"
                             :rowModelType="rowModelType" :show-export="false" :show-pagination="false"
                             :sideBar="false"
                             :url="url" className="ag-theme-alpine" dom-layout="normal" domLayout='autoHeight'
                             rowSelection="multiple" @gridReady="onGridReady">
                    <template #header_buttons>
                        <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                            class="fa fa-plus"></i> Nouveau
                        </div>
                    </template>

                </AgGridTable>

            </div>
        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import DataModal from '@/components/DataModal.vue'
import moment from 'moment'
import AgGridSearch from "@/components/AgGridSearch.vue";
import CustomSelect from "@/components/CustomSelect.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'SitesView',
    components: {DataTable, AgGridTable, AgGridSearch, CustomSelect, DataModal, AgGridBtnClicked},
    props: ["pointeuseSelect"],
    data() {

        return {
            formId: "sites",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/sitespointeuses-Aggrid',
            table: 'sites',
            requette: 0,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            form: {
                id: "",

                site_id: "",

                pointeuse_id: "",

                retirer: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",
            },
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
            let params = {}
            params["pointeuse_id"] = {values: [this.pointeuseSelect], filterType: "set"};

            return {
                baseFilter: params,
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
        this.url = this.axios.defaults.baseURL + '/api/sitespointeuses-Aggrid',
            this.add.url = this.axios.defaults.baseURL + "/api/sites-Aggrid"
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
                    headerName: '',
                    suppressCellSelection: true,
                    minWidth: 80, maxWidth: 80,
                    pinned: 'left',
                    cellRendererSelector: params => {
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.DeleteLine(field)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`,
                            }
                        };
                    },

                },


                {
                    field: "site.Selectlabel",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'site',
                },
                {
                    field: "created_at",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Attribué le',
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
                {
                    field: "deleted_at",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Retiré le',
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


                // {
                //     field: "identifiants_sadge",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'identifiants_sadge',
                // },


                // {
                //     field: "creat_by",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'creat_by',
                // },


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
                                this.createLine(field);
                            },

                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                        },
                    };
                    return response;
                },
            },

            {
                field: "libelle",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'libelle',
            },


            {
                headerName: 'client',
                field: 'client.Selectlabel',
            },


            {
                headerName: 'zone',
                field: 'zone.Selectlabel',
            },
        ];

    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }


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
            this.gridApi.sizeColumnsToFit();

        },
        createLine(data) {
            this.isLoading = true
            this.form.site_id = data.Selectvalue
            this.form.pointeuse_id = this.pointeuseSelect
            this.axios.post('/api/sitespointeuses', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })

        },
        DeleteLine(data) {
            this.isLoading = true;
            this.axios
                .post("/api/sitespointeuses/" + data.Selectvalue + "/delete")
                .then((response) => {
                    this.isLoading = false;

                    this.gridApi.applyServerSideTransaction({
                        remove: [this.form],
                    });
                    this.gridApi.refreshServerSide();
                    // this.$bvModal.hide(this.modalFormId);
                    this.$toast.success("Operation effectuer avec succes");
                    // this.$emit("close");
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error.response.data);
                    this.isLoading = false;
                    this.$toast.error("Erreur survenue lors de la suppression");
                });
        },
        finishAddPointeuse() {
            this.$emit('siteId', this.form.site_id)
            this.tableKey++;
            this.$bvModal.hide(this.formId);
        },
    }
}
</script>
