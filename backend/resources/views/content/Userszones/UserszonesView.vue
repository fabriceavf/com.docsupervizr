<template>
    <div class="row">

        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Userszones #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Userszones</div>
            </template>

            <!-- <div > -->
            <AgGridSearch v-if="formState == 'Create'" :columnDefs="ZonecolumnDefs" :extrasData="extrasData"
                          :filterFields="[ 'libelle']" :sizeColumnsToFit="md" :url="Zoneurl" filter-key=""
                          filter-value="" @destruction="finishaddZones">
            </AgGridSearch>
            <!-- </div> -->

            <template #modal-footer>
                <!-- <div></div> -->
                <button v-if="formState == 'Create'" class="btn btn-primary" type="button"
                        @click.prevent="finishaddZones()">
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
            </template>
        </b-modal>

        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData"
                         :rowModelType="rowModelType" :showActu="false" :showExport="false"
                         :url="url" className="ag-theme-alpine" domLayout='autoHeight'
                         rowSelection="multiple" @gridReady="onGridReady">
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
import CreateUserszones from './CreateUserszones.vue'
import EditUserszones from './EditUserszones.vue'
import CustomSelect from "@/components/CustomSelect.vue"
import DataModal from '@/components/DataModal.vue'
import AgGridSearch from "@/components/AgGridSearch.vue"
import moment from 'moment'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'UserszonesView',
    components: {
        DataTable,
        AgGridTable,
        CreateUserszones,
        EditUserszones,
        DataModal,
        AgGridBtnClicked,
        CustomSelect,
        AgGridSearch,
    },
    props: ['UsersData'],
    data() {

        return {
            formId: "userszones",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/userszones-Aggrid',
            table: 'userszones',
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
            Zonesadd: 0,
            form: {

                id: "",

                user_id: "",

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
            let params = {};
            params["user_id"] = {values: [this.UsersData], filterType: "set"};
            return {
                baseFilter: params,

            }


        }
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
        this.url = this.axios.defaults.baseURL + '/api/userszones-Aggrid',
            this.Zoneurl = this.axios.defaults.baseURL + '/api/zones-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

        (this.add.url = this.axios.defaults.baseURL + "/api/zones-Aggrid"),
            (this.add.rowBuffer = 0);
        this.add.rowModelType = "serverSide";
        this.add.cacheBlockSize = 50;
        this.add.maxBlocksInCache = 2;

    },
    beforeMount() {
        this.columnDefs =
            [
                {
                    field: "id",
                    sortable: true,
                    filter: 'agTextColumnFilter',
                    filterParams: {suppressAndOrCondition: true,},
                    hide: true,
                    headerName: '#Id',
                },
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
                                render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`
                            }
                        };
                    },

                },

                {
                    headerName: 'zone',
                    field: 'zone.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'zone',
                    field: 'zone_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['zone']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },

                    filter: 'agSetColumnFilter',
                    filterParams: {
                        suppressAndOrCondition: true,
                        keyCreator: params => params.value.id,
                        valueFormatter: params => params.value.Selectlabel,
                        values: params => {
                            params.success(this.zonesData);
                        },
                        refreshValuesOnOpen: true,
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

        this.ZonecolumnDefs = [
            {
                field: null,

                width: 40,
                pinned: "left",
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: "",
                cellRendererSelector: (params) => {
                    let response = {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.addzones(field);
                            },

                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-add "></i></div>`,
                        },
                    };
                    return response;
                },
            },


            {
                field: "libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "libelle",
            },

        ];
    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        this.getzones();

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
        getzones() {
            this.axios.get('/api/zones').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.zonesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        addzones(element) {
            console.log("voici les donnees ===>", element);
            this.form.zone_id = element.id
            this.form.user_id = this.UsersData
            this.axios.post('/api/userszones', this.form).then(response => {
                this.isLoading = false;
                this.Zonesadd++;
                this.$toast.success("Operation effectuer avec succes");
                // this.$emit("close");
                // console.log(response.data);
            })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    this.isLoading = false;
                    this.$toast.error(
                        "Erreur survenue lors de l'enregistrement"
                    );
                });
        },
        DeleteLine(element) {
            this.isLoading = true
            this.axios.post('/api/userszones/' + element.id + '/delete').then(response => {
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
        finishaddZones() {
            // evenement appeler lorsquon ferme le formulaire dajout des agents
            // on verifie si on ajouter des agents et on met a jour le tableau sinon on ne fait rien
            if (this.Zonesadd > 0) {
                this.tableKey++;
            }
            this.Zonesadd = 0;
            this.Zonesadd = 0;
            this.$bvModal.hide(this.formId);
        },
    }
}
</script>
