<template>
    <b-overlay :show="isLoading">
        <div class="row">

            <div class="col-sm-12">

                <div class="form-group col-12" :id="elementId" v-if="globalSearchColumns.length>0">
                    <input v-model.lazy="search" class="form-control" type="text">
                </div>

                <slot v-bind:data="donnees" v-bind:api="server"></slot>

                    <b-pagination
                        v-if="totalRows>currentPage*paginationPageSize "

                        style="width:100%"
                        v-model="currentPage"
                        :total-rows="totalRows"
                        :per-page="paginationPageSize"
                        first-text="Premier"
                        prev-text="Precedent"
                        next-text="Suivant"
                        last-text="Dernier"
                    ></b-pagination>
                


            </div>


        </div>
    </b-overlay>
</template>



<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import DataModal from '@/components/DataModal.vue'
import AdminPerms from "@/views/content/Users/AdminPerms.vue";
import EditCruds from '@/views/content/Cruds/EditCruds.vue'


import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import {onBeforeUnmount} from "@vue/composition-api";
import Server from "../../views/content/Badges/server";

export default {
    name: 'AgGridRendu',
    components: {DataTable, AgGridTable, DataModal, AgGridBtnClicked, AdminPerms, EditCruds},
    props: {
        tableKey: {
            type: Number,
            default: 0
        },
        filterKey: {
            type: String,
            default: ''
        },
        filterFields: {
            require: true,
            type: Array,
            default: []
        },
        filterValue: {
            type: String,
            default: ''
        },
        globalSearchColumns: {
            type: Array,
            default: []
        },
        filterColumns: {
            type: Array,
            default: []
        },
        paginationPageSize:{
            default:100
        },
        url: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            isLoading: false,
            search: "",
            donnees:[],
            server:{},
            currentPage:1,
            totalRows:0,
        }
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
            let params = {baseFilter: {}}
            if (this.filterKey !== "" && this.filterValue !== "") {
                params['baseFilter'][this.filterKey] = {values: [this.filterValue], filterType: 'set'}
            }
            if (this.search !== "") {
                params['filterFields'] = this.filterFields;
                params['globalSearch'] = this.search;
            }
            return params


        },
        paginationDetail:function(){
            return {

            }
        }
    },
    watch: {
        'routeData': {
            handler: function (after, before) {

                this.tableKey++
            },
            deep: true
        },
        'search': {
            handler: function (after, before) {
                console.log('la recherche a changer ==>', after)
                this.server.globalSearch(after,this.globalSearchColumns,true);

            },
            deep: true
        },
        'agGridData': {
            handler: function (after, before) {
                console.log('changement des donnees ==>', after)

            },
            deep: true
        },
        'allDatas': {
            handler: function (after, before) {
                console.log('changement des toutes les donnees ==>', after)

            },
            deep: true
        },
        'currentPage': {
            handler: function (after, before) {
                console.log('currentPage',after)
                this.server.load(after)

            },
            deep: true
        },
    },
    created() {

        this.formId = this.table + "_" + Date.now()
        this.elementId = 'AgGridRendu' + "_" + Date.now()


    },
    beforeMount() {
    },
    mounted() {
        let server=new Server(this.axios)
        server.setUrl(this.url)
        server.setMaxDataPerPage(this.paginationPageSize)
        server.addOn('dataLoadSuccess',(ser,data)=>{
            console.log('recuperation de donnees avec succes',data,ser)
            this.donnees=data.rowData
            let currentPage=data.endRow/this.paginationPageSize
            if(this.currentPage!=currentPage){
                this.currentPage=currentPage
            }
            this.totalRows=data.rowCount
        })
        server.addOn('dataLoadError',(ser,data)=>{
            console.log('recuperation de donnees sans succes',data,ser)
        })
        this.filterColumns.forEach(data=>{
            console.log('filterColumns',data)
            server.addColumnSearch(data.value,data.column,data.type)
        })

        server.load()

        this.server=server

    },
    beforeDestroy() {
        this.$emit('destruction')

    },
    methods: {


    }
}
</script>
