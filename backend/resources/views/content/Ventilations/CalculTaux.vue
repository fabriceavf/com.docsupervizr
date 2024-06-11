<template>

    <div class="progress" style="height: 100%;">
        <b-overlay :show="isLoading" style="left: 50%;">
            <span class="taux">   {{ tauxTraiter }} %</span>
            <div :aria-valuenow="tauxTraiter" :style="`width: ${tauxTraiter}%;`" aria-valuemax="100" aria-valuemin="0"
                 class="progress-bar" role="progressbar"></div>
        </b-overlay>
    </div>


</template>

<script>

export default {
    name: "CalculTaux",
    data() {
        return {
            isLoading: false,
            nbrs_pointage_non_traiter: 0,
            nbrs_tout_pointages: 0
        }
    },
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },
        tauxTraiter: function () {
            let traiter = parseInt(this.nbrs_tout_pointages) - parseInt(this.nbrs_pointage_non_traiter)
            let diviser = this.nbrs_tout_pointages
            if (this.nbrs_tout_pointages == 0) {
                diviser = 1
            }
            let taux = traiter * 100 / diviser
            taux = parseFloat(taux).toFixed(0)
            return taux
        }
    },
    mounted() {
        this.getTaux()

        console.log('voici le calcultaux ==>', this.params)
    },
    methods: {
        getTaux() {
            this.isLoading = true
            this.axios.get(`/api/programmationsActionGtTaux&key=${this.params.data.id}`)
                // this.axios.get(`/api/programmations/action?action=getTaux&key=${this.params.data.id}`)
                .then(response => {
                    console.log('voici le taux', response.data)
                    this.nbrs_pointage_non_traiter = response.data.nbrs_pointage_non_traiter
                    this.nbrs_tout_pointages = response.data.nbrs_tout_pointages
                    this.isLoading = false
                })
        }
    }

}
</script>

<style scoped>
.taux {
    position: absolute;
    top: 50%;
    left: 50%;
}

</style>
