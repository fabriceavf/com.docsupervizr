<template>
    <div class="container">
        <form v-if="" @submit.prevent="justifier()">
            <div class="form-group ">
                <label>Type</label>
                <v-select
                    v-model="abscence_id"
                    :options="typesabscencesData"
                    :reduce="ele => ele.id"
                    label="Selectlabel"
                />
            </div>

            <div v-if="isVariable()" class="form-row">
                <div class="form-group col-6">
                    <label>Début</label>
                    <input v-model="abscence_debut" class="form-control" required type="date">
                </div>
                <div class="form-group col-6">
                    <label>Fin</label>
                    <input v-model="abscence_fin" class="form-control" required type="date">
                </div>
            </div>

            <div class="form-group">
                <label>Motif <span class="text-danger">*</span></label>
                <textarea v-model="abscence_motif" class="form-control" rows="3"></textarea>
            </div>

            <!--          <div class="form-group">-->
            <!--            <label >Televerser un fichier </label>-->
            <!--&lt;!&ndash;            <input type="file" @change="previewFiles" class="form-control">&ndash;&gt;-->
            <!--          </div>-->

            <button class="btn btn-primary" type="submit">
                <i class="fas fa-floppy-disk"></i> Justifier l'absence
            </button>
        </form>


    </div>
</template>

<script>
import moment from "moment";
import VSelect from 'vue-select'

export default {
    name: "justifyAbscent",
    components: {VSelect},
    props: ['data', 'typesabscencesData'],
    data() {
        return {
            isLoading: false,
            user: {},
            debut: '',
            fin: '',
            abscence_libelle: '',
            abscence_user_id: '',
            abscence_motif: '',
            abscence_debut: '',
            abscence_fin: '',
            abscence_file: '',
            abscence_type: '',
            abscence_id: null,
        }
    },
    mounted() {

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

        justifier() {
            // alert('on veut justifier')
            this.isLoading = true
            console.log('this', this.data, this.pointage)
            this.isLoading = true
            let id = 0;
            if (Array.isArray(this.data) && this.data.length >= 0) {
                id = this.data[0].id
            }
            let senData = {}
            senData.user_id = this.pointage.user.id
            senData.libelle = this.abscence_libelle,
                senData.raison = this.abscence_motif,
                senData.debut = this.abscence_debut,
                senData.fin = this.abscence_fin,
                senData.typesabscence_id = this.abscence_type

            try {
                let abscencesSelectioner = this.typesabscences.filter(data => parseInt(data.id) == parseInt(this.abscence_type))
                // console.log('voici les abscences selctionner ==>',abscencesSelectioner)

                abscencesSelectioner = abscencesSelectioner[0]
                let nbrs = 0;
                if (abscencesSelectioner.variable_id == 2) {
                    nbrs = parseInt(abscencesSelectioner.nombrejours)
                    senData.debut = this.pointage.debut_prevu
                    senData.fin = moment(this.pointage.debut_prevu, 'YYYY-MM-DD H:m:s').add(nbrs, 'days').format('YYYY-MM-DD HH:m:ss')
                }

            } catch (e) {

            }

            console.log('sendData', senData)


            this.axios.post('/api/abscences', senData, {}).then(response => {
                this.isLoading = true
                let senData = {}
                senData.est_valide = 2
                this.axios.post('/api/pointages/' + this.pointage.id + '/update', senData).then(response => {
                    this.isLoading = false

                    try {
                        let data = {}
                        if (Array.isArray(response.data) && response.data.length >= 0) {
                            data = response.data[0]
                        } else if (Array.isArray(response.data) && response.data.length == 0) {
                            data = {}
                        } else {
                            data = response.data
                        }
                        this.$store.state.pointages[data.id] = data
                    } catch (e) {
                        console.error(e)

                    }
                    this.getPointage(this.identifiant)
                })
                    .catch(error => {
                        console.error(error)
                        this.errors = error.response.data.errors
                        this.isLoading = false
                    })

            }).catch(error => {
                console.error(error)
                this.errors = error.response.data.errors
                this.isLoading = false
            })
        },

    }
}
</script>

<style scoped>

</style>
