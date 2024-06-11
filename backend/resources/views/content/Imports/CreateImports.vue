<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="row">

                <div v-if="type == 'importspointages'" class="col-sm-4"
                     style="border-right: 1px solid rgb(80, 78, 78);">
                    <span v-if="form.typespointages == 'Pointage-Brute'">
                        <p>Structure du fichier à respecter</p>
                        <h5>1-BIO ID</h5>
                        <h5>2-DATE</h5>
                        <h5>3-HEURE</h5>
                        <h5>4-POINTEUSE</h5>
                        <h5>5-CARD NO</h5>
                    </span>
                    <span v-else>
                        <p>Structure du fichier à respecter</p>
                        <h5>1-DATE</h5>
                        <h5>2-PREMIER POINTAGE</h5>
                        <h5>3-DERNIER POINTAGE</h5>
                        <h5>4-MATRICULE</h5>
                    </span>
                </div>

                <div v-else-if="type == 'importspostes'" class="col-sm-4"
                     style="border-right: 1px solid rgb(80, 78, 78);">
                    <p>Structure du fichier à respecter</p>

                    <h5>1-Code unique du client</h5>
                    <h5>2-Nom du Client</h5>
                    <h5>3-Code unique du Contrat Clients</h5>
                    <h5>4-libelle du Contrat Clients</h5>
                    <h5>5-code unique du site</h5>
                    <h5>6-libelle du Site</h5>
                    <h5>7-libelle de la Zone</h5>
                    <h5>8-Code unique du Poste</h5>
                    <h5>9-libelle du Poste</h5>
                    <h5>10-Nombre de jour couvert</h5>
                    <h5>11-Nombre d'agent titulaire jour/nuit</h5>
                    <h5>12-Type de faction</h5>
                </div>

                <div v-else class="col-sm-4" style="border-right: 1px solid rgb(80, 78, 78);">
                    <span>
                        <p>Structure du fichier à respecter</p>
                        <h5>1-MATRICULE</h5>
                        <h5>2-NOM</h5>
                        <h5>3-PRENOM</h5>
                        <h5>4-FONCTION</h5>
                        <h5>5-DIRECTION</h5>
                        <h5>6-DATE NAISSANCE</h5>
                        <h5>7-NATIONALITE</h5>
                        <h5>8-DATE EMBAUCHE</h5>
                        <h5>9-Num CNSS</h5>
                        <h5>10-Num CNAMGS</h5>
                    </span>
                </div>


                <div class="col-sm-8">
                    <div class="form-group ">
                        <p>type </p>
                        <input v-model="form.type" :class="errors.type ? 'form-control is-invalid' : 'form-control'"
                               :disabled="true" type="text">

                        <div v-if="errors.type" class="invalid-feedback">
                            <template v-for=" error in errors.type"> {{ error[0] }}</template>

                        </div>


                        <div v-if="server_error != ''">
                            <button class="btn btn-warning" disabled style="width:100%"> {{ server_error }}</button>

                        </div>
                    </div>
                    <div v-if="steps == 1" class="form-group ">
                        <p>fichier </p>
                        <b-form-file v-model="form.file" :state="Boolean(form.file)"
                                     drop-placeholder="Drop file here..." placeholder="Selectionner le fichier"
                                     required></b-form-file>

                        <div v-if="errors.file" class="invalid-feedback">
                            <template v-for=" error in errors.file"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div v-if="type != 'importspostes' && type != 'importspointages' " class="form-group ">
                        <label>type</label>
                        <CustomSelect
                            :key="form.typeseffectif"
                            :columnDefs="['libelle']"
                            :oldValue="form.typeseffectif"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>form.typeseffectif_id=data.id"
                            :url="`${axios.defaults.baseURL}/api/typeseffectifs-Aggrid`"
                            filter-key=""
                            filter-value=""
                            required
                        />
                        <div v-if="errors.typeseffectif_id" class="invalid-feedback">
                            <template v-for=" error in errors.typeseffectif_id"> {{ error[0] }}</template>
                        </div>
                    </div>
                    <div v-if="type == 'importspostes'" class="form-group ">
                        <label>type</label>
                        <CustomSelect
                            :key="form.typesposte"
                            :columnDefs="['libelle']"
                            :oldValue="form.typesposte"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>form.typesposte_id=data.id"
                            :url="`${axios.defaults.baseURL}/api/typespostes-Aggrid`"
                            filter-key=""
                            filter-value=""
                            required
                        />
                        <div v-if="errors.typesposte_id" class="invalid-feedback">
                            <template v-for=" error in errors.type"> {{ error[0] }}</template>
                        </div>

                    </div>
                    <div v-if="type == 'importspointages'" class="form-group ">
                        <label>type</label>
                        <!-- <CustomSelect
                            :key="form.typespointage"
                            :columnDefs="['libelle']"
                            :oldValue="form.typespointage"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>form.typespointage_id=data.id"
                            :url="`${axios.defaults.baseURL}/api/typespointages-Aggrid`"
                            filter-key=""
                            filter-value=""
                            required
                        />
                        <div v-if="errors.typespointage_id" class="invalid-feedback">
                            <template v-for=" error in errors.type"> {{ error[0] }}</template>
                        </div> -->
                        <v-select v-model="form.typespointages" :options="validationsData" label="Selectlabel"/>
                    </div>
                    <!-- <div class="form-group  ">
                        <div class="form-check">
                            <input id="flexRadioDefault1" class="form-check-input" name="flexRadioDefault" type="radio">
                            <label class="form-check-label" for="flexRadioDefault1"
                                   title="Texte pour le bouton partiel">
                                partiel
                            </label>
                        </div>
                        <div class="form-check">
                            <input id="flexRadioDefault2" checked class="form-check-input" name="flexRadioDefault"
                                   type="radio">
                            <label class="form-check-label" for="flexRadioDefault2"
                                   title="Texte pour le bouton complet">
                                Complet
                            </label>
                        </div>

                    </div> -->
                    <div class="row justify-content-center mt-3">
                        <button v-if="steps == 1" class="btn btn-primary justify-content-end" type="submit">
                            <i class="fas fa-floppy-disk"></i> Analyser
                        </button>
                        <button v-if="steps == 2" class="btn btn-primary justify-content-end" type="submit">
                            <i class="fas fa-floppy-disk"></i> Importer
                        </button>
                    </div>


                </div>


            </div>


        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'CreateImports',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'data',
        'type'
    ],
    computed: {
        $domaine: function () {
            let domaine = 'supervizr';
            try {
                domaine = window.domaine
            } catch (e) {
            }

            console.log('voila le domaine ==>', domaine)
            return domaine;
        },
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != "undefined") {
                    router = window.routeData;
                }
            } catch (e) {
            }
            return router;
        },
        taille: function () {
            let result = 'col-sm-12'
            if (this.filtre) {
                result = 'col-sm-9'
            }
            return result
        },
    },
    mounted() {
        this.form = this.data
        this.validationsData = ["Pointage-BioTime", "Pointage-Brute"]
        console.log('voici les parametres==>', this.form)
        this.form.allChamps.forEach(element => {
            this.liaisons.push({'p': element, key: 0})
        })

    },
    data() {
        return {
            errors: [],
            isLoading: false,
            validationsData: [],
            form: {


                id: "",

                type: "",

                file: "",

                liaisons: "",

                identifiant: "",

                etats: "",

                creat_by: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",
            },
            liaisons: [],
            colonnes: [],
            statistiques: {
                Create: 0,
                Update: 0,
                Remove: 0,
            },
            steps: 1,
            server_error: ""
        }
    },


    methods: {
        createLine() {
            console.log('voici les donnees collecter ==>', this.form, this.liaisons)
            this.form.liaisons = JSON.stringify(this.liaisons)
            this.form.steps = this.steps
            this.isLoading = true
            this.axios.post('/api/imports', this.form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                this.isLoading = false
                console.log('reponse dajout de fichiers', response.data)
                console.log('voici les donnees du serveur', Object.keys(response.data))
                if (Object.keys(response.data).includes('id')) {
                    this.$bvModal.hide(this.modalFormId)
                    this.$toast.success('Operation effectuer avec succes')
                    this.$emit('close')
                } else {
                    this.$toast.error('Erreur survenue lors de l\'enregistrement')
                    this.server_error = response.data.error
                }
            }).catch(error => {
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        valideImport() {
            this.steps = 4;
            this.createLine()
        },
        annuleImport() {
            this.$bvModal.hide(this.modalFormId)
        },
        resetForm() {
            this.form = {
                id: "",
                type: "",
                file: "",
                liaisons: "",
                identifiant: "",
                etats: "",
                creat_by: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
            }
        }
    }
}
</script>
