<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
            </template>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData" :rowModelType="rowModelType"
                         :showExport="false"
                         :sideBar="false" :url="url" className="ag-theme-alpine" domLayout='autoHeight'
                         rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>

                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import DataModal from '@/components/DataModal.vue'
import VSelect from "vue-select";
import CustomSelect from "@/components/CustomSelect.vue";
import CustomFiltre from "@/components/CustomFiltre.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'Details',
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked,
        VSelect,
        CustomFiltre,
        CustomSelect

    },
    data() {

        return {
            month: null,
            poste_id: null,
            formId: "Details",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/Details-Aggrid',
            table: 'Details',
            postesData: [],
            directionselectionner: [],
            directionsget: [],
            usersData: [],
            zonesget: [],
            zoneselectionner: [],
            requette: 1,
            // columnDefs: null,
            lignedebase: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 5,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
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
                if (typeof window.routeData != "undefined") {
                    router = window.routeData;
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
                    field: "durees",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'duree',
                },

            ];
            return columnDefs;
        },
        extrasData: function () {

            let params = {};
            if (!this.month && !this.poste_id) {
                params["id"] = {values: [0], filterType: "set"};
            } else {
                params["type_id"] = {values: [2, 3], filterType: "set"};

            }
            this.tableKey++;

            return {
                baseFilter: params,
                lignedebase: this.lignedebase,
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
        this.url = this.axios.defaults.baseURL + '/api/trajets-Aggrid',
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
        this.lignedebase = this.params.data.id
        console.log('parentId', this.params.data ? this.params.data.id : null)
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
        getpostes() {
            this.axios
                .get("/api/postes")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // // this.$store.commit('setIsLoading', false)
                    }
                    this.postesData = response.data;
                    // console.log('yannfiltreP=>', response.data)
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },
    }
}
</script>
