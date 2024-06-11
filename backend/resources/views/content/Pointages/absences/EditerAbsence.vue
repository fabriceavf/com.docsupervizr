<template>
    <b-overlay :show="isLoading">
        <div>
            <h4 class="text-center">Informations Pointage</h4>
            <p class="text-center">Programme de {{ this.form.faction_horaire }}</p>
            <hr>

            <p>
                <strong>Tache:</strong> {{ getTacheLibelle(this.form.programme.programmation.tache.libelle) }}
            </p>

            <p>
                <strong>Employe:</strong> {{ this.employe.nom }} {{ this.employe.prenom }}
            </p>

            <div class=" mb-3">
                <strong>Debut prévu:</strong> {{ this.form.debut_prevu }} <br>
                <strong>Fin prévu:</strong> {{ this.form.fin_prevu }}
            </div>
        </div>

        <form @submit.prevent="editLine()">
            <div class="form-group ">
                <label>Type</label>
                <select v-model="form.abscence_type" class="form-control" required>
                    <option value="1">AT- Accident de travail (Avec solde)</option>
                    <option value="1">EF- Evenement familliale (Avec solde)</option>
                    <option value="2">EF- Evenement familliale (Sans solde)</option>
                    <option value="1">A- Absence autorisé (Avec solde)</option>
                    <option value="1">M Maladie (Avec solde)</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group col-6">
                    <label>Début</label>
                    <input v-model="form.abscence_debut" class="form-control" required type="date">
                </div>
                <div class="form-group col-6">
                    <label>Fin</label>
                    <input v-model="form.abscence_fin" class="form-control" required type="date">
                </div>
            </div>

            <div class="form-group">
                <label>Motif <span class="text-danger">*</span></label>
                <textarea v-model="form.abscence_motif" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Televerser un fichier </label>
                <input class="form-control" type="file" @change="previewFiles">
            </div>

            <button class="btn btn-primary" type="submit" @click="justifier()">
                <i class="fas fa-floppy-disk"></i> Justifier l'absence
            </button>
        </form>
    </b-overlay>
</template>
<script>
import $ from 'jquery'

export default {
    name: 'DetailsPointage',
    props: ['data', 'table'],
    data() {
        return {
            errors: [],
            employe: [],
            isLoading: false,
            form: {
                user_id: 0,
                code: '',
                abscence_libelle: '',
                abscence_motif: '',
                abscence_debut: '',
                abscence_fin: '',
                abscence_file: '',
                abscence_type: ''
            }
        }
    },
    mounted() {
        this.form = Object.assign({
            user_id: 0,
            code: '',
            abscence_libelle: '',
            abscence_motif: '',
            abscence_debut: '',
            abscence_fin: '',
            abscence_file: '',
            abscence_type: ''
        }, this.data[0])
        this.employe = this.data[0].user
        this.user_id = this.data[0].user.id
    },
    methods: {
        editLine() {
            console.log('this', this.data, this.form)
            this.isLoading = true
            let id = 0;
            if (Array.isArray(this.data) && this.data.length >= 0) {
                id = this.data[0].id
            }
            let senData = Object.assign(this.form, {})
            delete senData.programme
            delete senData.user
            console.log('voici les donnees ', this.data[0])
            this.axios.post('/api/pointages/' + id + "/update", senData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                this.isLoading = false
                this.form = response.data
                $('#close_modal_absence' + this.formLine[0].id).click()
                $('#refresh' + this.table).click()
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
            })
        },
        justifier() {
            // alert('on veut justifier')
            console.log('this', this.data, this.form)
            this.isLoading = true
            let id = 0;
            if (Array.isArray(this.data) && this.data.length >= 0) {
                id = this.data[0].id
            }
            let senData = {}
            senData.user_id = this.form.user_id
            senData.libelle = this.form.abscence_libelle,
                senData.motif = this.form.abscence_motif,
                senData.debut = this.form.abscence_debut,
                senData.fin = this.form.abscence_fin,
                senData.solder = this.form.abscence_type


            this.axios.post('/api/abscences', senData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                this.isLoading = false
                this.form = response.data
                $('#close_modal_absence' + this.formLine[0].id).click()
                $('#refresh' + this.table).click()
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
            })
        },
        getTacheLibelle(data) {
            if (data) return data
            else return ''
        },
        previewFiles(event) {
            console.log(event.target.files);
            this.form.abscence_file = event.target.files[0]
        }
    }
}
</script>
