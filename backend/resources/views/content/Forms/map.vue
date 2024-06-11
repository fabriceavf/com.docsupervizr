<template>

    <div class="row">

        <div class="col-sm-12">
            <div id="maps" style="width: 1500px; height: 800px"></div>
        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import ManageForms from './ManageForms.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import {getGoogleMapsAPI} from 'gmap-vue';
import {Loader} from "@googlemaps/js-api-loader"

export default {
    name: 'map',
    components: {DataTable, AgGridTable, ManageForms, DataModal, AgGridBtnClicked},
    data() {

        return {
            center: {lat: 0.414951, lng: 9.465233},
            zoom: 15,
            options: {
                zoomControl: false,
                fullscreenControl: false,
                mapTypeControl: false,
                disableDefaultUI: true,
                styles: [
                    {
                        featureType: "all",
                        elementType: "labels",
                        stylers: [
                            {visibility: "off"}
                        ]
                    },
                    {
                        featureType: "landscape",
                        elementType: "all",
                        stylers: [
                            {visibility: "off"}
                        ]
                    },


                ]

            },
            map: null,
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
        google: function () {
            return getGoogleMapsAPI();
        },
    },
    watch: {
        'routeData': {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null)
                this.gridApi.refreshServerSide()
            },
            deep: true
        },
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/forms-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        const that = this


    },
    beforeMount() {
        this.columnDefs =
            [
                {
                    field: "id",
                    sortable: true,
                    filter: 'agTextColumnFilter',
                    filterParams: {suppressAndOrCondition: true,},
                    hide: true,
                    headerName: '#Id',
                },
                {
                    field: null,
                    headerName: '',
                    suppressCellSelection: true,
                    minWidth: 80, maxWidth: 80,
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
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },


                {
                    field: "description",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'description',
                },


                // {
                //     field: "childs",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'childs',
                // },


                // {
                //     field: "champs",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'champs',
                // },
                //
                //
                // {
                //     field: "creat_by",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'creat_by',
                // },


            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        const loader = new Loader({
            apiKey: 'AIzaSyBlaxIl2Zh4hsUEJYhWABY8VE0mZXr6Ats',
            version: "weekly",
        });

        loader.load().then(async () => {
            const {Map} = await google.maps.importLibrary("maps");

            this.map = new Map(document.getElementById("maps"), {
                center: this.center,
                zoom: this.zoom,
                options: this.options
            });
            this.map.setOptions(this.options)
            this.map.addListener('click', e => {
                let posit = this.point2LatLng(e.pixel, this.map)
                console.log('on as cliquer', e, e.latLng.lat(), e.latLng.lng(), posit.lat(), posit.lng());
            })
            console.log('ca as charger');
        });


    },
    methods: {
        closeForm() {
            this.tableKey++
        },

        point2LatLng(point, map) {
            var topRight = map.getProjection().fromLatLngToPoint(map.getBounds().getNorthEast());
            var bottomLeft = map.getProjection().fromLatLngToPoint(map.getBounds().getSouthWest());
            var scale = Math.pow(2, map.getZoom());
            var worldPoint = new google.maps.Point(point.x / scale + bottomLeft.x, point.y / scale + topRight.y);
            return map.getProjection().fromPointToLatLng(worldPoint);
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        showForm(type, data, gridApi, width = 'xl') {
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
