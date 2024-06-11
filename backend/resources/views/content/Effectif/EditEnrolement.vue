<template>
    <b-overlay :show="this.isLoading">
        <nav>
            <div id="nav-tab" class="nav nav-tabs" role="tablist">
                <button id="nav-home-tab" aria-controls="nav-home" aria-selected="true" class="nav-link active"
                        data-target="#nav-home"
                        data-toggle="tab" role="tab" type="button">General
                </button>
                <button id="nav-contact-tab" aria-controls="nav-contact" aria-selected="false" class="nav-link"
                        data-target="#nav-contact"
                        data-toggle="tab" role="tab" type="button">Document
                </button>
            </div>
        </nav>
        <div id="nav-tabContent" class="tab-content">
            <div id="nav-home" aria-labelledby="nav-home-tab" class="tab-pane fade show active" role="tabpanel">
                <form class="container" @submit.prevent="saveForm()">
                    <div class="row">
                        <div class="col-4">
                            <img class="w-100 rounded my-3" src="../../assets/default_photo.jpg">
                            <a href="#" @click.prevent="select_file_open()">
                                <i class="fas fa-image"></i> Sélectionner une photo dans votre galerie
                            </a>
                        </div>
                        <div class="col-8">
                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">Matricule</label>
                                <div class="col-sm-9">
                                    <input v-model="form.matricule" class="form-control" required type="text">
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">Nom</label>
                                <div class="col-sm-9">
                                    <input v-model="form.nom" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Prenom</label>
                                <div class="col-sm-9">
                                    <input v-model="form.prenom" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date de naissance</label>
                                <div class="col-sm-9">
                                    <input v-model="form.date_naissance" class="form-control" type="date">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sexe</label>
                                <div class="col-sm-9">
                                    <select v-model="form.sexe" class="form-control">
                                        <option :selected="{selected: form.sexe == 'Masculin' }" value="Masculin">
                                            Masculin
                                        </option>
                                        <option :selected="{selected: form.sexe == 'Feminin' }" value="Feminin">
                                            Feminin
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Fonction</label>
                                <div class="col-sm-9">
                                    <select v-model="form.fonction_id" class="form-control">
                                        <option v-for="fonction in this.fonctions" :key="fonction.id"
                                                :value="fonction.id">
                                            {{ fonction.libelle }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!--div class="form-group row">
                              <label class="col-sm-3 col-form-label">Nationalite</label>
                              <div class="col-sm-9">
                                <select class="form-control" v-model="form.nationalite">
                                  <option v-for="nation in this.pays" :key="nation.id" :value="nation.libelle">{{nation.libelle}}</option>
                                </select>
                              </div>
                            </!--div>
                            <div-- class="form-group row">
                              <label class="col-sm-3 col-form-label">Situation matrimoniale</label>
                              <div class="col-sm-9">
                                <select class="form-control" v-model="form.situation_matri">
                                  <option value="Celibataire" selected>Celibataire</option>
                                  <option value="Marié" >Marié</option>
                                </select>
                              </div>
                            </div-->
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Telephone</label>
                                <div class="col-sm-9">
                                    <input v-model="form.telephone" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Numero Badge </label>
                                <div class="col-sm-9">
                                    <input v-model="form.num_badge" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Code employé</label>
                                <div class="col-sm-9">
                                    <input v-model="form.code_employe" class="form-control" type="text">
                                </div>
                            </div>
                            <!--div class="form-group row">
                              <label class="col-sm-3 col-form-label">Nombre d'enfants</label>
                              <div class="col-sm-9">
                                <input type="number" class="form-control" v-model="form.nb_enfant">
                              </div>
                            </div>
                            <-div class="form-group row">
                              <label class="col-sm-3 col-form-label">Num CNSS </label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="form.num_cnss">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Num CNAMGS </label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="form.num_cnamgs">
                              </div>
                            </div-->
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Statut</label>
                                <div class="col-sm-9">
                                    <select v-model="form.statut" class="form-control" required>
                                        <option :selected="{selected: form.statut == 'En poste' }" value="En poste">En
                                            poste
                                        </option>
                                        <option :selected="{selected: form.statut == 'Retraite' }" value="Retraite">
                                            Retraite
                                        </option>
                                        <option :selected="{selected: form.statut == 'Fin contrat' }"
                                                value="Fin contrat">Fin contrat
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-danger mr-2" type="button" @click.prevent="DeleteLine()">
                            <i class="fas fa-close"></i> Supprimer
                        </button>
                        <button v-if="form.actif === 0" class="btn btn-success" type="button"
                                @click.prevent="validerEmploye()">
                            <i class="fas fa-check"></i> Valider
                        </button>
                        <button class="btn btn-primary float-right" type="submit">
                            <i class="fas fa-floppy-disk"></i> Sauvegarder les modifications
                        </button>
                    </div>


                </form>
            </div>
            <div id="nav-contact" aria-labelledby="nav-contact-tab" class="tab-pane fade" role="tabpanel">
                <form class="my-3" @submit.prevent="saveDocument()">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Fichier</label>
                            <input ref="document" class="form-control" required type="file"
                                   v-on:change="onFileChange()">
                        </div>
                        <div class="form-group col-6">
                            <label>Libelle</label>
                            <input v-model="document.libelle" class="form-control" required type="text">
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">
                        <i class="fa-solid fa-save"></i> Ajouter
                    </button>
                </form>

                <DataTable :fields="fields_documents" :url="url_documents" class="mt-3" limit="10" table="documents">
                    <template #datatable_btns="slotProps">
                        <div class="d-flex ">
                            <button class="btn btn-sm btn-info mr-1" @click.prevent="openFile(slotProps.data)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click.prevent="deleteDocument(slotProps.id)">
                                <i class="fa-solid fa-trash-alt"></i>
                            </button>
                        </div>
                    </template>
                </DataTable>

            </div>
        </div>
    </b-overlay>
</template>

<script>
import Webcam from 'webcam-easy'
import DataTable from '@/components/DataTable.vue'
import moment from 'moment'
import $ from 'jquery'

export default {
    components: {DataTable},
    props: ['formLine', 'fonctions', 'pays'],
    data() {
        return {
            camera: false,
            step: 1,
            webcam_object: null,
            url: null,
            url_documents: '/api/documents?',
            errors: [],
            showErrors: false,
            isLoading: false,
            form: {
                statut: '',
                nom: '',
                prenom: '',
                date_naissance: '',
                sexe: '',
                nationalite: '',
                situation_matri: '',
                telephone: '',
                nb_enfant: '',
                num_cnss: '',
                num_cnamgs: '',
                matricule: '',
                contrat: '',
                fonction_id: '',
                code_employe: '',
                num_badge: '',
                date_embauche: '',
                photo: '',
                actif: false
            },
            document: {
                libelle: '',
                fichier: '',
                user_id: ''
            },
            fields_documents:
                [
                    {
                        key: 'id',
                        label: ''
                    },
                    {
                        key: 'libelle',
                        sortable: true,
                        label: 'Libelle'
                    },
                    {
                        key: 'created_at',
                        sortable: true,
                        formatter: function (row) {
                            if (row) return moment(String(row)).format('DD/MM/YYYY à HH:mm')
                        },
                        label: 'Ajouté le',
                    },
                ]
        }
    },
    mounted() {
        this.form = Object.assign({}, this.formLine[0])
    },
    methods: {
        prev() {
            this.step--
        },
        next() {
            this.step++
        },
        saveForm() {
            this.isLoading = true
            const config = {
                headers: {'Content-Type': 'multipart/form-data'}
            }
            this.axios.post('/api/users/' + this.formLine[0].id + '/update', this.form, config).then(response => {
                this.isLoading = false
                $('#close_modal_enrolement' + this.formLine[0].id).click()
                $('#refresh' + this.table).click()
                this.$toast.success('Enrolement modifié')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        validerEmploye() {
            this.isLoading = true
            this.form.actif = true
            this.axios.post('/api/users/' + this.formLine[0].id + '/update', this.form).then(response => {
                this.isLoading = false
                $('#close_modal_enrolement' + this.formLine[0].id).click()
                $('#refresh' + this.table).click()
                this.$toast.success('Enrolement validé')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la validation')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/users/' + this.formLine[0].id + '/delete').then(response => {
                this.isLoading = false
                $('#close_modal_enrolement' + this.formLine[0].id).click()
                $('#refresh' + this.table).click()
                this.$toast.success('Enrolement supprimé')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        run_webcam() {
            const webcamElement = document.getElementById('webcam')
            const canvasElement = document.getElementById('canvas')
            const snapSoundElement = document.getElementById('snapSound')
            const webcam = new Webcam(webcamElement, 'enviroment', canvasElement, snapSoundElement)

            this.$store.commit('setLoading', true)
            webcam.start()
                .then(result => {
                    this.$store.commit('setLoading', false)
                    console.log('webcam started')
                })
                .catch(err => {
                    this.$store.commit('setLoading', false)
                    console.log(err)
                })
            this.webcam_object = webcam
        },
        select_file_open() {
            document.getElementById('select_file').click()
        },
        onFileChange(e) {
            const file = e.target.files[0]
            this.url = URL.createObjectURL(file)
            this.photo = e.target.files[0]
        },
        take_picture() {

        },
        save_picture() {

        },
        deleteDocument(id) {
            if (!window.confirm("etes vous sur de vouloir supprimer ?")) {
                return
            }
            this.isLoading = true
            this.axios.post('/api/documents/' + id + '/delete').then(response => {
                this.isLoading = false
                this.$toast.success('Document supprimé!')
                $('#refreshdocuments').click()
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Une erreur s\'est produite lors de la suppression!')
            })
        },
        saveDocument() {
            this.isLoading = true
            const config = {
                headers: {'Content-Type': 'multipart/form-data'}
            }
            this.document.user_id = this.form.id
            this.axios.post('/api/documents', this.document, config).then(response => {
                this.isLoading = false
                this.resetDocumentForm()
                $('#refreshdocuments').click()
                this.$toast.success('Nouveau document ajouté !')
                console.log(response.data)
            }).catch(error => {
                this.key++
                this.showErrors = true
                this.errors = error.response.data.errors
                this.isLoading = false
                // this.$toast.error('Une erreur s\'est produite lors de l\'enregistrement !')
            })
        },
        resetDocumentForm() {
            this.form = {
                libelle: '',
                fichier: '',
                user_id: ''
            }
        },
        openFile(data) {
            // console.log(data[0])
            if (data) window.open(this.$store.state.api_url + '/' + data[0].fichier, '_blank');
        }
    }
}
</script>

<style>

</style>
