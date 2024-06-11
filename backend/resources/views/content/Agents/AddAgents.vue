<template>


    <div class="col-sm-12">
        {{ allAddElements }}
        <AgGridSearch
            :columnDefs="columnDefs"
            :extrasData="extrasData"
            :filterFields="['nom','prenom','matricule']"
            :url="url"
            filter-key="type_id"
            filter-value="2"
            @destruction="finishAddUser"
        >
        </AgGridSearch>

    </div>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";


import AgGridSearch from "@/components/AgGridSearch.vue";
import VSelect from "vue-select";

export default {
    name: "AddAgents",
    components: {VSelect, CustomSelect, AgGridSearch},
    props: {
        addId: {
            type: Array,
            default: []
        },
        excludeId: {
            type: Array,
            default: []
        }
    },
    computed: {
        allAddElements: function () {
            return this.addId.concat(this.addAgent)

        },
        allExcludeElements: function () {

            return this.excludeId.concat(this.excludeAgent)
        }

    },
    data() {
        return {
            addAgent: [],
            excludeAgent: [],
            errors: [],
            isLoading: false,
            defaultEntite: 'User',
            formId: "users",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/users-Aggrid',
            table: 'users',
            requette: 9,
            columnDefs: null,
            rowData: null,
            gridApi1: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 20,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            extrasData: {},
            agGridData: null,
        }
    },

    created() {
        this.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        let params = {}
        params['type_id'] = {values: [2, 3], filterType: 'set'}
        this.extrasData['baseFilter'] = params
        this.extrasData['selectAllFilter'] = 1

    },
    methods: {
        selectElement(id) {
            this.addAgent.push(id)
            this.excludeAgent = this.excludeAgent.filter(data => data != id)
            this.$emit('addAgent', id)
        },
        excludeElement(id) {
            this.excludeAgent.push(id)
            this.addAgent = this.addAgent.filter(data => data != id)
            this.$emit('excludeAgent', id)
        },
    },
    beforeMount() {
        this.columnDefs = [
            {
                field: "nom",
                headerName: '',

                cellRendererSelector: params => {
                    let retour = {
                        component: 'AgGridBtnClicked',
                        params: {
                            clicked: field => {
                                this.selectElement(params.data.id)
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#646464;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                        }
                    }
                    if (this.allAddElements.includes(params.data.id)) {
                        retour = {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.selectElement(params.data.id)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                            }
                        }
                    }
                    if (this.allExcludeElements.includes(params.data.id)) {
                        retour = {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.selectElement(params.data.id)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:red;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                            }
                        }
                    }
                    return retour
                        ;
                },
            },
            {
                field: "nom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'nom',
            },


            {
                field: "prenom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'prenom',
            },


            {
                field: "matricule",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'matricule',
            },


        ];

        let defaultEntite = 'User'


    },
}
</script>

<style scoped>

</style>
