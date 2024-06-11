<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Semaine <span class="text-danger">*</span></label>
                    <input v-model="form.semaine" class="form-control" required type="week">
                </div>

                <div class="form-group col-md-8">
                    <label>Superviseur <span class="text-danger">*</span></label>
                    <select v-model="form.superviseur" class="form-control " required>
                        <option v-for="emp in employes" :key="emp.id"
                                :value="emp.matricule+' '+emp.nom+' '+emp.prenom ">
                            {{ emp.matricule }} {{ emp.nom }} {{ emp.prenom }}
                        </option>
                    </select>
                </div>

            </div>

            <button class="btn btn-primary mt-3" type="submit">
                <i class="fas fa-floppy-disk"></i> Créer
            </button>
        </form>
    </b-overlay>
</template>

<script>
import $ from 'jquery'

export default {
    name: 'Createventilation',
    props: ['ventilation_id', 'table'],
    data() {
        return {
            errors: [],
            isLoading: false,
            employes: [],
            taches: [],
            form: {
                ventilation_id: '',
                semaine: '',
                superviseur: ''
            }
        }
    },
    mounted() {
        this.getEmployes()
        this.getTaches()
        this.form.ventilation_id = this.ventilation_id
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/ventilationsActionDupliquer', this.form).then(response => {
                // this.axios.post('/api/ventilations/action?action=dupliquer', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                $('#close_modal_copy_ventilation' + this.ventilation_id).click()
                $('#refresh' + this.table).click()
                this.$toast.success('ventilation ajouté à partir d\'une autre')
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        getEmployes() {
            this.isLoading = true
            this.axios.get('/api/employes').then((response) => {
                this.employes = response.data
                this.isLoading = false
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getTaches() {
            this.isLoading = true
            this.axios.get('/api/taches').then((response) => {
                this.taches = response.data
                this.isLoading = false
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        resetForm() {
            this.form = {
                semaine: '',
                tache_id: '',
                superviseur: ''
            }
        }
    }
}
</script>
