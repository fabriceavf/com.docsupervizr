<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title >
                <div v-if="formState=='Update'">Update Backends #{{formData.id}}</div>
                <div v-if="formState=='Create'">Create Backends </div>
            </template>

            <EditBackends
                v-if="formState=='Update'"
            :modalFormId="formId"
            :key="formKey"
            :data="formData"
            :gridApi="formGridApi"
            @close="closeForm"
                        />


            <CreateBackends
                v-if="formState=='Create'"
            :modalFormId="formId"
            :key="formKey"
            :gridApi="formGridApi"
            @close="closeForm"
                        />

            <template #modal-footer >
                <div ></div>
            </template>
        </b-modal>



        <div class="col-sm-12">
            <AgGridTable
                :key="tableKey"
                domLayout='autoHeight'
                rowSelection="multiple"
                className="ag-theme-alpine"
                :columnDefs="columnDefs"
                :url="url"
                :rowModelType="rowModelType"
                :paginationPageSize="paginationPageSize"
                :cacheBlockSize="cacheBlockSize"
                :maxBlocksInCache="maxBlocksInCache"
                :pagination="pagination"
                :rowData="rowData"
                @gridReady="onGridReady"

            >
                <template #header_buttons>
                    <div class="btn btn-primary"  v-if="!routeData.meta.hideCreate" @click="openCreate"><i class="fa fa-plus"></i> Nouveau</div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>



<script>
    import DataTable from '@/components/DataTable.vue'
    import AgGridTable from "@/components/AgGridTable.vue"
    import CreateBackends from './CreateBackends.vue'
    import EditBackends from './EditBackends.vue'
    import CustomSelect from "@/components/CustomSelect.vue"
    import CustomFiltre from "@/components/CustomFiltre.vue"
    import DataModal from '@/components/DataModal.vue'
    import moment from 'moment'

    import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

    export default {
        name: 'BackendsView',
        components: {  DataTable,AgGridTable, CreateBackends, EditBackends, DataModal,AgGridBtnClicked,CustomSelect,CustomFiltre },
        data () {

            return {
                formId:"backends",
                formState:"",
                formData:{},
                formWidth:'lg',
                formGridApi:{},
                formKey:0,
                tableKey:0,
                url: 'http://127.0.0.1:8000/api/backends-Aggrid',
                table: 'backends',
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
            }
        },

        computed:{
            routeData:function () {
                let router={meta:{}}
                if(window.router){
                    try{ router=window.router; }catch (e) { }
                }


                return router
            },
            taille:function(){
                let result='col-sm-12'
                if(this.filtre){
                    result='col-sm-9'
                }
                return result
            },
        },
        watch:{
            'routeData': {
                handler: function (after, before) {
                    this.gridApi.setFilterModel(null)
                    this.gridApi.refreshServerSide()
                },
                deep: true
            },
        },
        created() {
            this.url= this.axios.defaults.baseURL+'/api/backends-Aggrid',
                this.formId=this.table+"_"+Date.now()
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
                        width: 80,
                        pinned: 'left',
                        cellRendererSelector: params => {
                            return {
                                component: 'AgGridBtnClicked',
                                params:{
                                    clicked: field=> {
                                        this.showForm('Update',field,params.api)
                                    },
                                    render:`<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-raduis:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                                }
                            };
                        },

                    },
                                                
                                                
                                                
                                                
                                                
                                                
                                            {
                        field: "identifiants_sadge",
                        sortable: true,
                        filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
                        headerName: 'identifiants_sadge',
                    },
                        


                        
                                                
                                            {
                        field: "creat_by",
                        sortable: true,
                        filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
                        headerName: 'creat_by',
                    },
                        


                        
                                                                ];


        },
        mounted () {
            if(this.requette>0){
                // this.$store.commit('setIsLoading', true)
            }

            
        },
        methods: {
            closeForm(){this.tableKey++},
            openCreate(){
                this.showForm('Create',{},this.gridApi)
            },
            showForm(type,data,gridApi,width='lg'){
                this.formKey++
                this.formWidth=width
                this.formState=type
                this.formData=data
                this.formGridApi=gridApi
                this.$bvModal.show(this.formId)
            },
            onGridReady(params) {
                console.log('on demarre',params)
                this.gridApi = params.api;
                this.columnApi = params.columnApi;
                this.isLoading = false
            },
                    }
    }
</script>
