<template>
    <b-overlay :show="isLoading">
        <div v-for="erreur in Object.keys(errors)">
            <div v-for="message in Object.values(errors[erreur])">
                <b-alert show style="padding: 5px" variant="danger">{{ erreur }} : {{ message[0] }}</b-alert>

            </div>
        </div>


        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Modelslistings #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Modelslistings</div>
            </template>
            <div v-if="formState=='Create'">

                <AgGridSearch
                    :columnDefs="add.columnDefs"
                    :filterFields="['libelle']"
                    :url="add.url"
                    @destruction="finishAddPoste"
                >
                </AgGridSearch>
            </div>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <div>

            <div class="row">
                <div class="form-group col-sm-4">
                    <label>Libelle </label>
                    <input v-model="form.Libelle" :class="errors.Libelle ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.Libelle" class="invalid-feedback">
                        <template v-for=" error in errors.Libelle"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label>Faction </label>
                    <input v-model="form.faction" :class="errors.faction ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.faction" class="invalid-feedback">
                        <template v-for=" error in errors.faction"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group  col-sm-4">
                    <label>zones </label>
                    <CustomSelect
                        :key="form.zone"
                        :columnDefs="['libelle']"
                        :oldValue="form.zone"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.zone_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/zones-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.zone_id" class="invalid-feedback">
                        <template v-for=" error in errors.zone_id"> {{ error[0] }}</template>

                    </div>
                </div>
            </div>


            <div class="form-group">
                <label>Postes</label>
                <div class="col-sm-12">
                    <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                                 :extrasData="extrasData" :maxBlocksInCache="maxBlocksInCache"
                                 :pagination="pagination"
                                 :paginationPageSize="paginationPageSize" :rowData="rowData"
                                 :rowModelType="rowModelType"
                                 :show-export="false" :show-pagination="false" :url="url"
                                 className="ag-theme-alpine"
                                 dom-layout="normal" domLayout='autoHeight' rowSelection="multiple"
                                 @gridReady="onGridReady"
                                 @newData="newData">
                        <template #header_buttons>
                            <div class="btn btn-primary" @click="openCreate"><i
                                class="fa fa-plus"></i> Ajouter des postes
                            </div>
                        </template>
                    </AgGridTable>

                </div>
            </div>
        </div>
    </b-overlay>
</template>


<script>
import CustomSelect from "@/components/CustomSelect.vue";
import AgGridTable from "@/components/AgGridTable.vue"
import AgGridSearch from "@/components/AgGridSearch.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'CreateModelslistings',
    components: {
        VSelect, CustomSelect, Files, AgGridTable, AgGridSearch,
    },
    props: [
        'gridApi',
        'modalFormId',
        'actifsData',
        'balisesData',
        'categoriesData',
        'contratsData',
        'directionsData',
        'echelonsData',
        'factionsData',
        'fonctionsData',
        'matrimonialesData',
        'nationalitesData',
        'onlinesData',
        'postesData',
        'sexesData',
        'sitesData',
        'situationsData',
        'typesData',
        'usersData',
        'villesData',
        'zonesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                Libelle: "",
                faction: "",

                userFiltre: "",

                userMatricule: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",
            },
            defaultEntite: 'User',
            formId: "users",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/activites-Aggrid',
            table: 'users',
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
            agGridData: {},
            dateSelect: [],
            posteSelect: [],
            lastPosteSelectCount: 0,
            read: false,
            add: {
                formId: "listings",
                formState: "",
                formData: {},
                formWidth: 'lg',
                formGridApi: {},
                formKey: 0,
                tableKey: 0,
                url: 'http://127.0.0.1:8000/api/listings-Aggrid',
                table: 'Users',
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
    methods: {
        handleTabChange() {
            this.read = true;
        },
        onGridReady(params) {
            console.log('on demarre', params)
            this.gridApi1 = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false

        },
        newData(data) {
            console.log('voici la nouvelle data', data)
            this.agGridData = data
        },
        createLine() {
            this.isLoading = true
            // const model = this.gridApi1.getFilterModel();
            // console.log('model ===>', model)
            // let filter={
            //     query:this.agGridData.__allQuery,
            //     params:this.agGridData.__allQueryBindings,
            //     date:this.dateSelect,
            // }
            this.form.query = JSON.stringify(this.agGridData.__allQuery)
            this.form.params = JSON.stringify(this.agGridData.__allQueryBindings)
            this.form.date = JSON.stringify(this.dateSelect)
            this.form.postes = this.posteSelect.join(',')
            this.axios.post('/api/modelslistings', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
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
            }
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
        finishAddPoste() {
            if (this.posteSelect.length != this.lastPosteSelectCount) {
                this.lastPosteSelectCount = this.posteSelect.length
                this.tableKey++
            }
        },
        addAgent() {
        },
        addPoste(data) {
            this.posteSelect.push(data.id)
            this.$toast.success('Operation effectuer avec succes')
        },
        deleteAgent() {
        }

    },

    computed: {

        extrasData: function () {
            let params = {baseFilter: {}}
            params['baseFilter']['id'] = {values: this.posteSelect, filterType: 'set'}
            return params


        }
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/activites-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        let params = {}
        // params['type_id'] = {values: [2, 3], filterType: 'set'}
        // this.extrasData['baseFilter'] = params
        // this.extrasData['selectAllQuery'] = 1


        this.add.url = this.axios.defaults.baseURL + '/api/activites-Aggrid',
            this.add.rowBuffer = 0;
        this.add.rowModelType = 'serverSide';
        this.add.cacheBlockSize = 50;
        this.add.maxBlocksInCache = 2;

    },
    beforeMount() {
        this.columnDefs = [
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
                                this.showForm('Update', field, params.api, "xl")
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                        }
                    };
                },

            },


            {
                field: "libelle",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'libelle',
            },


        ];
        this.add.columnDefs = [

            {
                field: null,

                width: 100,
                pinned: 'left',
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: '',
                cellRendererSelector: params => {
                    let response = {
                        component: 'AgGridBtnClicked',
                        params: {
                            clicked: field => {
                                this.addPoste(field)
                            },

                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                        }
                    }
                    return response;
                },
            },


            {
                field: "libelle",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'libelle',
            },


        ];


    },
}
</script>
