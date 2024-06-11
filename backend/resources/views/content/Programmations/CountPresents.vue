<template>
    <div class="container">
        {{ present }}


    </div>
</template>

<script>
import VSelect from 'vue-select'

export default {
    name: "CountPresent",
    components: {VSelect},
    props: ['data'],
    data() {
        return {
            isLoading: false,
            pointage: null,
            heure: null,
            donnees: {}
        }
    },
    mounted() {
        console.log('voici les donnees renvoyer', this.params.data)

    },
    computed: {
        present: function () {
            let type = 'fin';
            return type

        },
    },
    methods: {}
}
</script>

<style scoped>

</style>
