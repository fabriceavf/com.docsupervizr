<template>
    <b-overlay :show="isLoading">

        <form @submit.prevent="valider()">
        <div class="row">
            <div class="col-sm-12">
                <div class="input-group mb-1">
                    <input
                        v-model="element"
                        class="form-control"
                        type="text"
                    />
                    <button class="btn btn-primary"  style="margin-left: 5px;" @click.prevent="valider()">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
                <AgGridTable
                    :key="tableKey"
                    :cacheBlockSize="cacheBlockSize"
                    :columnDefs="columnDefs"
                    :extras-data="extrasData"
                    :in-card="inCard"
                    :maxBlocksInCache="maxBlocksInCache"
                    :pagination="pagination"
                    :paginationPageSize="paginationPageSize"
                    :rowData="rowData"
                    :rowModelType="rowModelType"
                    :url="url"
                    className="ag-theme-alpine"
                    domLayout="autoHeight"
                    rowSelection="multiple"
                    @gridReady="onGridReady"
                    :sideBar="sideBar"
                >
                    <template #header_buttons> </template>
                </AgGridTable>
            </div>

        </div>
        </form>
    </b-overlay>
</template>

<script>
import DataTable from "@/components/DataTable.vue";
import AgGridTable from "@/components/AgGridTable.vue";
import DataModal from "@/components/DataModal.vue";
import AdminPerms from "@/views/content/Users/AdminPerms.vue";
import EditCruds from "@/views/content/Cruds/EditCruds.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import { onBeforeUnmount } from "@vue/composition-api";

export default {
    name: "AgGridSearch",
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked,
        AdminPerms,
        EditCruds,
    },
    props: {
        sideBar: {
            default: false,
        },
        tableKey: {
            type: Number,
            default: 0,
        },
        filterKey: {
            type: String,
            default: "",
        },
        filterFields: {
            require: true,
            type: Array,
            default: [],
        },
        filterValue: {
            type: String,
            default: "",
        },
        columnDefs: {
            type: Array,
            default: [],
        },
        url: {
            type: String,
            default: "",
        },
        paginationPageSize: {
            default: 100,
        },
        inCard: {
            default: false,
        },
    },
    data() {
        return {
            isLoading: false,
            search: "",
            formId: "perms",
            formState: "",
            formData: {},
            formWidth: "lg",
            formGridApi: {},
            formKey: 0,
            table: "perms",
            usersData: [],
            requette: 1,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            element:''
        };
    },

    computed: {
        $routeData: function () {
            let router = { meta: {} };
            try {
                router = window.routeData;
            } catch (e) {}
            return router;
        },
        routeData: function () {
            let router = { meta: {} };
            if (window.router) {
                try {
                    router = window.router;
                } catch (e) {}
            }

            return router;
        },
        taille: function () {
            let result = "col-sm-12";
            if (this.filtre) {
                result = "col-sm-9";
            }
            return result;
        },
        extrasData: function () {
            let params = { baseFilter: {} };
            if (this.filterKey !== "" && this.filterValue !== "") {
                let value=this.filterValue.split(',')
                params["baseFilter"][this.filterKey] = {
                    values: value,
                    filterType: "set",
                };
            }
            if (this.search !== "") {
                params["filterFields"] = this.filterFields.filter(data=>data.split('.').length==1);
                params["globalSearch"] = this.search;
            }
            return params;
        },
    },
    watch: {
        routeData: {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null);
                this.gridApi.refreshServerSide();
                this.tableKey++;
            },
            deep: true,
        },
        extrasData: {
            handler: function (after, before) {
                console.log("lextras data a ete modifier==>", after);
                this.gridApi.sizeColumnsToFit();
                this.gridApi.refreshServerSide();
            },
            deep: true,
        },
    },
    created() {
        this.formId = this.table + "_" + Date.now();
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
    },
    beforeMount() {},
    mounted() {
        if (this.requette > 0) {
            this.$store.commit("setIsLoading", true);
        }
    },
    beforeDestroy() {
        this.$emit("destruction");
    },
    methods: {
        valider(){
          this.search=this.element
        },
        closeForm() {
            this.tableKey++;
        },
        openCreate() {
            this.showForm("Create", {}, this.gridApi);
        },
        showForm(type, data, gridApi, width = "lg") {
            this.formKey++;
            this.formWidth = width;
            this.formState = type;
            this.formData = data;
            this.formGridApi = gridApi;
            this.$bvModal.show(this.formId);
        },
        onGridReady(params) {
            console.log("on demarre", params);
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false;
            this.gridApi.sizeColumnsToFit();
        },
        getusers() {
            this.axios
                .get("/api/users")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.usersData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },
    },
};
</script>
