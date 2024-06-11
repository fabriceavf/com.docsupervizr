<template>
    <div class="row">

        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Homezones #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Homezones</div>
            </template>

            <EditHomezones v-if="formState == 'Update'" :key="formKey" :data="formData" :gridApi="formGridApi"
                           :modalFormId="formId" @close="closeForm"/>


            <CreateHomezones v-if="formState == 'Create'" :key="formKey" :data="formData" :gridApi="formGridApi"
                             :modalFormId="formId"
                             @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>

        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData"
                         :rowModelType="rowModelType"
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
import CreateHomezones from './CreateHomezones.vue'
import EditHomezones from './EditHomezones.vue'
import CustomSelect from "@/components/CustomSelect.vue"
import DataModal from '@/components/DataModal.vue'
import moment from 'moment'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'HomezonesView',
    components: {
        DataTable,
        AgGridTable,
        CreateHomezones,
        EditHomezones,
        DataModal,
        AgGridBtnClicked,
        CustomSelect,
    },
    props: ['UsersData'],
    data() {

        return {
            formId: "homezones",
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
            form: {

                id: "",

                modelslisting_id: "",

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
            params["modelslisting_id"] = {values: [this.UsersData], filterType: "set"};
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
        this.url = this.axios.defaults.baseURL + '/api/homezones-Aggrid',
            this.Modelslistingurl = this.axios.defaults.baseURL + '/api/modelslistings-Aggrid',
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
                // {
                //     field: "id",
                //     sortable: true,
                //     filter: 'agTextColumnFilter',
                //     filterParams: {suppressAndOrCondition: true,},
                //     hide: true,
                //     headerName: '#Id',
                // },
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
                                    this.showForm('Update', field, params.api)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },
                {
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter',
                    filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },
                {
                    field: "type",
                    sortable: true,
                    filter: 'agTextColumnFilter',
                    filterParams: {suppressAndOrCondition: true,},
                    headerName: 'type',
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

            //
            // {
            //     field: "date",
            //     sortable: true,
            //     filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            //     headerName: 'date',
            // },

            // {
            //     headerName: 'faction',
            //     field: 'faction.Selectlabel',
            // },
            // {
            //     hide: true,
            //     suppressColumnsToolPanel: true,

            //     headerName: 'faction',
            //     field: 'faction',
            //     valueFormatter: params => {
            //         let retour = ''
            //         try {
            //             return params.data['faction']['Selectlabel']
            //         } catch (e) {

            //         }
            //         return retour
            //     },

            //     filter: 'agSetColumnFilter',
            //     filterParams: {
            //         suppressAndOrCondition: true,
            //         keyCreator: params => params.value.id,
            //         valueFormatter: params => params.value.Selectlabel,
            //         values: params => {
            //             params.success(this.factionsData);
            //         },
            //         refreshValuesOnOpen: true,
            //     },
            // },

            // {
            //     field: "postes",
            //     sortable: true,
            //     filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            //     headerName: 'postes',
            // },

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
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        // this.getzones();

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
        addmodelslistings(element) {
            console.log("voici les donnees ===>", element);
            this.form.zone_id = element.id
            this.form.modelslisting_id = this.UsersData
            this.axios.post('/api/homezones', this.form).then(response => {
                this.isLoading = false;
                this.Modelslistingsadd++;
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
            this.axios.post('/api/homezones/' + element.id + '/delete').then(response => {
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
        finishaddmodelslistingsadd() {
            // evenement appeler lorsquon ferme le formulaire dajout des agents
            // on verifie si on ajouter des agents et on met a jour le tableau sinon on ne fait rien
            if (this.Modelslistingsadd > 0) {
                this.tableKey++;
            }
            this.Modelslistingsadd = 0;
            this.Modelslistingsadd = 0;
            this.$bvModal.hide(this.formId);
        },
    }
}
</script>
