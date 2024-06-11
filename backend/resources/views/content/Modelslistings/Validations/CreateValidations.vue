<template>
    <b-overlay :show="isLoading">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">
                    Update Modelslistings #{{ formData.id }}
                </div>
                <div v-if="formState == 'Create'">Create Modelslistings</div>
            </template>
            <div>
                <AgGridSearch v-if="formState == 'Create'" :columnDefs="addListing.columnDefs"
                              :extrasData="addListing.extrasData" :filterFields="['matricule', 'nom', 'prenom']"
                              :paginationPageSize="10"
                              :url="addListing.url" filter-key="type_id" filter-value="2,3"
                              @destruction="finishAddUser">
                </AgGridSearch>
            </div>

            <template #modal-footer>
                <!-- <div></div> -->
                <button v-if="formState == 'Create'" class="btn btn-primary" type="button"
                        @click.prevent="finishAddUser()">
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
            </template>
        </b-modal>
        <form @submit.prevent="createLine()">
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
                    <label>nombre de valideur </label>
                    <input v-model="form.nmbvalideurs"
                           :class="errors.nmbvalideurs?'form-control is-invalid':'form-control'"
                           min="1" type="number">

                    <div v-if="errors.nmbvalideurs" class="invalid-feedback">
                        <template v-for=" error in errors.nmbvalideurs"> {{ error[0] }}</template>

                    </div>
                </div>

            </div>
            <div class="col-sm-12">
                <AgGridTable
                    :key="tableKey"
                    :cacheBlockSize="cacheBlockSize"
                    :columnDefs="columnDefs"
                    :extrasData="extrasData"
                    :maxBlocksInCache="maxBlocksInCache"
                    :pagination="pagination"
                    :paginationPageSize="paginationPageSize"
                    :rowData="rowData"
                    :rowModelType="rowModelType"
                    :url="url"
                    className="ag-theme-alpine"
                    domLayout='autoHeight'
                    rowSelection="multiple"
                    @gridReady="onGridReady"

                >
                    <template #header_buttons>
                        <div class="btn btn-primary" @click="openCreate"><i
                            class="fa fa-plus"></i>
                            Ajouter un agent
                        </div>
                    </template>

                </AgGridTable>

            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> creer
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

import AgGridTable from "@/components/AgGridTable.vue"
import AgGridSearch from "@/components/AgGridSearch.vue";

export default {
    name: 'CreateValidations',
    components: {VSelect, CustomSelect, AgGridTable, AgGridSearch, Files},
    props: [
        'modalFormId', 'parentId'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            },
            formId: "users",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/users-Aggrid',
            table: 'users',
            usersData: [],
            requette: 2,
            columnDefs: null,
            rowData: null,
            gridApi2: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 10,
            cacheBlockSize: 10,
            lastUserSelectCount: 0,
            userSelect: [],
            maxBlocksInCache: 1,
            addListing: {
                formId: "listings",
                formState: "",
                formData: {},
                formWidth: "lg",
                formGridApi: {},
                formKey: 0,
                tableKey: 0,
                url: "http://127.0.0.1:8000/api/users-Aggrid",
                table: "Users",
                requette: 18,
                columnDefs: null,
                rowData: null,
                gridApi: null,
                columnApi: null,
                rowModelType: null,
                pagination: true,
                paginationPageSize: 10,
                cacheBlockSize: 10,
                maxBlocksInCache: 1,
                extrasData: {},
            },
        }
    },
    computed: {
        extrasData: function () {
            let params = {baseFilter: {}};
            params["baseFilter"]["id"] = {
                values: this.userSelect,
                filterType: "set",
            };
            return params;
        },
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        (this.addListing.url = this.axios.defaults.baseURL + "/api/users-Aggrid"),
            (this.addListing.rowBuffer = 0);
        this.addListing.rowModelType = "serverSide";
        this.addListing.columnDefs = [
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
                                this.addUser(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa fa-plus"></i></div>`,

                            //  render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                        },
                    };
                    return response;
                },
            },
            {
                field: "matricule",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "matricule",
            },
            {
                field: "nom",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "nom",
            },
            {
                field: "prenom",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "prenom",
            },
            {
                field: "num_badge",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "num_badge",
            },
        ];
        this.addListing.cacheBlockSize = 50;
        this.addListing.maxBlocksInCache = 2;
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
                                    this.deleteUser(field);
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#e31d3b;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-trash-can"></i></div>`,

                            }
                        };
                    },

                },


                {
                    field: "matricule",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'matricule',
                    pinned: 'left',
                },
                {
                    field: "nom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Nom',
                    pinned: 'left',
                },
                {
                    field: "prenom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'prenom',
                    pinned: 'left',
                },


            ];


    },
    methods: {
        openCreate() {
            this.showForm('Create', {}, this.gridApi2)
        },
        closeForm() {
            this.tableKey++
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
        createLine() {
            this.isLoading = true
            this.form.modelslisting_id = this.parentId
            this.form.users = this.userSelect.join(",")
            this.axios.post('/api/validations', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
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
                libelle: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        },
        addUser(data) {

            const clickedDate = data.Selectvalue;


            const index = this.userSelect.indexOf(clickedDate);
            if (index > -1) {
                // Si la date est déjà sélectionnée, la supprimer du tableau
                // this.selectedDates.splice(index, 1);
            } else {
                // Si la date n'est pas déjà sélectionnée, l'ajouter au tableau
                this.userSelect.push(clickedDate);
            }


            // this.userSelect.push(data.Selectvalue);
            this.$toast.success("Operation effectuer avec succes");
        },
        deleteUser(data) {
            const clickedDate = data.Selectvalue;

            const index = this.userSelect.indexOf(clickedDate);
            if (index > -1) {
                this.userSelect.splice(index, 1);
                this.tableKey++;
                this.$toast.success("Operation effectuer avec succes");
            }
        },
        finishAddUser() {
            if (this.userSelect.length != this.lastUserSelectCount) {
                this.lastUserSelectCount = this.userSelect.length;
                this.tableKey++;
            }
            this.$bvModal.hide(this.formId);
        },

    }
}
</script>
