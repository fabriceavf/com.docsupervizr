<template>
    <b-overlay :show="isLoading">
        <div id="filtreEntete" v-if="filtreEntete.length>0">
            <div class="col-sm-12 card"  style="padding-top:10px">
                <div>
                    <b-card no-body>
                        <b-tabs >
                            <b-tab title="Veuillez filtrer votre tableau en fonction  " disabled></b-tab>
                            <b-tab :title="getTotalSelectForFiltre(filtre)"  v-for="(filtre,key) in filtreEntete" :key="key">
                                <div class="elementFiltre">
                                    <b-overlay :show="!Object.keys(filtre).includes('donnees')" >

                                    </b-overlay>
                                    <template v-for="(items,key1)  in filtre.donnees">

                                        <button :key='`Select-${key}-${key1}`' v-if="isSelectElementEntete(filtre.field,items.id)" v-b-tooltip.hover
                                                class=" btn btn-outline-primary"
                                                @click.prevent="toggleElementEntete(filtre.field,items.id)"
                                        >

                                            <span><i class="far fa-check-square" ></i> {{ items.libelle.toLowerCase() }}</span>


                                        </button>
                                        <button  :key='`UnSelect-${key}-${key1}`' v-else v-b-tooltip.hover
                                                 class="btn"
                                                 @click.prevent="toggleElementEntete(filtre.field,items.id)"
                                        >
                                           <span>
                                               <i class="far fa-square" ></i> {{ items.libelle.toLowerCase() }}
                                           </span>


                                        </button>

                                    </template>

                                </div>
                            </b-tab>
                        </b-tabs>
                    </b-card>
                </div>
            </div>
        </div>
        <div v-if="inCard" class="card ">
            <div class="card-header" v-if="showCardHeader">
                <slot name="datatable_header_title"></slot>
                <div class="d-flex">
                    <div class="mr-2" v-if="showPagination">
                        <select class="form-control" required v-model="pageSize">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                            <option value="5000">5000</option>
                        </select>
                    </div>
                    <div class="allBoutons BoutonsEntete">
                        <button :class="showDelete?'btn btn-danger':'btn'" @click.prevent="toggleDelete" v-if="showDeleteButton">
                            <i class="fa fa-trash"></i> <span>Elements Archiver  </span>
                        </button>
                        <button class="btn btn-warning" @click.prevent="onBtExport" v-if="showExport">
                            <i class="fas fa-file-download"></i> <span>Exporter</span>
                        </button>
                        <button class="btn btn-secondary" @click.prevent="redraw" v-if="showActu">
                            <i class="fa fa-refresh"></i> <span>Actualiser  </span>
                        </button>

                        <slot name="header_buttons"></slot>
                    </div>
                    <button class="btn">{{ dataCount }} Ligne(s)</button>
                </div>
            </div>

            <div class="card-body overflow-auto">
                <slot name="beforeTable"></slot>
                <ag-grid-vue
                    :id="id"
                    style="width: 100%; height: 100%;"
                    :suppressPaginationPanel="suppressPaginationPanel"
                    :multiSortKey="multiSortKey"
                    :excelStyles="excelStyles"
                    colResizeDefault='shift'
                    :class="className"
                    :columnDefs="colonnes"
                    :domLayout="domLayout"
                    :rowHeight="rowHeight"
                    :getRowId="getRowId"
                    :sideBar="sideBar"
                    :getRowStyle="getRowStyle"
                    :localeText="localeText"
                    :suppressRowHoverHighlight="suppressRowHoverHighlight"
                    @paginationChanged="onPaginationChanged"
                    @gridReady="onGridReady"
                    :rowModelType="rowModelType"
                    :serverSideDatasource="createDatasource?createDatasource:createLocalDatasource"
                    :paginationPageSize="paginationPageSize"
                    :maxBlocksInCache="maxBlocksInCache"
                    :pagination="pagination"
                    :rowData="rowData"
                    :masterDetail="masterDetail"
                    :detailCellRendererParams="detailCellRendererParams"
                    :detailCellRenderer="detailCellRenderer"
                    :detailRowAutoHeight="detailRowAutoHeight"
                    :autoHeight="autoHeight"
                    :treeData="treeData"
                    :isServerSideGroup="isServerSideGroup"
                    :getServerSideGroupKey="getServerSideGroupKey"
                >

                </ag-grid-vue>
            </div>
            <div class="card-footer ">
            </div>
        </div>
        <div v-else>
            <ag-grid-vue
                :id="id"
                style="width: 100%; height: 100%;"
                :suppressPaginationPanel="suppressPaginationPanel"
                :multiSortKey="multiSortKey"
                :excelStyles="excelStyles"
                colResizeDefault='shift'
                :class="className"
                :columnDefs="colonnes"
                :domLayout="domLayout"
                :rowHeight="rowHeight"
                :getRowId="getRowId"
                :sideBar="sideBar"
                :suppressRowHoverHighlight="suppressRowHoverHighlight"
                :getRowStyle="getRowStyle"
                :localeText="localeText"
                @paginationChanged="onPaginationChanged"
                @gridReady="onGridReady"
                :rowModelType="rowModelType"
                :serverSideDatasource="createDatasource?createDatasource:createLocalDatasource"
                :paginationPageSize="paginationPageSize"
                :maxBlocksInCache="maxBlocksInCache"
                :pagination="pagination"
                :rowData="rowData"
                :masterDetail="masterDetail"
                :detailCellRendererParams="detailCellRendererParams"
                :detailCellRenderer="detailCellRenderer"
                :detailRowAutoHeight="detailRowAutoHeight"

                :autoHeight="autoHeight"
            >

            </ag-grid-vue>
        </div>
    </b-overlay>

