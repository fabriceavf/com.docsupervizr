<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">
                <div class="form-group ">
                    <label>Libelle</label>
                    <input v-model="form.libelle" class="form-control" type="text">
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input id="1" v-model="form.type" :checked="{ checked: form.type === 'Collecte' }"
                               class="form-check-input"
                               type="radio"
                               value="Collecte">
                        <label class="form-check-label" for="1">
                            Collecte
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="2" v-model="form.type" :checked="{ checked: form.type === 'Atelier' }"
                               class="form-check-input"
                               type="radio"
                               value="Atelier">
                        <label class="form-check-label" for="2">
                            Atelier
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="3" v-model="form.type" :checked="{ checked: form.type === 'Administratif' }"
                               class="form-check-input" type="radio"
                               value="Administratif">
                        <label class="form-check-label" for="3">
                            Administratif
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Ville</label>
                    <select v-model="form.ville_id" class="form-control">
                        <option v-for="ville in this.villes" :key="ville.id" :value="ville.id">{{
                                ville.libelle
                            }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>

        </form>

        <button id="refresh-horaires" class="invisible" @click="getHoraires()"></button>

        <div v-if="horaires.length > 0">
            <hr class="my-2">
            <h5>Horaires</h5>
            <ul>
                <li v-for="horaire in horaires" :key="horaire.id">
                    <a class="btn" href="#" @click.prevent="showEditHoraireForm(horaire)">
                        <i class="fas fa-edit"></i> {{ horaire.libelle }} [{{ horaire.debut }} - {{ horaire.fin }} ]
                    </a>
                </li>
            </ul>
        </div>

        <hr class="my-2">
        <div v-if="hoursForm === 'create'">
            <button id="" class="btn mb-3 text-danger" type="button" @click.prevent="closeHoraireForm">
                <i class="fa-solid fa-circle-xmark"></i> Fermer
            </button>
            <CreateHoraire :tache_id="this.formLine[0].id"/>
        </div>
        <div v-else-if="hoursForm === 'edit'">
            <button id="close-edit-form" class="btn mb-3 text-danger" type="button" @click.prevent="closeHoraireForm">
                <i class="fa-solid fa-circle-xmark"></i> Fermer
            </button>
            <EditHoraire :key="horaireSelected.id" :horaire="horaireSelected"/>
        </div>
        <div v-else>
            <a href="#open" @click.prevent="showHoraireForm">
                <i class="fas fa-plus"></i> Ajouter une horaire
            </a>
        </div>
    </b-overlay>
</template>

<script>
import $ from 'jquery'
import CreateHoraire from './Horaires/CreateHoraire.vue'
import EditHoraire from './Horaires/EditHoraire.vue'

export default {
    name: 'EditTache',
    props: ['formLine', 'villes', 'table'],
    components: {CreateHoraire, EditHoraire},
    data() {
        return {
            hoursForm: '',
            errors: [],
            horaires: [],
            horaireSelected: [],
            isLoading: false,
            form: {
                code: '',
                libelle: '',
                type: '',
                ville_id: ''
            }
        }
    },
    mounted() {
        this.getHoraires()
        this.form = this.formLine[0]
    },
    methods: {
        EditLine() {
            this.isLoading = true
            this.axios.post('/api/taches/' + this.formLine[0].id + '/update', this.form).then(response => {
                this.isLoading = false
                $('#close_modal_tache' + this.formLine[0].id).click()
                $('#refresh' + this.table).click()
                this.$toast.success('Nouvelle tache ajouté')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/taches/' + this.formLine[0].id + '/delete').then(response => {
                this.isLoading = false
                $('#close_modal_tache' + this.formLine[0].id).click()
                $('#refresh' + this.table).click()
                this.$toast.success('Tache supprimé')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        getHoraires() {
            this.axios.get('/api/horaires?filter[tache_id]=' + this.formLine[0].id).then((response) => {
                this.horaires = response.data
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        showHoraireForm() {
            this.hoursForm = 'create'
        },
        showEditHoraireForm(tab) {
            this.hoursForm = 'edit'
            this.horaireSelected = tab
        },
        closeHoraireForm() {
            this.hoursForm = ''
        }
    }
}
</script>
