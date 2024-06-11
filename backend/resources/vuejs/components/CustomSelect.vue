<template>
    <div>
        <div class="col-sm-12">
            <div class="row" style="position: relative">
                <button :class="!disable?'btn':'btn btn-disable' " @click.prevent="toggleElement()"
                        style="width: 100%;border: 1px solid #bdbdbd;border-radius: 5px;text-align:left">
                    {{ valeurSelectionner }}
                </button>
                <span class="deactivate" v-if="canDelete" @click.prevent="removeElement()"> <i class="fa-solid fa-circle-xmark"></i></span>
            </div>
            <div class="row">
                <div style="margin:5px auto;width:98%" :class="show?'withShow':'noShow'">
                    <AgGridSearch
                        v-if="showCount>0"
                        :columnDefs="columns"
                        :extrasData="extrasData"
                        :filterFields="columnDefs"
                        :url="url"
                        :filter-key="filterKey"
                        :filter-value="filterValue"
                        :paginationPageSize="10"

                    ></AgGridSearch>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import AgGridSearch from "@/components/AgGridSearch.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: "CustomSelect",
    components: {AgGridSearch, AgGridBtnClicked},
    props: {
        columnDefs: {
            default: [],
        },
        extrasData: {
            default: {},
        },
        filterFields: {
            default: [],
        },
        url: {
            default: "",
        },
        filterKey: {
            default: [],
        },
        filterValue: {
            default: [],
        },
        renderCallBack: {},
        selectCallBack: {},
        oldValue: {
            default: {}
        },
        disable: {
            default: false
        },
        placeHolder: {
            default: "Veuillez selectionner un element"
        },
        multiple:{
            default:false
        }
    },
    data() {
        return {
            rendu: null,
            show: false,
            selectElement: [],
            lastQuery: 0,
            baseData: [],
            tableKey: 0,
            showCount:0

        }
    },

    mounted() {

        this.rendu=this.placeHolder
        this.baseData = []
        this.baseData.push(this.oldValue)
        console.log('customSelectConsole  paramettre passer ', this.baseData, this.oldValue)



    },

    computed: {

        columns: function () {
            let col = this.columnDefs.map(function (e) {
                let libelleTableau=e.split('.')
                let selectKey=libelleTableau.length-2
                if(selectKey<=0){
                     selectKey=libelleTableau.length-1
                }

                    return {
                        field: e,

                        headerName: libelleTableau[selectKey-1],
                        suppressCellSelection: true,
                    }

                }
            );
            return [
                {
                field: null,
                headerName: "",
                suppressCellSelection: true,
                maxWidth: 50,
                pinned: "left",
                cellRendererSelector: (params) => {
                    console.log('element rerendu', params.data.id, this.selectElement)

                    let render = `<div class="" style="width: 20px;height: 20px;color: #fff;border-radius: 5px;text-align: center;cursor: pointer;border: 1px solid #aeaeae;">  </div>`;

                    if (this.selectElement.includes(params.data.id)) {
                        render = `<div class="" style="width: 20px;height: 20px;color: #fff;border-radius: 5px;text-align: center;cursor: pointer;background:#8ee866;border: 1px solid #aeaeae;">  </div>`;

                    }
                    return {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.clickElement(field, params);
                            },
                            render: render,
                        },
                    };
                },
            }, ...col]


        },
        valeurSelectionner: function () {
            let rendu = this.placeHolder;
            this.baseData.forEach(e => {
                console.log('customSelectConsole  foreach ', e)
                try {
                    rendu = this.renderCallBack(e);
                } catch (e) {

                }
            })
            console.log('customSelectConsole  valeurSelectionner rendu ', rendu, this.baseData)
            if (rendu == '' || rendu == null || rendu === 'undefined') {
                rendu = this.placeHolder;
            }
            return rendu
        },
        canDelete: function () {
            return this.valeurSelectionner!='' && this.valeurSelectionner!='Veuillez selectionnez un element';
        }
    },
    methods: {
        updateFilter() {
            try {// Example 2
                delete this.params.api[`__extraFilter__${this.colId}`];
            } catch (e) {

            }
            console.log('voila les paramettre passer filter 1 ')
            let filter = {}
            filter['keys'] = this.colId
            filter['values'] = {
                filterType: 'set',
                values: this.selectElement,
            }
            this.params.api.get
            if (this.selectElement.length > 0) {
                this.params.api[`__extraFilter__${this.colId}`] = filter
            }
            this.lastQuery = this.selectElement.length
            this.params.filterChangedCallback();
        },
        doesFilterPass(params) {
            return params.data.year >= 2010;
        },
        isFilterActive() {
            return this.lastQuery > 0
        },
        getModel() {
        },
        setModel(model) {
            return {
                filterType: 'set',
                values: [1, 5, 6],
            }
        },
        clickElement(data, params) {
            console.log('on as sectionner un element', data)
            this.baseData = []
            this.baseData.push(data)

            try {
                this.selectCallBack(data);
                this.toggleElement()
            } catch (e) {

            }


            try {
                if(this.selectElement.includes(data.id)){
                    this.selectElement=this.selectElement.filter(e=>e!=data.id)
                }else{
                    if(this.multiple){
                        this.selectElement.push(data.id)
                    }else{
                        this.selectElement=[data.id]
                    }
                }

            } catch (e) {

            }

            console.log('on as sectionner un element', this.baseData)
            params.api.refreshCells()
        },
        toggleElement() {
            console.log('on veut supprimer toggleElement',this.disable,this.show)
            if (!this.disable) {
                this.show = !this.show;
            }
            this.showCount++;
        },
        removeElement() {
            if(!this.disable){
                this.show = false;
                this.baseData=[]
                try {
                    this.selectCallBack({id:null});
                } catch (e) {

                }
            }

        }
    }

}
</script>

<style>
.ag-theme-alpine {

    --ag-font-size: 10px;
}

.deactivate {
    position: absolute;
    right: 5px;
    top: 5px;
    cursor:pointer
}
.noShow{
    display:none
}
.btn-disable{
    background: #cacaca73;
}
.withShow{
    margin: 5px auto;
    width: 98%;
    position: absolute;
    z-index: 1000;
    background: #fff;
    padding: 10px;
    border: 1px solid #cecece;
}
</style>
