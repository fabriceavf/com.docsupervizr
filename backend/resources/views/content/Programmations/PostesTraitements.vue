<template>
    <div>
        <b-overlay :show="isLoading">

            <template>
                <button class="btn " @click.prevent="addAbscence()"> {{ poste }}</button>
            </template>


        </b-overlay>

    </div>


</template>

<script>


export default {
    name: 'PostesTraitements',
    components: {},
    props: [],
    data() {
        return {
            status: 'non',
            isLoading: false,
            cloturer: false,
            oldPointages: [],
            updateOldPointages: 0,
            newProgrammes: false,
            newProgrammesData: {}
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
        programmes: function () {
            let programmes = {}
            console.log('Pointages ==> voici letat actual', this.newProgrammes, this.newProgrammesData)
            if (this.newProgrammes) {
                programmes = this.newProgrammesData
            } else {
                try {
                    programmes = this.params.data.programmes
                        .filter(ele => {
                            let _date = ele.date.split(' ')[0]
                            return _date == this.params.actualDate
                        })
                    programmes = programmes[0]
                } catch (e) {
                }
            }

            console.log('Programmes ==> voici le programmes actual', programmes)

            return programmes
        },
        poste: function () {
            let poste = 'Afficher lancien poste par default ou celui du listing '
            try {
                poste = this.params.data.programmation.poste.Selectlabel

            } catch (e) {

            }


            return poste
        },
        pointages: function () {
            let pointages = []

            try {
                pointages = this.programmes.preuves
            } catch (e) {
            }

            console.log('Pointages ==> voici le pointages actual', pointages, this.programmes.preuves)

            return pointages
        },
        isPresent: function () {
            return this.pointages.length >= 1

        }
    },
    watch: {},
    created() {
        this.id = "ListingsTraitements" + Date.now()
        let _etats = 'non'
        if (this.params.data.present == 'oui') {
            _etats = 'oui'
        }
        if (this.params.etats == "manuel-cloturer" || this.params.etats == "automatique-cloturer") {
            this.cloturer = true
        }
        this.cloturer = false
        this.status = _etats

    },
    mounted() {
        console.log('voici les params passer en props pour la mise en place manuel ==>', this.params)
    },
    methods: {
        btnClickedHandler() {
            this.params.clicked(this.params.data);
        },
        addPresence() {
            console.log('voici le programme ===>', this.programmes)
            this.isLoading = true
            this.axios.post('/api/pointagesActionAddPresence', this.programmes)
                // this.axios.post('/api/pointages/action?action=addPresence', this.programmes)
                .then(response => {
                    this.isLoading = false
                    this.newProgrammes = true,
                        this.newProgrammesData = response.data
                })
                .catch(error => {
                    this.isLoading = false
                    this.newProgrammes = false
                    this.newProgrammesData = {}
                })
        },
        addAbscence() {
            console.log('voici le programme ===>', this.programmes)
            this.isLoading = true
            this.axios.post('/api/pointagesActionAddAbscence', this.programmes)
                // this.axios.post('/api/pointages/action?action=addAbscence', this.programmes)
                .then(response => {
                    this.isLoading = false
                    this.newProgrammes = true,
                        this.newProgrammesData = response.data
                })
                .catch(error => {
                    this.isLoading = false
                    this.newProgrammes = false
                    this.newProgrammesData = {}
                })
        },
        canAdmin() {
            // fonction utiliser pour verifier si je peux encore changer le status dun agent
            return this.params.etats == 'manuel'
        }
    }
}
</script>
