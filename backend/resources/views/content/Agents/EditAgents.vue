<template>
    <b-overlay :show="isLoading">
        <div v-for="erreur in Object.keys(errors)">
            <div v-for="message in Object.values(errors[erreur])">
                <b-alert show style="padding: 5px" variant="danger">{{ erreur }} : {{ message[0] }}</b-alert>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <img v-if="form.photo" :src="$store.getters['general/apiUrl'] + '/' + form.photo" alt=""
                     style="width:100%;height: 400px;border-radius:8px; object-fit: cover;">

                <div class="form-group col-sm-12" style="margin:10px auto">

                    <PhotoSgs v-model="form.photo"></PhotoSgs>

                    <div v-if="errors.photo" class="invalid-feedback">
                        <template v-for=" error in errors.photo"> {{ error[0] }}</template>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="header-detail">
                    <!-- <template v-if="form.actif_id == 1"> -->
                    <template>
                        <button class="btn btn-warning" disabled type="button">
                            <i class="fas fa-check"></i>Agents valider
                        </button>
                    </template>
                    <!-- <template v-else>
                        <button class="btn btn-warning" type="button" @click.prevent="Valider()">
                            <i class="fas fa-check"></i> Valider
                        </button>
                    </template> -->

                    <button class="btn btn-danger float-right" type="button" @click.prevent="DeleteLine()">
                        <!-- <i class="fas fa-close"></i> Supprimer l'agent -->
                        <i class="fa-solid fa-box-archive"></i> Archiver
                    </button>
                </div>
                <form-wizard :subtitle="null" :title="null" back-button-text="Precedent" class="mb-3 formUsers"
                             color="rgb(40, 167, 69)" finish-button-text="Soumettre" next-button-text="Suivant"
                             shape="circle"
                             stepSize="sm" @on-change="handleTabChange" @on-complete="EditLine">

                    <tab-content :before-change="validationForm" title="Information personnel">
                        <div class="row">
                            <div :style="{ display: ishidden('nom') }" class="form-group col-sm-6" disabled>
                                <label>nom </label>
                                <input v-model="form.nom"
                                       :class="errors.nom ? 'form-control is-invalid' : 'form-control'"
                                       :disabled="isDisabled('form.nom')" type="text">

                                <div v-if="errors.nom" class="invalid-feedback">
                                    <template v-for=" error in errors.nom"> {{ error[0] }}</template>

                                </div>
                            </div>


                            <div :style="{ display: ishidden('prenom') }" class="form-group col-sm-6">
                                <label>prenom </label>
                                <input v-model="form.prenom"
                                       :class="errors.prenom ? 'form-control is-invalid' : 'form-control'"
                                       :disabled="isDisabled('form.prenom')" type="text">

                                <div v-if="errors.prenom" class="invalid-feedback">
                                    <template v-for=" error in errors.prenom"> {{ error[0] }}</template>

                                </div>
                            </div>

                            <div :style="{ display: ishidden('num_badge') }" class="form-group col-sm-6">
                                <label>badge </label>
                                <input v-model="form.num_badge"
                                       :class="errors.num_badge ? 'form-control is-invalid' : 'form-control'"
                                       :disabled="isDisabled('form.num_badge')"
                                       type="text">

                                <div v-if="errors.num_badge" class="invalid-feedback">
                                    <template v-for=" error in errors.num_badge"> {{ error[0] }}</template>

                                </div>
                            </div>
                            <div :style="{ display: ishidden('typeseffectif_id') }" class="form-group col-sm-6">
                                <label>typeseffectifs </label>
                                <CustomSelect :key="form.typeseffectif"
                                              :columnDefs="['libelle']"
                                              :disable="isDisabled('form.typeseffectif_id')"
                                              :oldValue="form.typeseffectif"
                                              :renderCallBack="(data) => `${data.Selectlabel}`"
                                              :selectCallBack="(data) => form.typeseffectif_id = data.id"
                                              :url="`${axios.defaults.baseURL}/api/typeseffectifs-Aggrid`"
                                              filter-key=""
                                              filter-value=""/>

                                <div v-if="errors.typeseffectif_id" class="invalid-feedback">
                                    <template v-for=" error in errors.typeseffectif_id"> {{ error[0] }}</template>

                                </div>
                            </div>
                            <div :style="{ display: ishidden('emp_code') }" class="form-group col-sm-6">
                                <label>identification teleric </label>
                                <input v-model="form.emp_code"
                                       :class="errors.emp_code ? 'form-control is-invalid' : 'form-control'"
                                       :disabled="isDisabled('form.emp_code')"
                                       type="text">

                                <div v-if="errors.emp_code" class="invalid-feedback">
                                    <template v-for=" error in errors.emp_code"> {{ error[0] }}</template>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div :style="{ display: ishidden('matricule') }" class="form-group col-sm-3 ">
                                <label>matricule </label>
                                <input v-model="form.matricule"
                                       :class="errors.matricule ? 'form-control is-invalid' : 'form-control'"
                                       :disabled="isDisabled('form.matricule')"
                                       type="text">

                                <div v-if="errors.matricule" class="invalid-feedback">
                                    <template v-for=" error in errors.matricule"> {{ error[0] }}</template>

                                </div>
                            </div>

                            <div :style="{ display: ishidden('date_naissance') }" class="form-group col-sm-3">
                                <label>date_naissance </label>
                                <input v-model="form.date_naissance"
                                       :class="errors.date_naissance ? 'form-control is-invalid' : 'form-control'"
                                       :disabled="isDisabled('form.date_naissance')"
                                       type="date">

                                <div v-if="errors.date_naissance" class="invalid-feedback">
                                    <template v-for=" error in errors.date_naissance"> {{ error[0] }}</template>

                                </div>
                            </div>
                            <div :style="{ display: ishidden('nationalite_id') }" class="form-group col-sm-3">
                                <label>nationalites </label>
                                <CustomSelect :key="form.nationalite"
                                              :columnDefs="['libelle']"
                                              :disable="isDisabled('form.nationalite_id')"
                                              :oldValue="form.nationalite"
                                              :renderCallBack="(data) => `${data.Selectlabel}`"
                                              :selectCallBack="(data) => form.nationalite_id = data.id"
                                              :url="`${axios.defaults.baseURL}/api/nationalites-Aggrid`"
                                              filter-key=""
                                              filter-value=""/>

                                <div v-if="errors.nationalite_id" class="invalid-feedback">
                                    <template v-for=" error in errors.nationalite_id"> {{ error[0] }}</template>

                                </div>
                            </div>

                            <div :style="{ display: ishidden('date_embauche') }" class="form-group col-sm-3">
                                <label>date_embauche </label>
                                <input v-model="form.date_embauche"
                                       :class="errors.date_embauche ? 'form-control is-invalid' : 'form-control'"
                                       :disabled="isDisabled('form.date_embauche')"
                                       type="date">

                                <div v-if="errors.date_embauche" class="invalid-feedback">
                                    <template v-for=" error in errors.date_embauche"> {{ error[0] }}</template>

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div :style="{ display: ishidden('direction_id') }" class="form-group col-sm-3">
                                <label>directions </label>
                                <CustomSelect :key="form.direction"
                                              :columnDefs="['libelle']"
                                              :disable="isDisabled('form.direction_id')" :oldValue="form.direction"
                                              :renderCallBack="(data) => `${data.Selectlabel}`"
                                              :selectCallBack="(data) => form.direction_id = data.id"
                                              :url="`${axios.defaults.baseURL}/api/directions-Aggrid`"
                                              filter-key=""
                                              filter-value=""/>
                                <div v-if="errors.direction_id" class="invalid-feedback">
                                    <template v-for=" error in errors.direction_id"> {{ error[0] }}</template>

                                </div>
                            </div>
                            <div :style="{ display: ishidden('fonction_id') }" class="form-group col-sm-3">
                                <label>fonctions </label>
                                <CustomSelect :key="form.fonction"
                                              :columnDefs="['libelle']"
                                              :disable="isDisabled('form.fonction_id')" :oldValue="form.fonction"
                                              :renderCallBack="(data) => `${data.Selectlabel}`"
                                              :selectCallBack="(data) => form.fonction_id = data.id"
                                              :url="`${axios.defaults.baseURL}/api/fonctions-Aggrid`"
                                              filter-key=""
                                              filter-value=""/>
                                <div v-if="errors.fonction_id" class="invalid-feedback">
                                    <template v-for=" error in errors.fonction_id"> {{ error[0] }}</template>

                                </div>
                            </div>


                            <div :style="{ display: ishidden('num_cnss') }" class="form-group col-sm-3">
                                <label>num_cnss </label>
                                <input v-model="form.num_cnss"
                                       :class="errors.num_cnss ? 'form-control is-invalid' : 'form-control'"
                                       :disabled="isDisabled('form.num_cnss')"
                                       type="text">

                                <div v-if="errors.num_cnss" class="invalid-feedback">
                                    <template v-for=" error in errors.num_cnss"> {{ error[0] }}</template>

                                </div>
                            </div>


                            <div :style="{ display: ishidden('num_cnamgs') }" class="form-group col-sm-3">
                                <label>num_cnamgs </label>
                                <input v-model="form.num_cnamgs"
                                       :class="errors.num_cnamgs ? 'form-control is-invalid' : 'form-control'"
                                       :disabled="isDisabled('form.num_cnamgs')"
                                       type="text">

                                <div v-if="errors.num_cnamgs" class="invalid-feedback">
                                    <template v-for=" error in errors.num_cnamgs"> {{ error[0] }}</template>

                                </div>
                            </div>
                            <div class="col-sm-12 blockPointages">
                                <template>
                                    <button v-if="historique === 0" class="btn btn-secondary"
                                            @click="readhistoriquebadge">
                                        <i class="fa-solid fa-clipboard-check"></i> Toute les cartes
                                    </button>
                                    <!-- <button v-if="historique === 0 && $domaine == 'sgs'" class="btn btn-secondary mx-1"
                                            @click="readhistoriqueposte"><i class="fa-solid fa-clipboard-check"></i>
                                        Historique
                                        poste
                                    </button> -->
                                    <button v-if="historique != 0" class="btn btn-danger" @click="fermerhistorique"><i
                                        class="fas fa-close"></i> Close
                                    </button>
                                </template>
                            </div>
                            <div v-if="historique === 2" class="col-sm-12">
                                <historiquebadge :key="form.id" :Type="historiquetypes"
                                                 :user-select="form.id"/>
                            </div>


                        </div>
                    </tab-content>
                    <!-- <tab-content :before-change="validationForm" title="Calendrier de presence"> -->
                    <tab-content :before-change="validationForm" title="Presences/Absences au listings">


                        <div>
                            <!--<<<<<<< HEAD-->
                            <!-- <button class="btn btn-secondary mt-1" v-if="!pointage" @click="readPointageCalendrier"><i
                                class="fa-solid fa-clipboard-check"></i> pointage de l'agent {{ form.nom }}
                            </button>
                            <button class="btn btn-danger" v-if="pointage" @click="fermerPointageCalendrier"><i
                                class="fas fa-close"></i> Close
                            </button> -->

                            <!-- <Pointageagents v-if="read" :usersData="data"/> -->
                            <TableauPointagesAgents :user-select="form.id"/>
                            <!--=======-->
                            <!--                            <button class="btn btn-secondary mt-1" v-if="!pointage" @click="readPointageCalendrier"> <i-->
                            <!--                                    class="fa-solid fa-clipboard-check"></i> pointage de l'agent {{ form.nom }}</button>-->
                            <!--                            <button class="btn btn-danger" v-if="pointage" @click="fermerPointageCalendrier"> <i-->
                            <!--                                    class="fas fa-close"></i> Close</button>-->
                            <!--                            <Pointageagents :usersData="data" v-if="pointage" />-->
                            <!--&gt;>>>>>> c2d5ef0e688f5c56a99dfbeae0f7aee45abadee0-->

                        </div>


                    </tab-content>
                    <tab-content :before-change="validationForm" title="Postes/Faction">


                        <div>

                            <!-- <listings :user-select="form.id"/> -->
                            <historiquebadge :key="form.id" :Type="historiquetype = 'posteUser'"
                                             :user-select="form.id"/>

                        </div>


                    </tab-content>
                    <tab-content v-if="$domaine == 'sgs'" :before-change="validationForm" title="Badge">

                        <!--          <div class="row">-->

                        <!--            <div class="form-group col-sm-12">-->
                        <!--              <label>photo </label>-->

                        <!--              <PhotoSgs v-model="form.photo"></PhotoSgs>-->
                        <!--              <div v-if="errors.photo" class="invalid-feedback">-->
                        <!--                <template v-for=" error in errors.photo"> {{ error[0] }}</template>-->
                        <!--              </div>-->
                        <!--            </div>-->
                        <!--          </div>-->

                        <div class="blockBadge">
                            <div style="text-align: center">

                                <h5>Apercu du badge {{ $domaine }}</h5>
                            </div>

                            <div class="row" style="display:flex;justify-content:center">
                                {{ $domaine }}
                                <!-- <CAPrintBadge v-if="$domaine == 'c.a'" :agent="form"/> -->
                                <SGSPrintBadge :agent="form"/>
                                <!-- <PrintBadge v-else :agent="form"/> -->
                            </div>

                        </div>
                        <!-- <div class="blockPointages">

                            <template>
                                <button v-if="historique === 0" class="btn btn-secondary" @click="readhistoriquebadge">
                                    <i class="fa-solid fa-clipboard-check"></i> Historique badge
                                </button> -->
                        <!-- <button v-if="historique === 0 && $domaine == 'sgs'" class="btn btn-secondary mx-1"
                                @click="readhistoriqueposte"><i class="fa-solid fa-clipboard-check"></i>
                            Historique
                            poste
                        </button> -->
                        <!-- <button v-if="historique != 0" class="btn btn-danger" @click="fermerhistorique"><i
                            class="fas fa-close"></i> Close
                        </button>
                    </template>
                </div> -->
                        <!-- <historiquebadge v-if="historique === 2" :key="form.id" :Type="historiquetypes"
                                         :user-select="form.id"/> -->


                    </tab-content>


                </form-wizard>
            </div>
        </div>

        <div class="d-flex justify-content-between">


        </div>

    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import PhotoSgs from "@/components/PhotoSgs.vue";
