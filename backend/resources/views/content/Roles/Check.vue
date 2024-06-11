<template>
    <div class="container">
        <div>
            <b-overlay :show="isLoading">
                <div v-if="show" class="parentListingsTraitements">
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
    name: "Check",
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
        console.log('voici les donnees renvoyer', this.params)

    },
    computed: {
        isCheck: function () {
            let etats = 'non';

            try {
                etats = this.params.data[this.params.type]
            } catch (e) {
                etats = 'non'
            }
            return etats == 'oui'

        },
        show: function () {
            let totalMot = this.params.data.permission.name.split(' ')
            return totalMot.length == 1
        }
    },
    methods: {

        addPresence() {
            this.isLoading = true
            let data = {}
            data[this.params.type] = 'oui'
            this.axios.post('/api/role_has_permissions/' + this.params.data.id + '/update', data)
                .then((response) => {
                    this.params.api.applyServerSideTransaction({
                        update: [
                            response.data
                        ]
                    });
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

        },
        addAbscence() {
            this.isLoading = true
            let data = {}
            data[this.params.type] = 'non'
            this.axios.post('/api/role_has_permissions/' + this.params.data.id + '/update', data)
                .then((response) => {
                    this.params.api.applyServerSideTransaction({
                        update: [
                            response.data
                        ]
                    });
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
