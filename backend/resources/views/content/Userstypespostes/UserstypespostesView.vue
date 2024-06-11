<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Userstypespostes #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Userstypespostes</div>
            </template>

            <EditUserstypespostes v-if="formState == 'Update'" :key="formKey" :data="formData"
                                  :gridApi="formGridApi"
                                  :modalFormId="formId" :typesposteData="typesposteData" :usersData="usersData"
                                  @close="closeForm"/>

            <div v-if="formState == 'Create'">
                <AgGridSearch :columnDefs="columnDefs2" :filterFields="['code', 'libelle']" :url="url2"
                              @destruction="finishAddPointeuse">
                </AgGridSearch>
            </div>
            <!-- <CreateUserstypespostes
                v-if="formState=='Create'"
                :key="formKey"
                :typesposteData="typesposteData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :usersData="usersData"
                @close="closeForm"
            /> -->

            <template #modal-footer>
                <div></div>
                <button v-if="formState == 'Create'" class="btn btn-primary" type="button"
                        @click.prevent="finishAddPointeuse()">
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
            </template>
        </b-modal>


        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache"
                         :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData" :rowModelType="rowModelType"
                         :showActu="false"
                         :showExport="false"
                         :url="url" className="ag-theme-alpine" domLayout='autoHeight' rowSelection="multiple"
                         @gridReady="onGridReady">
                <template #header_buttons>
                    <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> Nouveau
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateUserstypespostes from './CreateUserstypespostes.vue'
import EditUserstypespostes from './EditUserstypespostes.vue'
import CustomSelect from "@/components/CustomSelect.vue"
import CustomFiltre from "@/components/CustomFiltre.vue"
import DataModal from '@/components/DataModal.vue'
import AgGridSearch from "@/components/AgGridSearch.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'UserstypespostesView',
    components: {
        DataTable,
        AgGridTable,
        CreateUserstypespostes,
        EditUserstypespostes,
        DataModal,
        AgGridBtnClicked,
        CustomSelect,
        AgGridSearch,
        CustomFiltre
    },
    props: ["parentId"],
    data() {

        return {
            formId: "userstypespostes",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/userstypespostes-Aggrid',
            table: 'userstypespostes',
            typesposteData: [],
            usersData: [],
            requette: 2,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            columnDefs2: null,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            posteSelect: [],
            lastPosteSelectCount: 0,
            form: {

                id: "",

                user_id: "",

                typesposte_id: "",

                creat_by: "",

                extra_attributes: "",

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
            params["baseFilter"]["user_id"] = {
                values: [this.parentId],
                filterType: "set",
            };
            return params;
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
        this.url = this.axios.defaults.baseURL + '/api/userstypespostes-Aggrid',
            (this.url2 = this.axios.defaults.baseURL + "/api/typespostes-Aggrid"),
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
                                    // this.showForm('Update', field, params.api)
                                    this.deleteGraphique(field)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`
                                // render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-raduis:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },


                // {
                //     field: "creat_by",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
                //     headerName: 'creat_by',
                // },


                {
                    headerName: 'typesposte',
                    field: 'typesposte.Selectlabel',
                },
                {

                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'typesposte',
                    field: 'typesposte_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['typesposte']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },

                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/typespostes-Aggrid',
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
                //     headerName: 'user',
                //     field: 'user.Selectlabel',
                // },
                // {

                //     hide: true,
                //     suppressColumnsToolPanel: true,

                //     headerName: 'user',
                //     field: 'user_id',
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['user']['Selectlabel']
                //         } catch (e) {

                //         }
                //         return retour
                //     },

                //     filter: "CustomFiltre",
                //     filterParams: {
                //         url: this.axios.defaults.baseURL + '/api/users-Aggrid',
                //         columnDefs: [
                //             {
                //                 field: "",
                //                 sortable: true,
                //                 filter: "agTextColumnFilter",
                //                 filterParams: { suppressAndOrCondition: true },
                //                 headerName: "",
                //                 cellStyle: { fontSize: '11px' },
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

            ];
        this.columnDefs2 = [
            {
                field: null,

                minWidth: 80, maxWidth: 80,
                pinned: "left",
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: "",
                cellRendererSelector: (params) => {
                    let response = {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.addgraphique(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa fa-plus"></i></div>`,
                            // render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                        },
                    };
                    return response;
                },
            },

            {
                field: "code",
                sortable: true,
                maxWidth: 120,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'code',
            },

            {
                field: "libelle",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'libelle',
            }

        ];

    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getgraphiques();
        // this.getusers();

    },
    methods: {
        finishAddPointeuse() {
            if (this.posteSelect.length != this.lastPosteSelectCount) {
                this.lastPosteSelectCount = this.posteSelect.length;
                this.tableKey++

            }
            this.$bvModal.hide(this.formId);
        },
        addgraphique(data) {
            this.form.user_id = this.parentId;
            this.form.typesposte_id = data.Selectvalue;

            console.log('data.Selectvalue', this.form)

            this.isLoading = true
            this.axios.post('/api/userstypespostes', this.form).then(response => {
                this.isLoading = false
                // this.resetForm()
                // this.gridApi.applyServerSideTransaction({
                //     add: [
                //         response.data
                //     ],
                // });
                // this.gridApi.refreshServerSide()
                // this.$bvModal.hide(this.modalFormId)
                // Ajouter la nouvelle pointeuse au tableau form.pointeuses
                this.posteSelect.push(response.data);

                this.$toast.success('Operation effectuer avec succes')
                // this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })

        },
        deleteGraphique(data) {

            const clickedDate = data.id;
            console.log('data=>', clickedDate)

            this.isLoading = true
            this.axios.post('/api/userstypespostes/' + clickedDate + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                // this.$emit('close')
                this.tableKey++

                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
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
        getgraphiques() {
            this.axios.get('/api/typespostes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.typesposteData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
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

    }
}
</script>
