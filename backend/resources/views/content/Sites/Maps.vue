<template>

    <div :id="idMap" style="width: 100%; height: 80vh"/>
</template>

<script>
/* eslint-disable no-undef */
import {Loader} from '@googlemaps/js-api-loader'

const GOOGLE_MAPS_API_KEY = 'AIzaSyCsYZ8RYgcdIBNeUswMFYb-e0F6BJZx3Mc'
// const GOOGLE_MAPS_API_KEY = {{ env('GOOGLE_MAP_KEY') }}

export default {
    name: 'App',
    data() {
        return {
            idMap: "",
            map: null,
            drawingPolygon: false,
            clickListener: null,
            center: {
                lat: 0.3937227,
                lng: 9.4520303
            },
            mapApiKey: 'AIzaSyCsYZ8RYgcdIBNeUswMFYb-e0F6BJZx3Mc'
        }
    },
    created() {
        this.idMap = "Maps_" + Date.now()
    },
    // setup() {
    //
    //
    //     // const { coords } = useGeolocation()
    //     const currPos = computed(() => ())
    //     const otherPos = ref(null)
    //
    //     const loader = new Loader({ apiKey: GOOGLE_MAPS_API_KEY })
    //     const mapDiv = ref(null)
    //     let map = ref(null)
    //     let clickListener = null
    //
    //     onUnmounted(async () => {
    //         if (clickListener) clickListener.remove()
    //         // polygons.forEach((polygon) => {
    //         //   polygon.setMap(null);
    //         // });
    //     })
    //
    //     let line = null
    //     watch([map, currPos, otherPos], () => {
    //         if (line) line.setMap(null)
    //         if (map.value && otherPos.value != null)
    //             line = new google.maps.Polyline({
    //                 path: [currPos.value, otherPos.value],
    //                 map: map.value
    //             })
    //     })
    //
    //     const haversineDistance = (pos1, pos2) => {
    //         const R = 3958.8 // Radius of the Earth in miles
    //         const rlat1 = pos1.lat * (Math.PI / 180) // Convert degrees to radians
    //         const rlat2 = pos2.lat * (Math.PI / 180) // Convert degrees to radians
    //         const difflat = rlat2 - rlat1 // Radian difference (latitudes)
    //         const difflon = (pos2.lng - pos1.lng) * (Math.PI / 180) // Radian difference (longitudes)
    //
    //         const d =
    //             2 *
    //             R *
    //             Math.asin(
    //                 Math.sqrt(
    //                     Math.sin(difflat / 2) * Math.sin(difflat / 2) +
    //                     Math.cos(rlat1) *
    //                     Math.cos(rlat2) *
    //                     Math.sin(difflon / 2) *
    //                     Math.sin(difflon / 2)
    //                 )
    //             )
    //         return d
    //     }
    //     const distance = computed(() =>
    //         otherPos.value === null
    //             ? 0
    //             : haversineDistance(currPos.value, otherPos.value)
    //     )
    //     return { currPos, otherPos, distance, mapDiv }
    // },
    async mounted() {
        let loader = new Loader({apiKey: this.mapApiKey})
        await loader.load()
        this.map = new google.maps.Map(document.getElementById("map"), {
            center: this.center,
            zoom: 15,
            mapTypeId: 'hybrid'
        })
        // //   clickListener = map.value.addListener(
        // //     'click',
        // //     ({ latLng: { lat, lng } }) =>
        // //       (otherPos.value = { lat: lat(), lng: lng() })
        // //   )
        // let clickListener = map.value.addListener(
        //     'click',
        //     ({ latLng: { lat, lng } }) => {
        //         console.log('je clique et je vais tracer ')
        //         if (!drawingPolygon) {
        //             startDrawingPolygon();
        //         }
        //         const position = { lat: lat(), lng: lng() };
        //         if (polygonVertices.length > 0) {
        //             const lastVertex = polygonVertices[polygonVertices.length - 1];
        //             drawLine(lastVertex, position); // Dessiner une ligne entre les deux derniers points
        //         }
        //         polygonVertices.push(position);
        //         if (polygonVertices.length > 1) {
        //             const lastVertex = polygonVertices[polygonVertices.length - 1];
        //             const firstVertex = polygonVertices[0];
        //             if (
        //                 Math.abs(lastVertex.lat - firstVertex.lat) < 0.0001 &&
        //                 Math.abs(lastVertex.lng - firstVertex.lng) < 0.0001
        //             ) {
        //                 endDrawingPolygon();
        //             }
        //         }
        //     }
        // );
    },
    methods: {
        drawLine(start, end) {
            const line = new google.maps.Polyline({
                path: [start, end],
                strokeColor: '#0000FF',
                strokeOpacity: 0.8,
                strokeWeight: 2,
            });
            line.setMap(map.value);
            lines.push(line);
        },
        startDrawingPolygon() {
            drawingPolygon = true;
            polygonVertices = [];
            lines.forEach(line => line.setMap(null)); // Nettoyer les lignes précédentes
            lines = [];
        },
        endDrawingPolygon() {
            drawingPolygon = false;
            if (polygonVertices.length > 2) {
                drawPolygon(polygonVertices);
            }
        },
        drawPolygon(vertices) {
            const polygon = new google.maps.Polygon({
                paths: vertices,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
            });
            polygon.setMap(map.value);
        }

    }
}
</script>
