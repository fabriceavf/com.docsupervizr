<template>
    <div>
        <GmapMap :center="center" :zoom="13" style="width: 100%; height: 400px;">
            <GmapMarker :position="center"></GmapMarker>
        </GmapMap>
    </div>
</template>

<script>
// Dans votre fichier .vue
// import {GmapMap, GmapMarker} from 'vue2-google-maps';

export default {
    data() {
        return {
            center: {lat: 48.858844, lng: 2.294351}, // Coordonnées de Paris, par exemple
        };
    },
};
</script>
