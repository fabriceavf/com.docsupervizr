<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
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
                    <div class="form-group col-sm">
                        <label>nom {{ i }} </label>
                        <input v-model="form[`nom${i}`]"
                               :class="errors.nom1 ? 'form-control is-invalid' : 'form-control'"
                               type="text">

                        <div v-if="errors.nom1" class="invalid-feedback">
                            <template v-for=" error in errors.nom1"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <!-- <div class="form-group col-sm-4">

                        <button v-b-tooltip.hover
                            :style="actualPage == `modelslistingjour${i}` ? 'border:3px solid  green' : ''" class="btn"
                            style="" @click.prevent="togglePage(`modelslistingjour${i}`)">
                            <div class="iconParent">

                                <span> <i class="fa-solid fa-filter"></i> modelslistings {{ i }} jour </span>

                            </div>
                        </button>
                    </div>
                    <div class="form-group col-sm-4">

                        <button v-b-tooltip.hover
                            :style="actualPage == `modelslistingnuit${i}` ? 'border:3px solid  green' : ''" class="btn"
                            style="" @click.prevent="togglePage(`modelslistingnuit${i}`)">
                            <div class="iconParent">

                                <span> <i class="fa-solid fa-filter"></i> modelslistings {{ i }} nuit </span>

                            </div>
                        </button>
                    </div> -->
                </div>

                <!-- <div class="col-sm-12">
            <AgGridTable
                :key="tableKey"
                :cacheBlockSize="cacheBlockSize"
                :columnDefs="columnDefs"
                :maxBlocksInCache="maxBlocksInCache"
                :pagination="pagination"
                :paginationPageSize="paginationPageSize"
                :rowData="rowData"
                :rowModelType="rowModelType"
                :url="url"
                :extrasData="extrasData"
                className="ag-theme-alpine"
                domLayout='autoHeight'
                rowSelection="multiple"
                @gridReady="onGridReady"

            >
                <template #header_buttons>
                    <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> Nouveau
                    </div>
                </template>

            </AgGridTable>

        </div> -->
            </div>

            <button class="btn btn-primary" type="submit">
                <i class="fas fa-floppy-disk"></i> Créer
            </button>
        </form>
    </b-overlay>
</template>

<script>
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"
import AgGridTable from "@/components/AgGridTable.vue"

export default {
    name: 'CreateStatszones',
    components: {CustomSelect, AgGridTable, Files},
    props: [
        'gridApi',
        'modalFormId',
        'modelslistingsData',
        'UsersData'
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

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                user_id: "",
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
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
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
            // let retour = {};
            // let params = {};
            // params["user_id"] = {values: [this.parentId], filterType: "set"};
            // retour["baseFilter"] = params;
            // return retour;
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
                // {
                //     field: null,
                //     headerName: '',
                //     suppressCellSelection: true,
                //     width: 80,
                //     pinned: 'left',
                //     cellRendererSelector: params => {
                //         return {
                //             component: 'AgGridBtnClicked',
                //             params: {
                //                 clicked: field => {
                //                     this.showForm('Update', field, params.api)
                //                 },
                //                 render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-raduis:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                //             }
                //         };
                //     },

                // },


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
    methods: {
        createLine() {

            console.log('pn veut mettre a jour ', this.form)
            this.form.user_id = this.UsersData
            this.isLoading = true
            this.axios.post('/api/statszones', this.form).then(response => {
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
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                user_id: "",
            }
        },
        togglePage(page) {
            this.actualPage = page
            console.log('page', page)
        }
    }
}
</script>