import {FormWizard, TabContent} from "vue-form-wizard";
import {ValidationObserver, ValidationProvider} from "vee-validate";
import Pointageagents from "./Pointageagents.vue";
import TableauPointagesAgents from "./TableauPointagesAgents.vue";
import historiquebadge from "./historiquebagdes.vue";
import listings from "./listings.vue";

import CAPrintBadge from "@/components/c.a.PrintBadge.vue";
import SGSPrintBadge from "@/components/sgs.PrintBadge.vue";
import PrintBadge from "@/components/PrintBadge.vue";


export default {
    name: 'EditAgents',
    components: {
        VSelect, CustomSelect,
        Files,
        PhotoSgs,
        FormWizard,
        TableauPointagesAgents,
        TabContent,
        ValidationProvider,
        ValidationObserver,
        PrintBadge,
        CAPrintBadge,
        SGSPrintBadge,
        Pointageagents,
        listings,
        historiquebadge

    },
    props: ['data', 'gridApi', 'modalFormId',

        'actifsData',
        'balisesData',
        'categoriesData',
        'contratsData',
        'directionsData',
        'echelonsData',
        'factionsData',
        'fonctionsData',
        'matrimonialesData',
        'nationalitesData',
        'onlinesData',
        'postesData',
        'sexesData',
        'sitesData',
        'situationsData',
        'typesData',
        'usersData',
        'villesData',
        'zonesData',
        'champsAfficher',
        'pointage',

    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            pointage: false,
            historique: 0,
            historiquetype: false,
            historiquetypes: false,
            read: false,
            form: {

                id: "",

                name: "",

                email: "",

                email_verified_at: "",

                password: "",

                matricule: "",

                emp_code: "",

                nom: "",

                prenom: "",

                num_badge: "",

                date_naissance: "",

                num_cnss: "",

                num_cnamgs: "",

                telephone1: "",

                telephone2: "",

                nationalite_id: "",

                nombre_enfant: "",

                photo: "",

                actif_id: "",

                online_id: "",

                date_embauche: "",

                sexe_id: "",

                type_id: "",

                contrat_id: "",

                matrimoniale_id: "",

                fonction_id: "",

                user_id: "",

                remember_token: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            },
            champsDesactiver: []
        }
    },
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },
        $domaine: function () {
            let domaine = 'supervizr';
            try {
                domaine = window.domaine
            } catch (e) {
            }

            console.log('voila le domaine ==>', domaine)
            return domaine;
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
        this.form['date_naissance'] = this.form['date_naissance'].split(' ')[0]
        this.form['date_embauche'] = this.form['date_embauche'].split(' ')[0]

        if (this.$routeData.meta.isOne) {
            this.champsDesactiver = []
        } else {
            this.champsDesactiver = [
                'form.nom',
                'form.num_cnamgs',
                'form.num_cnss',
                'form.fonction_id',
                'form.direction_id',
                'form.date_embauche',
                'form.nationalite_id',
                'form.date_naissance',
                'form.matricule',
                'form.prenom',
                'form.nom',
            ]
        }
    },
    methods: {
        handleTabChange() {
            this.read = true;
        },
        isDisabled(fieldName) {
            return this.champsDesactiver.includes(fieldName)
        },
        getOptionsData(data) {
            let id = data.id
            let label = data.Selectlabel
            let site = ''
            let client = ''
            try {
                site = data.site.Selectlabel
            } catch (e) {
            }
            try {
                client = data.site.client.Selectlabel
            } catch (e) {
            }


            return '#' + id + ' ' + label + ' / ' + site + ' / ' + client


        },

        Valider() {
            this.form.actif_id = 1
            this.isLoading = true
            this.axios.post('/api/users/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        EditLine() {
            this.isLoading = true
            this.axios.post('/api/users/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
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
            this.axios.post('/api/users/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        ishidden(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            // if (!this.champsAfficher.includes(fieldName)) {
            if (this.champsAfficher.includes(fieldName)) {
                return "none"
            }
        },
        readPointageCalendrier() {
            this.pointage = true
        },
        fermerPointageCalendrier() {

            this.pointage = false

        },
        readhistoriquebadge() {
            this.historique = 2
            this.historiquetypes = 'BadgeUser'

        },
        fermerhistoriquebadge() {

            this.historiquebadge = false

        },
        // readhistoriqueposte() {
        //     this.historique = 1
        //     this.historiquetypes = 'posteUser'
        // },
        fermerhistorique() {

            this.historique = 0

        },
    }
}
</script>

<style scoped>
.blockBadge {
    padding: 10px;
    border: dashed;
    border-radius: 5px;
}

.blockPointages {
    text-align: center;
    margin: 10px;
    border: 2px dashed #b1acac;
    border-radius: 5px;
    padding: 10px;
}
</style>
