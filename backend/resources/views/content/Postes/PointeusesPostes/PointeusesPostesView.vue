<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Pointeuses #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Pointeuses</div>
            </template>


            <div v-if="formState == 'Create'">
                <AgGridSearch
                    :columnDefs="columnDefs2"
                    :filterFields="['code', 'libelle']"
                    :url="url2"
                    @destruction="finishAddPointeuse"
                >
                </AgGridSearch>
            </div>
            <template #modal-footer>
                <div></div>
                <button
                    v-if="formState == 'Create'"
                    class="btn btn-primary"
                    type="button"
                    @click.prevent="finishAddPointeuse()"
                >
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
            </template>
        </b-modal>

        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData"
                         :rowModelType="rowModelType" :url="url" className="ag-theme-alpine"
                         domLayout='autoHeight' rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>
                    <div v-if="!$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> ajouter une pointeuse
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CustomSelect from "@/components/CustomSelect.vue"
import CustomFiltre from "@/components/CustomFiltre.vue"
import AgGridSearch from "@/components/AgGridSearch.vue";
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'PointeusesView',
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridSearch,
        AgGridBtnClicked,
        CustomSelect,
        CustomFiltre
    },
    props: ["parentId"],

    data() {

        return {
            formId: "pointeuses",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/postespointeuses-Aggrid',
            table: 'pointeuses',
            sitesData: [],
            zonesget: [],
            zoneselectionner: [],
            supervirzclientsData: [],
            requette: 2,
            columnDefs2: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            week: null,
        }
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
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },
        taille: function () {
            let result = 'col-sm-12'
            if (this.filtre) {
                result = 'col-sm-9'
            }
            return result
        },
        columnDefs: function () {
            let columnDefs = [
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
                                    this.deletePoste(field)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`,
                                // render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-raduis:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },

                // {
                //     headerName: 'zone',
                //     field: 'site.zone.Selectlabel',
                // },
                {
                    headerName: 'libelle',
                    field: 'pointeuse.Selectlabel',
                },
                {

                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'pointeuse',
                    field: 'pointeuse_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['pointeuse']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },

                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/pointeuses-Aggrid',
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
                //     headerName: 'client',
                //     field: 'site.client.Selectlabel',
                // },
                // {
                //     field: "code",
                //     sortable: true,
                //     maxWidth: 120,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'code',
                // },

                // {
                //     field: "libelle",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'libelle',
                // },

                // {

                //     maxWidth: 100,
                //     field: "lun",
                //     sortable: true,
                //     // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'lun',
                // },


                // {
                //     maxWidth: 100,
                //     field: "mar",
                //     sortable: true,
                //     // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'mar',
                // },


                // {
                //     maxWidth: 100,
                //     field: "mer",
                //     sortable: true,
                //     // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'mer',
                // },


                // {
                //     maxWidth: 100,
                //     field: "jeu",
                //     sortable: true,
                //     // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'jeu',
                // },


                // {
                //     maxWidth: 100,
                //     field: "ven",
                //     sortable: true,
                //     // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'ven',
                // },


                // {
                //     maxWidth: 100,
                //     field: "sam",
                //     sortable: true,
                //     // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'sam',
                // },


                // {
                //     maxWidth: 100,
                //     field: "dim",
                //     sortable: true,
                //     // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'dim',


                // },

            ]
            return columnDefs;
        },
        extrasData: function () {

            let params = {baseFilter: {}};
            params["baseFilter"]["poste_id"] = {
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
        this.url = this.axios.defaults.baseURL + '/api/postespointeuses-Aggrid',
            (this.url2 = this.axios.defaults.baseURL + "/api/pointeuses-Aggrid"),
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

    },
    beforeMount() {


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.zonesget = this.$routeData.meta.zonesGet

    },
    beforeMount() {
        this.columnDefs2 = [
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
                                this.addPointeuse(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa fa-plus"></i></div>`,
                            // render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                        },
                    };
                    return response;
                },
            },


            {
                headerName: 'zone',
                field: 'site.zone.Selectlabel',
            },
            {
                headerName: 'site',
                field: 'site.Selectlabel',
            },
            {

                hide: true,
                suppressColumnsToolPanel: true,

                headerName: 'site',
                field: 'site_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['site']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: "CustomFiltre",
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/sites-Aggrid',
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
                headerName: 'client',
                field: 'site.client.Selectlabel',
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
    methods: {
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm("Create", {}, this.gridApi, "xl");
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

        getsupervirzclients() {
            this.axios.get('/api/supervirzclients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.supervirzclientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
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
        // finishAddPointeuse() {
        //     if (this.posteSelect.length != this.lastPosteSelectCount) {
        //         this.lastPosteSelectCount = this.posteSelect.length;
        //         console.log('this.gridApi.refreshCells')
        //     }
        //     this.$bvModal.hide(this.formId);
        // },
        finishAddPointeuse() {
            if (this.posteSelect.length != this.lastPosteSelectCount) {
                this.lastPosteSelectCount = this.posteSelect.length;
                this.tableKey++

            }
            this.$bvModal.hide(this.formId);
        },
        addPointeuse(data) {
            this.donne.poste_id = this.form.id;
            // this.donne.poste_id=this.parentId;
            this.donne.pointeuse_id = data.Selectvalue;

            console.log('data.Selectvalue', this.donne)
            // this.posteSelect.push(data.Selectvalue);
            // this.$toast.success("Operation effectuer avec succes");
            // this.posteSelect.push(data.Selectvalue);
            // this.$toast.success("Operation effectuer avec succes");

            this.isLoading = true
            this.axios.post('/api/postespointeuses', this.donne).then(response => {
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
        deletePoste(data) {

            const clickedDate = data.id;
            console.log('data=>', clickedDate)

            this.isLoading = true
            this.axios.post('/api/postespointeuses/' + clickedDate + '/delete').then(response => {
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
    }
}
</script>
