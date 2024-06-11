<template>
    <div>
        <div class="google">

            <div :id="mapId" ref="input" class="map" style="">


            </div>
        </div>


    </div>
</template>


<script>
import {Loader} from "@googlemaps/js-api-loader"
import Marquer from "./Marquer.vue";

export default {
    name: 'Maps',
    components: {
        Marquer
    },
    data() {

        return {
            mapId: '',
            map: null,
            center: {
                lat: 0.3937227,
                lng: 9.4520303
            },
            zoom: 16
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


    },
    beforeMount() {
        this.mapId = "GoogleMap_" + Date.now()


    },
    mounted() {

        /**
         * The custom USGSOverlay object contains the USGS image,
         * the bounds of the image, and a reference to the map.
         */



        const loader = new Loader({
            apiKey: "AIzaSyCsYZ8RYgcdIBNeUswMFYb-e0F6BJZx3Mc",
            version: "weekly",
        });

        loader.load().then(async () => {
            class customMarker extends google.maps.OverlayView {
                constructor(map, position) {
                    super();
                    this.pos = position
                    this.map = map
                    this.setMap(map);
                    this.id = "GoogleMapMarker_" + Date.now()
                }

                /**
                 * onAdd is called when the map's panes are ready and the overlay has been
                 * added to the map.
                 */
                onAdd() {

                    let marquer = document.createElement("div")
                    marquer.id = this.id
                    this.div = document.createElement("div");
                    this.div.style.position = "absolute";
                    this.div.appendChild(marquer)
                    // Add the element to the "overlayLayer" pane.
                    const panes = this.getPanes();
                    panes.overlayImage.appendChild(this.div);
                    window.addMarker("#" + this.id)

                }

                draw() {
                    // // We use the south-west and north-east
                    // // coordinates of the overlay to peg it to the correct position and size.
                    // // To do this, we need to retrieve the projection from the overlay.
                    let overlayProjection = this.getProjection();
                    // // Retrieve the south-west and north-east coordinates of this overlay
                    // // in LatLngs and convert them to pixel coordinates.
                    // // We'll use these coordinates to resize the div.
                    let position = overlayProjection.fromLatLngToDivPixel(this.pos);
                    //
                    // // Resize the image's div to fit the indicated dimensions.
                    if (this.div) {
                        this.div.style.left = position.x + "px";
                        this.div.style.top = position.y + "px";

                    }
                }

                /**
                 * The onRemove() method will be called automatically from the API if
                 * we ever set the overlay's map property to 'null'.
                 */
                onRemove() {

                }

                /**
                 *  Set the visibility to 'hidden' or 'visible'.
                 */
                hide() {

                }

                show() {

                }

                toggle() {
                    if (this.div) {
                        if (this.div.style.visibility === "hidden") {
                            this.show();
                        } else {
                            this.hide();
                        }
                    }
                }

                toggleDOM(map) {
                    if (this.getMap()) {
                        this.setMap(null);
                    } else {
                        this.setMap(map);
                    }
                }
            }

            const {Map} = await google.maps.importLibrary("maps");

            this.map = new Map(document.getElementById(this.mapId), {
                center: this.center,
                zoom: this.zoom,
            });
            var drawingManager = new google.maps.drawing.DrawingManager();
            drawingManager.setMap(this.map);
            let id = "GoogleMapMarker_" + Date.now()
            const overlay = new customMarker(this.map, this.center);
            clickListener = this.map.addListener(
                'click',
                ({latLng: {lat, lng}}) => this.clickMap({lat: lat(), lng: lng()})
            )

            window.addMarker(this.id)
        });


    },
    methods: {
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
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
        getvoitures() {
            this.axios.get('/api/voitures').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.voituresData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        clickMap(data) {
            alert('on as cliquer sur la map')
        }

    }
}
</script>
<style>

.map {
    height: 100vh

}
</style>
