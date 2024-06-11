<template>
  <b-overlay :show="isLoading">
  <div class="row">

    <div class="col-sm-12">
      <div class="rendu" @click="toogleSelect()">

        <div class="valeur">{{ rendu }}<span v-if="selectioner.length>=3">...</span></div>
        <div class="count">( {{ selectioner.length }} )</div>
      </div>
    </div>
    <div class="selectParents" v-if="showSelect">

      <div class="col-sm-12">
        <div class="selectChildren" v-show="showSelectChild">

          <div class="form-group"><input v-model.lazy="search" autofocus class="form-control" type="text"
                                         placeholder="Veuillez tapez votre recherche"></div>
          <AgGridTable
              :in-card="false"
              :key="tableKey"
              :cacheBlockSize="cacheBlockSize"
              :columnDefs="columns"
              :maxBlocksInCache="maxBlocksInCache"
              :pagination="pagination"
              :paginationPageSize="paginationPageSize"
              :rowData="rowData"
              :rowModelType="rowModelType"
              :url="url"
              sideBar=""
              className="ag-theme-alpine"
              domLayout='autoHeight'
              rowSelection="multiple"
              @gridReady="onGridReady"
              hidePagination="true"
              :showExport="false"
              :showActu="false"
              :showPagination="false"
              :showCardHeader="false"
              :extras-data="extrasData"

          >
            <template #beforeTable>

            </template>
          </AgGridTable>
        </div>
      </div>

    </div>


  </div>
  </b-overlay>
</template>

<script>
import AgGridTable from "@/components/AgGridTable";
import SelectLines from "@/components/SelectLines";

export default {
  props: {
    base: {
      require: true,
      default: 'api'
    },
    columnDefs: {
      require: true,
      default: []
    },
    value: {
      type: String,
      required: true
    },
    url: {
      require: true,
      default: ""
    },
    filterFields: {
      type: Array,
      default: []
    },
    max: {
      type: Number,
      default: 3
    }

  },
  components: {AgGridTable, SelectLines},
  name: "AgGridSelect",
  data() {
    return {
      toogleSelectCount: 0,
      showSelect: false,
      showSelectChild: true,
      search: "",
      isLoading: false,
      formId: "balises",
      formState: "",
      formData: {},
      formWidth: 'lg',
      formGridApi: {},
      formKey: 0,
      tableKey: 0,
      table: 'balises',
      requette: 0,
      rowData: null,
      gridApi: null,
      columnApi: null,
      rowModelType: null,
      pagination: true,
      paginationPageSize: 5,
      cacheBlockSize: 10,
      maxBlocksInCache: 1,
      extrasData: {},
      bdd: {}
    }
  },
  mounted() {
    this.getBase()
  },
  created() {
    this.formId = this.table + "_" + Date.now()
    this.rowBuffer = 0;
    this.rowModelType = 'serverSide';
    this.cacheBlockSize = 50;
    this.maxBlocksInCache = 2;


  },
  methods: {
    toogleSelect() {
      if (this.toogleSelectCount == 0) {
        this.showSelect = true
      } else {
        this.showSelectChild = !this.showSelectChild
      }
      this.toogleSelectCount++
    },
    openCreate() {
      this.showForm('Create', {}, this.gridApi)
    },
    getBase() {
      this.isLoading=true
      let value = this.selectioner.join(',')

      this.axios.get('/api/' + this.base + '/id/' + value).then(response => {
        console.log('voici la reponse ==>', response.data)
        response.data.forEach(data => this.bdd[data.id] = data)
        this.isLoading=false
      })
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
      this.gridApi.sizeColumnsToFit();
    },
  },
   computed: {$routeData:function(){let router = {meta:{}};try{router=window.routeData}catch (e) {};return router; },
        routeData:function () {
            let router={meta:{}}
            if(window.router){
                try{ router=window.router; }catch (e) { }
            }


            return router
        },
    selectioner: function () {
      return this.value.split(',').filter(data => {
        return (data != null && data !== undefined && data !== "")
      }).map(data => parseInt(data))
    },
    rendu: function () {
      let old= Object.assign(this.bdd,{})

      let data = this.selectioner.map(data => {


        console.log('voici le rendu0.0 ==>',data,old,Object.keys(old),old.data)
        let retour = ""
        try {
          retour = this.bdd[data]['Selectlabel']
        } catch (e) {
        }

        console.log('voici le rendu0.1 ==>',retour)
        return retour;
      }).filter(data => {
        return (data != null && data !== undefined && data !== "")
      })
      console.log('voici le rendu1 ==>',data)
      data = data.slice(0, this.max)

      console.log('voici le rendu2 ==>',data)
      return data.join(' ; ')
    },
    columns: function () {
      let selectElement = {
        field: null,
        headerName: '',
        suppressCellSelection: true,
        width: 10,
        pinned: 'left',
        cellRendererSelector: params => {
          return {
            component: 'SelectLines',
            params: {
              selected: donnee => {
                this.bdd[donnee.id] = donnee
                let old = this.selectioner
                console.log('voci lancien selectioner ==>', old)
                old.push(donnee.id)

                let newData = old.map(data => parseInt(data))
                newData = newData.filter((value, index, self) => self.indexOf(value) === index);

                console.log('voci le nouveau selectioner ==>', newData)
                this.$emit('input', newData.join(','))
                // alert('on as mis ajour ')
              },
              deSelected: donnee => {
                this.bdd[donnee.id] = donnee
                let old = this.selectioner
                let newData = old.map(data => parseInt(data))
                newData = newData.filter((value, index, self) => self.indexOf(value) === index);
                newData = newData.filter(value => value != donnee.id);
                this.$emit('input', newData.join(','))
                // alert('on as mis ajour ')
              },
              render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            ,
              select: this.selectioner
            }
          };
        },

      };

      return [selectElement, ...this.columnDefs]
    }
  },
  watch: {
    'search': {
      handler: function (after, before) {
        this.extrasData['globalSearch'] = after
        this.extrasData['filterFields'] = this.filterFields
        this.tableKey++

      },
      deep: true
    },
    'value': {
      handler: function (after, before) {
        this.gridApi.refreshCells()
      },
      deep: true
    },
  },
}

</script>

<style scoped>
.selectParents {
  width: 90%;
}

.selectParents .card-footer {
  display: none
}

.selectChildren {
  position: absolute;
  background: #fff;
  padding: 5px;
  z-index: 10000;
  border: 2px solid #919191;
  border-radius: 5px;
  width: 100%

}

.rendu {
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  padding: 10px;
  width: 100%;
  border-radius: 5px;
  border: 1px solid #cecece;
}
</style>
