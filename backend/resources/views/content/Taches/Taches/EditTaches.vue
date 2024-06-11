<template>
    <b-overlay :show="isLoading">

        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>typestaches </label>
                    <v-select
                        v-model="form.typestache_id"
                        :options="typestachesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.typestache_id" class="invalid-feedback">
                        <template v-for=" error in errors.typestache_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>villes </label>
                    <v-select
                        v-model="form.ville_id"
                        :options="villesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.ville_id" class="invalid-feedback">
                        <template v-for=" error in errors.ville_id"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group">
                    <div v-if="horaires.length > 0">
                        <hr class="my-2">
                        <h5>Horaires</h5>
                        <ul>
                            <li v-for="horaire in horaires" :key="horaire.id">
                                <a class="btn" href="#" @click.prevent="showEditHoraireForm(horaire)">
                                    <i class="fas fa-edit"></i> {{ horaire.libelle }} [{{ horaire.debut }} -
                                    {{ horaire.fin }} ]
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div v-if="hoursForm === 'create'">
                        <button id="" class="btn mb-3 text-danger" type="button" @click.prevent="closeHoraireForm">
                            <i class="fa-solid fa-circle-xmark"></i> Fermer
                        </button>
                        <CreateHoraire :tache_id="this.form.id" @refreshHoraire="refreshHoraire"/>
                    </div>
                    <div v-else-if="hoursForm === 'edit'">
                        <button id="close-edit-form" class="btn mb-3 text-danger" type="button"
                                @click.prevent="closeHoraireForm">
                            <i class="fa-solid fa-circle-xmark"></i> Fermer
                        </button>
                        <EditHoraire :key="horaireSelected.id" :horaire="horaireSelected"
                                     @refreshHoraire="refreshHoraire"/>
                    </div>
                    <div v-else>
                        <button class="btn btn-primary" @click.prevent="showHoraireForm">
                            <i class="fas fa-plus"></i> Ajouter une horaire
                        </button>
                    </div>


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

    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import CreateHoraire from './Horaires/CreateHoraire.vue'
import EditHoraire from './Horaires/EditHoraire.vue'

export default {
    name: 'EditTaches',
    components: {VSelect, CustomSelect, Files, CreateHoraire, EditHoraire},
    props: ['data', 'gridApi', 'modalFormId',
        'typestachesData',
        'villesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            hoursForm: '',
            errors: [],
            horaires: [],
            horaireSelected: [],
            isLoading: false,
            form1: {
                code: '',
                libelle: '',
                type: '',
                ville_id: ''
            },
            form: {

                id: "",

                typestache_id: "",

                libelle: "",

                ville_id: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            }
        }
    },

    mounted() {
        this.form = this.data

        this.getHoraires()
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/taches/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/taches/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        getHoraires() {
            this.axios.get('/api/horaires?filter[tache_id]=' + this.form.id).then((response) => {
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
        refreshHoraire() {
            this.hoursForm = ''
            this.getHoraires()
        },
        closeHoraireForm() {
            this.hoursForm = ''
        }
    }
}
</script>
