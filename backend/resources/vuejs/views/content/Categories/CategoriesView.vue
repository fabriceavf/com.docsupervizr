<template>

  <div class="row">
    <b-modal :id="formId" :size="formWidth">
      <template #modal-title>
        <div v-if="formState=='Update'">Update Categories #{{ formData.id }}</div>
        <div v-if="formState=='Create'">Create Categories</div>
      </template>

      <EditCategories
          v-if="formState=='Update'"
          :key="formKey"
          :data="formData"
          :gridApi="formGridApi"
          :modalFormId="formId"
          @close="closeForm"
      />


      <CreateCategories
          v-if="formState=='Create'"
          :key="formKey"
          :gridApi="formGridApi"
          :modalFormId="formId"
          @close="closeForm"
      />

      <template #modal-footer>
        <div></div>
      </template>
    </b-modal>


    <div class="col-sm-12">
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
          className="ag-theme-alpine"
          domLayout='autoHeight'
          rowSelection="multiple"
          @gridReady="onGridReady"

      >
        <template #header_buttons>
          <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i class="fa fa-plus"></i>
            Nouveau
          </div>
        </template>

      </AgGridTable>

    </div>
  </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateCategories from './CreateCategories.vue'
import EditCategories from './EditCategories.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
  name: 'CategoriesView',
  components: {DataTable, AgGridTable, CreateCategories, EditCategories, DataModal, AgGridBtnClicked},
  data() {

    return {
      formId: "categories",
      formState: "",
      formData: {},
      formWidth: 'lg',
      formGridApi: {},
      formKey: 0,
      tableKey: 0,
      url: 'http://127.0.0.1:8000/api/categories-Aggrid',
      table: 'categories',
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

   computed: {$routeData:function(){let router = {meta:{}};try{router=window.routeData}catch (e) {};return router; },
        routeData:function () {
            let router={meta:{}}
            if(window.router){
                try{ router=window.router; }catch (e) { }
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
  },
  watch: {
    'routeData': {
      handler: function (after, before) {
        this.gridApi.setFilterModel(null)
        this.gridApi.refreshServerSide()
        this.tableKey++
      },
      deep: true
    },
  },
  created() {
    this.url = this.axios.defaults.baseURL + '/api/categories-Aggrid',
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
            minWidth: 80,maxWidth: 80,
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
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'libelle',
          },


          {
            field: "code",
            sortable: true,
           filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            headerName: 'code',
          },


        ];


  },
  mounted() {
    if (this.requette > 0) {
      this.$store.commit('setIsLoading', true)
    }


  },
  methods: {
    openCreate() {
      this.showForm('Create', {}, this.gridApi)
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
  }
}
</script>