</template>

<script>
import 'ag-grid-enterprise';
import {AgGridVue} from "ag-grid-vue";
import AG_GRID_LOCALE_FR from "@/components/agGridLocalFr.js";

import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";

export default {
    name: "AgGridTable",

    components: {AgGridVue},
    props: {
        inCard: {
            default: true
        },
        id: {

        },
        autoHeight :{
            default: false
        },
        autoGroupColumnDef: {
            default: false
        },
        treeData: {
            default: false
        },
        isServerSideGroup: {
            default: false
        },

        suppressRowHoverHighlight: {
            default: false
        },
        getRowStyle: {
            default: false
        },
        getServerSideGroupKey: {
            default: false
        },
        primary: {
            default: 'id'
        },
        localeText: {
            default: () => AG_GRID_LOCALE_FR
        },
        rowHeight: {
            default: "30"
        },
        suppressPaginationPanel: {
            default: false
        },
        extrasData: {
            default: null
        },
        showPagination: {
            default: true
        },
        showExport: {
            default: true
        },
        detailRowAutoHeight: {
            default: true
        },
        showActu: {
            default: true
        },
        showDeleteButton: {
            default: true
        },
        masterDetail: {
            default: true
        },
        detailCellRendererParams: {
            default: null
        },
        detailCellRenderer: {
            default: null
        },
        showCardHeader: {
            default: true
        },
        sideBar: {
            default: () => {
                return {
                    toolPanels: [
                        {
                            id: 'columns',
                            labelDefault: 'Columns',
                            labelKey: 'columns',
                            iconKey: 'columns',
                            toolPanel: 'agColumnsToolPanel',
                            minWidth: 225,
                            maxWidth: 225,
                            width: 225,
                            toolPanelParams: {
                                suppressRowGroups: true,
                                suppressValues: true,
                                suppressPivots: true,
                                suppressPivotMode: true,
                                suppressColumnFilter: true,
                                suppressColumnSelectAll: true,
                                suppressColumnExpandAll: true,
                            },
                        },
                        {
                            id: 'filters',
                            labelDefault: 'Filters',
                            labelKey: 'filters',
                            iconKey: 'filter',
                            toolPanel: 'agFiltersToolPanel',
                            minWidth: 180,
                            maxWidth: 400,
                            width: 250,
                            toolPanelParams: {
                                suppressRowGroups: true,
                                suppressValues: true,
                                suppressPivots: true,
                                suppressPivotMode: true,
                                suppressColumnFilter: true,
                                suppressColumnSelectAll: true,
                                suppressColumnExpandAll: true,
                            },
                        }
                    ],
                    position: 'left',
                    defaultToolPanel: ['filters', 'columns']

                }
            }
        },
        domLayout: {
            default: 'autoHeight'
        },
        rowSelection: {
            default: 'multiple'
        },
        className: {
            default: 'ag-theme-alpine'
        },
        columnDefs: {
            default: null
        },
        rowData: {
            default: null
        },

        rowModelType: {
            default: 'serverSide'
        },
        multiSortKey: {
            default: true

        },
        pagination: {
            default: true
        },
        paginationPageSize: {
            default: 100
        },
        cacheBlockSize: {
            default: 10
        },
        maxBlocksInCache: {
            default: 1
        },
        url: {
            default: ""
        },
        createDatasource:{
            default:null
        },
        excelStyles:{
            default: [
                // The base style, red font.
                {
                    id: "redFont",
                    font: {
                        color: '#ff0000',
                    },
                },
                // The cellClassStyle: background is green and font color is light green,
                // note that since this excel style it's defined after redFont
                // it will override the red font color obtained through cellClass:'red'
                {
                    id: "greenBackground",
                    alignment: {
                        horizontal: 'Right', vertical: 'Bottom'
                    },
                    font: { color: "#e0ffc1"},
                    interior: {
                        color: "#008000", pattern: 'Solid'
                    }
                },
                {
                    id: "orangeBackground",
                    alignment: {
                        horizontal: 'Right', vertical: 'Bottom'
                    },
                    font: { color: "#e0ffc1"},
                    interior: {
                        color: "#ffa700", pattern: 'Solid'
                    }
                },
                {
                    id: "cell",
                    alignment: {
                        vertical: "Center"
                    }
                }
            ]
        }
    },
    data() {
        return {
            actualFiltre:0,
            dataCount: 0,
            isLoading: true,
            actualDataCount: 1,
            pageSize: 100,
            gridApi: null,
            columnApi: null,
            getRowId: null,
            showDelete:false,
            baseFilter: [],
            filtreEnteteData: {},
            filtreEnteteKeys: 0,
            selectElement: [],
            dynamiqueFilter: []
        }
    },

    created() {
        this.pageSize = this.paginationPageSize
        this.getRowId = (params) => {
            return params.data[this.primary];
        };
    },
    mounted() {
        console.log('voici les donnees monter', this.filtreEntete)
        this.filtreEntete.forEach(data => {
            this.getData(data.filterParams.url)
        })
    },
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                router = window.routeData
            } catch (e) {
            }
            ;
            return router;
        },
        colonnes: function () {
            let colonnes = this.columnDefs.map(function (data) {
                if (!Object.keys(data).includes('resizable')) {
                    data['resizable'] = true
                }
                data['wrapHeaderText'] = true
                return data
            })
            colonnes = colonnes.filter(data => data.filter != 'FiltreEntete')
            return colonnes;
        },
        filtreEntete: function () {
            let index = this.filtreEnteteKeys
            let colonnes = this.columnDefs.map(function (data) {
                if (!Object.keys(data).includes('resizable')) {
                    data['resizable'] = true
                }
                data['wrapHeaderText'] = true
                return data
            })
            colonnes = colonnes.filter(data => data.filter == 'FiltreEntete')
            colonnes = colonnes.map(data => {
                try {
                    console.log('monter je recupere les data', this.filtreEnteteData)
                    data['donnees'] = this.filtreEnteteData[data.filterParams.url].sort(function(a, b) {
                        const nameA = a.libelle.toUpperCase();
                        const nameB = b.libelle.toUpperCase();
                        if (nameA < nameB) {
                            return -1;
                        }
                        if (nameA > nameB) {
                            return 1;
                        }
                    })
                } catch (e) {

                }
                return data
            })
            return colonnes;
        },
        style: function () {
            return `width:100%;`
        },
        createLocalDatasource: server => {
            return {
                getRows: params => {
                    server.isLoading = true
                    // Rajouter tout ce que se trouve dans le filter des meta de la route dans la request dagrid
                    console.log('voici les donnees de routages ==>', server.routeData())
                    let filter = {}
                    try {
                        filter = server.$routeData.meta.filter
                    } catch (e) {

                    }
                    let filter1 = []
                    let filter2 = []
                    let filter3 = []
                    try {
                        filter1 = server.baseFilter
                    } catch (e) {

                    }
                    try {
                        filter2 = server.dynamiqueFilter
                    } catch (e) {

                    }
                    try {
                        filter3 = filter3.concat(filter1, filter2)
                    } catch (e) {

                    }
                    // On nettoie les anciens filtre
                    server.filtreEntete.forEach(data=>{
                        try{
                            delete params.request.filterModel[data.field];
                        }catch (e) { }
                    })


                    // je recuperer les filtres defini par les customFilter et je les utilises ici
                    let filtreUlterieurKeys=Object.keys(server.gridApi).filter(data=>data.startsWith('__extraFilter__'))
                    filtreUlterieurKeys.forEach(data=>{
                        let filtre=server.gridApi[data]
                        console.log('voila les data de laggrid filtre',filtre)
                        try{
                            params.request.filterModel[filtre.keys]=filtre.values
                        }catch (e) { }
                        console.log('voila les data de laggrid filtre',params.request.filterModel)
                    })
                    filter3.forEach(data=>{
                        try{
                            params.request.filterModel[data.champ]=data
                        }catch (e) { }
                    })
                    console.log('voici les filteres',filter3,server.filtreEntete,filtreUlterieurKeys,params.request.filterModel)
                    console.log('voila le filter model',params.request.filterModel)
                    console.log('voila les data de laggrid getModel',filtreUlterieurKeys)
                    params.request['__filter__'] = filter
                    params.request['__extras__'] = server.extrasData,
                    params.request['__showDelete__'] = server.showDelete
                    console.log('voici les data', params)
                    server.axios.post(server.url, params.request)
                        .then(response => {
                            try {
                                server.dataCount = response.data.rowCount
                            } catch (e) {

                            }
                            server.$emit('newData', response.data)
                            params.success(response.data);
                            server.isLoading = false

                        })
                        .catch(error => {

                            server.isLoading = false
                            params.fail();
                        })
                }
            };
        }
    },
    methods: {
        getTotalSelectForFiltre(filtre){
            let total=0
                this.dynamiqueFilter.forEach(data=> {
                    if(data.champ==filtre.field){
                        try{
                            total=data.values.length
                        }catch (e) {

                        }
                    }
                });
            let libelle=[filtre.headerName.toUpperCase()]
            if(total>0){
                libelle.push(`( ${total} )`)
            }

            return libelle.join(' ')
        },
        isSelectElementEntete(element, id) {
            return this.selectElement.includes(element + "-" + id)

        },
        toggleElementEntete(element, id) {
            let cle = element + "-" + id
            console.log('toggle Element Debut', cle, this.selectElement)
            if (this.selectElement.includes(cle)) {
                this.selectElement = this.selectElement.filter(data => data != cle)
            } else {
                this.selectElement.push(cle)
            }
            this.dynamiqueFilter = this.getEnteteParamsForRequest()
            this.redraw()

        },
        getEnteteParamsForRequest() {
            let data = {}
            let filtres = []
            this.selectElement.forEach(donnes => {
                let cle = donnes.split('-')[0]
                let valeur = parseInt(donnes.split('-')[1])
                if (!Object.keys(data).includes(cle)) {
                    data[cle] = []
                }
                data[cle].push(valeur)
            })
            Object.keys(data).forEach(dat => {
                let _dat = {
                    filterType: 'set',
                    champ: dat,
                    values: data[dat],
                }
                filtres.push(_dat)
            })

            return filtres

        },
        getData(route) {
            let agGridParams = {
                "startRow": 0,
                "endRow": 100,
                "rowGroupCols": [],
                "valueCols": [],
                "pivotCols": [],
                "pivotMode": false,
                "groupKeys": [],
                "filterModel": {},
                "sortModel": [],
                "__filter__": [],
                "__extras__": {}
            }
            console.log('voici les donnees monter', route)
            this.axios.post(route, agGridParams).then(response => {
                let data = []
                try {
                    data = response.data.rowData
                } catch (e) {
                    data = []
                }
                this.filtreEnteteData[route] = data
                this.filtreEnteteData = {...this.filtreEnteteData}
            })

        },
        routeData() {
            let router = {meta: {}};
            try {
                router = window.routeData
            } catch (e) {
            }
            ;
            return router;
        },
        onBtExport() {
            this.gridApi.exportDataAsExcel();
        },
        onGridReady(params) {
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false

            // this.gridApi.autoSizeAllColumns();
            this.$emit('gridReady', params)
        },
        change() {
            let instance = this.gridApi.getFilterInstance('name')
            instance.setFilterValues([
                {
                    name: 'France',
                    code: 'FR',
                },
                {
                    name: 'Australia',
                    code: 'AU',
                },
            ]);
            instance.applyModel();
            this.gridApi.onFilterChanged();
        },
        onPaginationChanged(params) {},
        getSelectedRows() {
            const selectedNodes = this.gridApi.getSelectedNodes();
            const selectedData = selectedNodes.map(node => node.data);
            const selectedDataStringPresentation = selectedData.map(data => `${data.make} ${data.model}`).join(', ');
            alert(`Selected nodes: ${selectedDataStringPresentation}`);
        },
        redraw() {
            this.gridApi.refreshServerSide()
        },
        toggleDelete() {
            this.showDelete=!this.showDelete
            this.redraw()
        }
    },
    watch: {
        'pageSize': {
            handler: function (after, before) {
                try {

                    this.gridApi.paginationSetPageSize(after)

                } catch (e) {

                }


            },
        }
    }
}
</script>

<style scoped>
@import "ag-grid-community/styles/ag-grid.css";
@import "ag-grid-community/styles/ag-theme-alpine.css";

.allBoutons {
    display: flex;
    gap: 10px
}

.ag-root-wrapper {
    border-radius: 5px
}
.elementFiltre{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 3px;
}
.BoutonsEntete{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 3px;
}
</style>
