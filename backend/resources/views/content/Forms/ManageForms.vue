<template>
    <b-overlay :show="isLoading">

        <b-modal :id="formId" :size="formWidth" centered>
            <template #modal-title>
                <div v-if="formState == 'Create'">Ajouter des parents</div>
            </template>

            <div v-if="formState=='Create'">

                <AgGridSearch
                    :columnDefs="add.columnDefs"
                    :filterFields="['code','libelle']"
                    :url="add.url"
                    @destruction="finishAddChild"
                >

                </AgGridSearch>
            </div>
            <div v-if="formState=='ShowForm'">
                <ManageForms
                    :key="formKey"
                    :data="formData"
                    :gridApi="formGridApi"
                    :modalFormId="formId"
                />
            </div>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <form>
            <div class="mb-3">


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>description </label>
                    <input v-model="form.description"
                           :class="errors.description?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.description" class="invalid-feedback">
                        <template v-for=" error in errors.description"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Listes des champs </label>
                            <FormschampsView :key="tableKey" :champsSelect="champsSelect"
                                             :newChamp="newChamp"></FormschampsView>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Listes des liaisons </label>
                            <AgGridTable
                                :key="tableKey1"
                                :cacheBlockSize="cacheBlockSize"
                                :columnDefs="columnDefs"
                                :extrasData="extrasData"
                                :maxBlocksInCache="maxBlocksInCache"
                                :pagination="pagination"
                                :paginationPageSize="paginationPageSize"
                                :rowData="rowData"
                                :rowModelType="rowModelType"
                                :sideBar="false"
                                :url="url"
                                className="ag-theme-alpine"
                                domLayout='autoHeight'
                                rowSelection="multiple"
                                @gridReady="onGridReady"

                            >
                                <template #header_buttons>
                                    <div class="btn btn-primary" @click="openCreate"><i
                                        class="fa fa-plus"></i> Nouveau
                                    </div>
                                </template>

                            </AgGridTable>
                        </div>
                    </div>
                </div>


            </div>

            <template v-if="form.id!=0">

                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary" @click.prevent="EditLine()">
                        <i class="fas fa-floppy-disk"></i> Mettre à jour
                    </button>
                    <button class="btn btn-primary" @click.prevent="ShowLine()">
                        <i class="fas fa-floppy-disk"></i> Tester
                    </button>
                    <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                        <i class="fas fa-close"></i> Supprimer
                    </button>
                </div>

            </template>
            <template v-else>

                <button class="btn btn-primary" @click.prevent="createLine()">
                    <i class="fas fa-floppy-disk"></i> Créer
                </button>
            </template>

        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import AgGridSearch from "@/components/AgGridSearch.vue";
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import FormschampsView from "./Formschamps/FormschampsView.vue";

export default {
    name: 'ManageForms',
    components: {
        VSelect,
        CustomSelect,
        Files,
        FormschampsView,
        AgGridSearch,
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked
    },
    props: [
        'gridApi',
        'modalFormId',
        'data'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                description: "",

                childs: "",

                champs: "",

                extra_attributes: "",

                creat_by: "",

                deleted_at: "",

                created_at: "",

                updated_at: "",
            },
            champsSelect: [],
            childSelect1: [],
            childSelect: [],
            tableKey: 0,
            tableKey1: 0,
            formId: "forms",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            url: 'http://127.0.0.1:8000/api/forms-Aggrid',
            table: 'forms',
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
    computed: {
        extrasData: function () {
            let params = {}
            params['id'] = {values: this.childSelect, filterType: 'set'}
            return {'baseFilter': params}
        },
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/forms-Aggrid';
        this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        this.add.url = this.axios.defaults.baseURL + '/api/forms-Aggrid';
        this.add.rowBuffer = 0;
        this.add.rowModelType = 'serverSide';
        this.add.cacheBlockSize = 50;
        this.add.maxBlocksInCache = 2;
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
                                this.deleteChild(field)
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#bc1010;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash "></i></div>`
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
                                this.addChild(field)
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
    mounted() {
        if (this.data.id) {
            this.form = this.data
            this.champsSelect = this.form.champs.split(',')
            this.childSelect = this.form.childs.split(',')
            this.childSelect1 = this.childSelect
        }
    },
    methods: {
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
        createLine() {
            this.form.champs = this.champsSelect.join(',')
            this.form.childs = this.childSelect.join(',')
            this.isLoading = true
            this.axios.post('/api/forms', this.form).then(response => {
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
        EditLine() {

            this.form.champs = this.champsSelect.join(',')
            this.form.childs = this.childSelect.join(',')
            this.isLoading = true
            this.axios.post('/api/forms/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/forms/' + this.form.id + '/delete').then(response => {
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
        ShowLine() {
            this.showForm('ShowForm', this.form, this.gridApi)
        },
        resetForm() {
            this.form = {
                id: "",
                libelle: "",
                description: "",
                childs: "",
                champs: "",
                extra_attributes: "",
                creat_by: "",
                deleted_at: "",
                created_at: "",
                updated_at: "",
            }
        },
        newChamp(data) {
            console.log('on as un nouveau champs', data)
            this.champsSelect.push(data.id)
            this.tableKey++
        },
        onGridReady(params) {
            console.log('on demarre', params)
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false
        },
        finishAddChild() {
            this.childSelect = this.childSelect1
            this.tableKey1++

            // if (this.posteSelect.length != this.lastPosteSelectCount) {
            //     this.lastPosteSelectCount = this.posteSelect.length
            // }
        },
        addChild(data) {
            this.childSelect1.push(data.id)
            this.$toast.success('Operation effectuer avec succes')
        },
        deleteChild(data) {
            this.childSelect1 = this.childSelect1.filter(id => data.id != id)
            this.$toast.success('Operation effectuer avec succes')

            this.finishAddChild()
        },
    }
}
</script>
