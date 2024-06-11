<template>
    <b-overlay :show="isLoading">
        <div>
            <h4 class="text-center">Informations employé</h4>
            <hr>
            <div class="row">

                <div class="col-6">
                    <strong>Code:</strong> {{ this.employe.emp_code }}
                </div>
                <div class="col-6">
                    <strong>Matricule:</strong> {{ this.employe.matricule }}
                </div>
            </div>
            <p>
                <strong>Nom:</strong> {{ this.employe.nom }}
            </p>
            <p>
                <strong>Prenom:</strong> {{ this.employe.prenom }}
            </p>
        </div>

        <div>
            <hr>
            <h4 class="text-center">Informations Pointage ({{ this.form.pointeuse }})</h4>
            <p class="text-center">Programme de ({{ this.form.faction_horaire }})</p>
            <hr>

            <p>
                <strong>Tache:</strong> {{ getTacheLibelle(this.form.programme.programmation.tache.libelle) }}
            </p>

            <div class="row mb-3">
                <div class="col">
                    <strong>Debut prévu:</strong><br>
                    {{ this.form.debut_prevu }} <br>
                    <strong>Fin prévu:</strong><br>
                    {{ this.form.fin_prevu }}
                </div>
                <div class="col">
                    <div v-if="form.debut_realise != form.debut_reel">
                        <strong>Debut réel:</strong><br>
                        {{ form.debut_reel }} <br>
                    </div>
                    <strong>Debut réalisé:</strong><br>
                    {{ this.form.debut_realise }} <br>
                    <strong>Fin réalisé:</strong><br>
                    {{ this.form.fin_realise }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <strong>Volume prevu:</strong> {{ this.form.volume_prevu }}
                </div>
                <div class="col">
                    <strong>Volume realise:</strong> {{ this.form.volume_realise }}
                </div>
            </div>
        </div>
    </b-overlay>
</template>

<script>
// import $ from 'jquery'
import moment from 'moment'

export default {
    name: 'DetailsPointage',
    props: ['data'],
    data() {
        return {
            errors: [],
            employe: [],
            isLoading: false,
            firstPointage: '',
            form: {
                code: '',
                libelle: ''
            }
        }
    },
    mounted() {
        this.form = this.data[0]
        this.employe = this.data[0].user
        this.getFirstPointage()
    },
    methods: {
        getTacheLibelle(data) {
            if (data) return data
            else return ''
        },
        getFirstPointage() {
            this.isLoading = true
            this.axios.get('api/transactions?filter[emp_code]=' + this.data[0].user.emp_code + '&filter[like]=punch_time/' + moment(String(this.data[0].debut_prevu)).format('YYYY-MM-DD') + '&sort=+punch_time').then(response => {
                this.isLoading = false
                this.firstPointage = response.data[0].punch_time
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
            })
        }
    }
}
</script>
