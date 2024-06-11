<template>
    <div class="col-sm-12">
        <AgGridSearch
            :columnDefs="columnDefs"
            :extrasData="extrasData"
            :filterFields="filterFields"
            :url="url"
            :filter-key="filterKey"
            :filter-value="filterValue"
            :paginationPageSize="10"

        ></AgGridSearch>
        <div style="text-align: center ;margin:5px">
            <button class="btn btn-primary" @click="updateFilter()"> Lancer le filtre ({{selectElement.length}} element selectioner)</button>

        </div>
    </div>

</template>

<script>
import AgGridSearch from "@/components/AgGridSearch.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
export default {
    name: "CustomFiltre",
    components: {AgGridSearch,AgGridBtnClicked},
    data() {
        return {
            year: 'All',
            colId: '',
            columnDefs: [],
            extrasData: {},
            filterFields: [],
            filterKey: "",
            filterValue: "",
            url: "",
            selectElement:[],
            lastQuery:0,
        }
    },

    mounted() {
        console.log('voila les paramettre passer', this.params)
        this.data = this.params.data
        this.url=this.params.url
        this.extrasData=this.params.extrasData
        this.filterFields=this.params.filterFields
        this.filterKey=this.params.filterKey
        this.filterValue=this.params.filterValue
        this.colId = this.params.column.colId
        this.columnDefs=[ {
            field: null,
            headerName: "",
            suppressCellSelection: true,
            minWidth: 80,maxWidth: 80,
            pinned: "left",
            cellRendererSelector: (params) => {
                console.log('element rerendu',params.data.id,this.selectElement)

                let                      render=`<div class="" style="width: 20px;height: 20px;color: #fff;border-radius: 5px;text-align: center;cursor: pointer;border: 1px solid #aeaeae;">  </div>`;

                if(this.selectElement.includes(params.data.id)){
                    render=`<div class="" style="width: 20px;height: 20px;color: #fff;border-radius: 5px;text-align: center;cursor: pointer;background:#8ee866;border: 1px solid #aeaeae;">  </div>`;

                }
                return {
                    component: "AgGridBtnClicked",
                    params: {
                        clicked: (field) => {
                            this.clickElement(field,params);
                        },
                        render: render,
                    },
                };
            },
        },...this.params.columnDefs]

    },
    methods: {
        updateFilter() {
            try{// Example 2
                delete this.params.api[`__extraFilter__${this.colId}`];
            }catch (e) {

            }
            console.log('voila les paramettre passer filter 1 ')
            let filter = {}
            filter['keys'] = this.colId
            filter['values'] = {
                filterType: 'set',
                values: this.selectElement,
            }
            this.params.api.get
            if(this.selectElement.length>0){
                this.params.api[`__extraFilter__${this.colId}`] = filter
            }
            this.lastQuery=this.selectElement.length
            this.params.filterChangedCallback();
        },


        doesFilterPass(params) {
            return params.data.year >= 2010;
        },

        isFilterActive() {
            return this.lastQuery>0
        },

        // this example isn't using getModel() and setModel(),
        // so safe to just leave these empty. don't do this in your code!!!
        getModel() {
        },

        setModel(model) {
            return {
                filterType: 'set',
                values: [1, 5, 6],
            }
        },
        clickElement(data,params){
            console.log('on as desectionner un element',data,params)
            if(this.selectElement.includes(data.id)){
                let index =this.selectElement.indexOf(data.id);
                if (index > -1) { // only splice array when item is found
                    this.selectElement.splice(index, 1); // 2nd parameter means remove one item only
                }
            }else{
                this.selectElement.push(data.id)
            }

            params.api.applyServerSideTransaction({update: [data]})
        }
    }

}
</script>

<style>
.ag-theme-alpine {

    --ag-font-size: 10px;
}
</style>
