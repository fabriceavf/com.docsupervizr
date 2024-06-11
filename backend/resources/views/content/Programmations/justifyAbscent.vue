<template>
    <div class="container">
        <form v-if="" @submit.prevent="justifier()">


            <button v-if="!abscence_id" class="btn btn-danger" disabled style="width:100%;padding:10px">
                Veuillez selectionez un type d'abscence
            </button>
            <button v-else-if="isVariable()" class="btn btn-primary" disabled style="width:100%;padding:10px">
                C'est une abscence a jour variable donc vous pouvez selectionner le nombre de jour de vous voulez <br/>Le
                jour du programme doit etre compris entre les date selectionner
            </button>
            <button v-else class="btn btn-warning" disabled style="width:100%;padding:10px">
                C'est une abscence a jour fixe donc vous ne pouvez selectionner que {{ nombreJour }} jour(s) <br/>Le
                jour du programme doit etre compris entre les date selectionner
            </button>

            <div class="form-group ">
                <label>Type</label>
                <v-select
                    v-model="abscence_id"
                    :options="typesabscencesData"
                    :reduce="ele => ele.id"
                    label="Selectlabel"
                />
            </div>

            <div class="form-row">
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

            <button :disabled="!valide" class="btn btn-primary" type="submit">
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
        this.debut = Date.now()

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

    computed: {
        actual: function () {
            let response = {}
            try {
                response = this.typesabscencesData.filter(data => parseInt(data.id) == parseInt(this.abscence_id))
                response = response[0]
            } catch (e) {

            }
            return response

        },
        soldable: function () {
            let response = false
            try {
                response = this.actual.soldable.id == 1
            } catch (e) {

            }
            return response

        },
        valide: function () {
            let response = false
            try {
                let debut = moment(this.abscence_debut, 'YYYY-MM-DD')
                let fin = moment(this.abscence_fin, 'YYYY-MM-DD')
                let difference = fin.diff(debut, 'days')
                response = difference == this.nombreJour;
            } catch (e) {

            }

            if (this.isVariable()) {
                response = true
            }
            if (!this.abscence_fin || !this.abscence_debut || !moment(this.data.date, 'YYYY-MM-DD').isBetween(this.abscence_debut, this.abscence_fin)) {
                response = false
            }
            return response

        },
        nombreJour: function () {
            let response = 0
            try {
                response = this.actual.nombrejours
            } catch (e) {

            }
            return response

        },
    },
    methods: {
        isVariable() {
            let response = false
            try {
                response = this.actual.variable_id == 1
            } catch (e) {

            }
            return response

        },

        justifier() {
            let data = {
                'programme_id': this.data.id,
                'user_id': this.data.user_id,
                'soldable': this.soldable,
                'debut': this.abscence_debut,
                'fin': this.abscence_fin,
                'motif': this.abscence_motif,
                'typesabscence_id': this.abscence_id
            }
            this.axios.post('/api/pointages/action?action=justifierAbscences', data).then(response => {
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
