<template>
    <div class="container">

        <form @submit.prevent="addPointage()">
            <p>Rajouter un pointage de {{ type }} manuellement</p>
            <div class="form-row">
                <div class="form-group col-6">
                    <input :value="dateManquant" class="form-control" disabled type="text">
                </div>
                <div class="form-group col-6">
                    <input v-model="heure" class="form-control" required type="time">
                </div>
            </div>
            <button class="btn btn-sm mt-2 btn-success" type="submit">
                <i class="fa-solid fa-save"></i> Rajouter
            </button>
        </form>


    </div>
</template>

<script>
import VSelect from 'vue-select'

export default {
    name: "addIncomplet",
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
        this.donnees = this.data

    },
    computed: {
        dateManquant: function () {
            let dateExistant = this.data.debut_realise;
            if (!this.data.debut_realise) {
                dateExistant = this.data.fin_realise;
            }
            try {
                dateExistant = dateExistant.split(' ')[0]
            } catch (e) {

            }
            return dateExistant

        },
        type: function () {
            let type = 'fin';
            if (!this.data.debut_realise) {
                type = 'debut';
            }
            return type

        },
    },
    methods: {
        isVariable() {
            let response = false
            try {
                let actual = this.typesabscencesData.filter(data => parseInt(data.id) == parseInt(this.abscence_id))
                actual = actual[0]
                response = actual.variable_id == 1
            } catch (e) {

            }
            return response

        },

        addPointage() {
            let data = {
                'programme_id': this.data.id,
                'punch_time': this.dateManquant + ' ' + this.heure,
                'type': 'fictif',
            }
            this.axios.post('/api/preuves', data).then(response => {
                this.isLoading = false
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('refreshData')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })

        },


    }
}
</script>

<style scoped>

</style>
