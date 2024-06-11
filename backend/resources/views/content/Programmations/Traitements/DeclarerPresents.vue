<template>
    <div class="container">
        <div>
            <b-overlay :show="isLoading">
                <div class="parentListingsTraitements">
                    <span v-if="isCheck" class="fakeCheckBox cocher " @click.prevent="addAbscence()"></span>
                    <span v-else class="fakeCheckBox " @click.prevent="addPresence()"></span>
                </div>
            </b-overlay>

        </div>
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
            donnees: {},
            newProgrammes: false,
            newProgrammesData: {},
        }
    },
    mounted() {
        console.log('voici les donnees renvoyer', this.params.data)

    },
    computed: {
        programmes: function () {
            let programmes = {}
            console.log('Pointages ==> voici letat actual', this.newProgrammes, this.newProgrammesData)
            if (this.newProgrammes) {
                programmes = this.newProgrammesData
            } else {
                try {
                    programmes = this.params.data
                } catch (e) {
                }
            }

            console.log('Programmes ==> voici le programmes actual', programmes)

            return programmes
        },
        isCheck: function () {
            let etats = 'non';
            let pointages = []
            let min_pointage = 1;

            try {
                min_pointage = this.params.data.programmation.min_pointage
            } catch (e) {
                min_pointage = 1
            }
            try {
                pointages = this.params.data.pointages_rattacher_auto
                pointages = pointages.split(',')
            } catch (e) {
                pointages = []
            }
            if (pointages.length >= min_pointage) {
                etats = 'oui'
            }
            try {
                if (this.programmes.presence_declarer_auto != ""
                    && this.programmes.presence_declarer_auto != null
                    && this.programmes.presence_declarer_auto != undefined) {
                    etats = this.programmes.presence_declarer_auto
                }

            } catch (e) {

            }
            try {

                if (this.programmes.presence_declarer_manuel != ""
                    && this.programmes.presence_declarer_manuel != null
                    && this.programmes.presence_declarer_manuel != undefined) {
                    etats = this.programmes.presence_declarer_manuel
                }
            } catch (e) {

            }
            return etats == 'oui'

        },
    },
    methods: {
        canUpdate() {
            // fonction utiliser pour verifier si je peux encore changer le status dun agent
            let can = true;
            try {
                can = this.params.data.programmation.valider2.length < 1

                console.log('voici letat de la programmation', this.params.data.programmation, can)
            } catch (e) {
                can = true;
            }
            return can
        },

        addPresence() {
            if (this.canUpdate()) {
                this.isLoading = true
                let data = {
                    presence_declarer_manuel: 'oui',
                }
                this.axios.post('/api/programmes/' + this.programmes.id + '/update', data)
                    .then((response) => {
                        this.newProgrammes = true,
                            this.newProgrammesData = response.data
                        this.$bvModal.hide(this.formId)
                        this.$toast.success('Success')
                        this.isLoading = false
                    })
                    .catch(error => {
                        this.$toast.success('Erreur')
                        this.isLoading = false
                    })
                    .finally(e => {
                        this.isLoading = false
                    })
            } else {
                this.$toast.error('Impossible de modifier un listing deja valider par le chef de zone')
            }

        },
        addAbscence() {

            if (this.canUpdate()) {
                this.isLoading = true
                let data = {
                    presence_declarer_manuel: 'non',
                }
                this.axios.post('/api/programmes/' + this.programmes.id + '/update', data)
                    .then((response) => {
                        this.newProgrammes = true,
                            this.newProgrammesData = response.data
                        this.$toast.success('Success')
                    })
                    .catch(error => {
                        this.$toast.success('Erreur')
                    })
                    .finally(e => {
                        this.isLoading = false
                    })
            } else {
                this.$toast.error('Impossible de modifier un listing deja valider par le chef de zone')
            }

        },

    }
}
</script>

<style scoped>
.fakeCheckBox {
    width: 25px;
    height: 25px;
    border-radius: 5px;
    border-color: red;
    display: inline-block;
    border: 2px solid #867f7f;
    cursor: pointer
}

.cocher {
    background: green;

}
</style>
