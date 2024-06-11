<template>
    <b-overlay :show="isLoading">
        <div v-for="erreur in Object.keys(errors)">
            <div v-for="message in Object.values(errors[erreur])">
                <b-alert show style="padding: 5px" variant="danger">{{ erreur }} : {{ message[0] }}</b-alert>

            </div>
        </div>
        <div>

            <div class="header-detail">

                <b-avatar v-if="form.photo"
                          :src="$store.getters['general/apiUrl']+'/'+form.photo"
                          size="70px"
                />
            </div>
            <form-wizard
                :subtitle="null"
                :title="null"
                back-button-text="Precedent"
                class="mb-3 formUsers"
                color="rgb(40, 167, 69)"
                finish-button-text="Soumettre"
                next-button-text="Suivant"
                shape="circle"
                stepSize="sm"
                @on-complete="createLine"
            >

                <tab-content
                    :before-change="validationForm"
                    title="Information personnel"
                >
                    <div class="row">

                        <div :style="{ display: ishidden('typeseffectif_id') }" class="form-group col-sm-4">
                            <label>typeseffectif </label>
                            <CustomSelect
                                :key="form.typeseffectif"
                                :columnDefs="['libelle']"
                                :oldValue="form.direction"
                                :renderCallBack="(data)=>`${data.Selectlabel}`"
                                :selectCallBack="(data)=>form.typeseffectif_id=data.id"
                                :url="`${axios.defaults.baseURL}/api/typeseffectifs-Aggrid`"
                                filter-key=""
                                filter-value=""
                            />
                            <div v-if="errors.typeseffectif_id" class="invalid-feedback">
                                <template v-for=" error in errors.typeseffectif_id"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div :style="{display: ishidden('nom')}" class="form-group col-sm-4">
                            <label>nom </label>
                            <input v-model="form.nom" :class="errors.nom?'form-control is-invalid':'form-control'"
                                   type="text">

                            <div v-if="errors.nom" class="invalid-feedback">
                                <template v-for=" error in errors.nom"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div :style="{display: ishidden('prenom')}" class="form-group col-sm-4">
                            <label>prenom </label>
                            <input v-model="form.prenom" :class="errors.prenom?'form-control is-invalid':'form-control'"
                                   type="text">

                            <div v-if="errors.prenom" class="invalid-feedback">
                                <template v-for=" error in errors.prenom"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div :style="{display: ishidden('nationalite_id')}" class="form-group col-sm-4">
                            <label>nationalites </label>
                            <CustomSelect
                                :key="form.nationalite"
                                :columnDefs="['libelle']"
                                :oldValue="form.nationalite"
                                :renderCallBack="(data)=>`${data.Selectlabel}`"
                                :selectCallBack="(data)=>form.nationalite_id=data.id"
                                :url="`${axios.defaults.baseURL}/api/nationalites-Aggrid`"
                                filter-key=""
                                filter-value=""
                            />
                            <div v-if="errors.nationalite_id" class="invalid-feedback">
                                <template v-for=" error in errors.nationalite_id"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div :style="{display: ishidden('date_naissance')}" class="form-group col-sm-4">
                            <label>date_naissance </label>
                            <input v-model="form.date_naissance"
                                   :class="errors.date_naissance?'form-control is-invalid':'form-control'"
                                   type="date">

                            <div v-if="errors.date_naissance" class="invalid-feedback">
                                <template v-for=" error in errors.date_naissance"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div :style="{display: ishidden('date_naissance')}" class="form-group col-sm-4">
                            <label>date_naissance </label>
                            <input v-model="form.date_naissance"
                                   :class="errors.date_naissance?'form-control is-invalid':'form-control'"
                                   type="date">

                            <div v-if="errors.date_naissance" class="invalid-feedback">
                                <template v-for=" error in errors.date_naissance"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div :style="{display: ishidden('num_badge')}" class="form-group col-sm-4">
                            <label>numero badge</label>
                            <input v-model="form.num_badge"
                                   :class="errors.num_badge?'form-control is-invalid':'form-control'"
                                   type="text">

                            <div v-if="errors.num_badge" class="invalid-feedback">
                                <template v-for=" error in errors.num_badge"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div :style="{display: ishidden('matricule')}" class="form-group col-sm-4">
                            <label>matricule </label>
                            <input v-model="form.matricule"
                                   :class="errors.matricule?'form-control is-invalid':'form-control'"
                                   type="text">

                            <div v-if="errors.matricule" class="invalid-feedback">
                                <template v-for=" error in errors.matricule"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div :style="{display: ishidden('date_embauche')}" class="form-group col-sm-2">
                            <label>date_embauche </label>
                            <input v-model="form.date_embauche"
                                   :class="errors.date_embauche?'form-control is-invalid':'form-control'"
                                   type="date">

                            <div v-if="errors.date_embauche" class="invalid-feedback">
                                <template v-for=" error in errors.date_embauche"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div :style="{ display: ishidden('fonction_id') }" class="form-group col-sm-3">
                            <label>fonctions </label>
                            <CustomSelect
                                :key="form.fonction"
                                :columnDefs="['libelle']"
                                :oldValue="form.fonction"
                                :renderCallBack="(data)=>`${data.Selectlabel}`"
                                :selectCallBack="(data)=>form.fonction_id=data.id"
                                :url="`${axios.defaults.baseURL}/api/fonctions-Aggrid`"
                                filter-key=""
                                filter-value=""
                            />
                            <div v-if="errors.fonction_id" class="invalid-feedback">
                                <template v-for=" error in errors.fonction_id"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div :style="{ display: ishidden('direction_id') }" class="form-group col-sm-3">
                            <label>directions </label>
                            <CustomSelect
                                :key="form.direction"
                                :columnDefs="['libelle']"
                                :oldValue="form.direction"
                                :renderCallBack="(data)=>`${data.Selectlabel}`"
                                :selectCallBack="(data)=>form.direction_id=data.id"
                                :url="`${axios.defaults.baseURL}/api/directions-Aggrid`"
                                filter-key=""
                                filter-value=""
                            />
                            <div v-if="errors.direction_id" class="invalid-feedback">
                                <template v-for=" error in errors.direction_id"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div :style="{display: ishidden('num_cnss')}" class="form-group col-sm-2">
                            <label>CNSS </label>
                            <input v-model="form.num_cnss"
                                   :class="errors.num_cnss?'form-control is-invalid':'form-control'"
                                   type="text">

                            <div v-if="errors.num_cnss" class="invalid-feedback">
                                <template v-for=" error in errors.num_cnss"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <div :style="{display: ishidden('num_cnamgs')}" class="form-group col-sm-2">
                            <label>CNAMGS </label>
                            <input v-model="form.num_cnamgs"
                                   :class="errors.num_cnamgs?'form-control is-invalid':'form-control'"
                                   type="text">

                            <div v-if="errors.num_cnamgs" class="invalid-feedback">
                                <template v-for=" error in errors.num_cnamgs"> {{ error[0] }}</template>

                            </div>
                        </div>

                    </div>
                </tab-content>

                <!-- <tab-content
                    :before-change="validationForm"
                    title="Badge"
                >

                    <div class="row">

                        <div :style="{display: ishidden('photo')}" class="form-group col-sm-12">
                            <label>photo </label>

                            <PhotoSgs v-model="form.photo"></PhotoSgs>
                            <div v-if="errors.photo" class="invalid-feedback">
                                <template v-for=" error in errors.photo"> {{ error[0] }}</template>
                            </div>
                        </div>
                    </div>

                    <div class="blockBadge">
                        <div style="text-align: center">

                            <h5>Apercu du badge {{ $domaine }}</h5>
                        </div>

                        <div class="row" style="display:flex;justify-content:center">
                            {{ $domaine }}
                            <CAPrintBadge v-if="$domaine=='c.a'" :agent="form"/>
                            <SGSPrintBadge v-else-if="$domaine=='sgs'" :agent="form"/>
                            <PrintBadge v-else :agent="form"/>
                        </div>

                    </div>
                </tab-content> -->


            </form-wizard>
        </div>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import {FormWizard, TabContent} from 'vue-form-wizard'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import PhotoSgs from "@/components/PhotoSgs.vue";
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import CAPrintBadge from "@/components/c.a.PrintBadge.vue";
import SGSPrintBadge from "@/components/sgs.PrintBadge.vue";
import PrintBadge from "@/components/PrintBadge.vue";

export default {
    name: 'CreateAgents',
    components: {
        VSelect, CustomSelect,
        Files,
        PhotoSgs,
        FormWizard,
        TabContent,
        ValidationProvider,
        ValidationObserver,
        PrintBadge,
        CAPrintBadge,
        SGSPrintBadge
    },
    props: [
        'gridApi',
        'modalFormId',
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

    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                name: "",

                nom: "",

                prenom: "",

                matricule: "",

                num_badge: "",

                date_naissance: "",

                num_cnss: "",

                num_cnamgs: "",

                telephone1: "",

                telephone2: "",

                photo: "",

                date_embauche: "",

                download_date: "",

                actif_id: 2,

                nationalite_id: "",

                contrat_id: "",

                direction_id: "",

                categorie_id: "",

                echelon_id: "",

                sexe_id: "",

                matrimoniale_id: "",

                poste_id: "",

                ville_id: "",

                zone_id: "",

                site_id: "",

                situation_id: "",

                balise_id: "",

                fonction_id: "",

                user_id: "",

                email: "",

                email_verified_at: "",

                password: "",

                emp_code: "",

                nombre_enfant: "",

                num_dossier: "",

                online_id: "",

                type_id: 2,

                faction_id: "",

                remember_token: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            }
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
    methods: {
        createLine() {
            this.isLoading = true
            if (this.$routeData.meta.isOne) {
                this.form.type_id = 3
            }
            this.axios.post('/api/users', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
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
        resetForm() {
            this.form = {
                id: "",
                name: "",
                nom: "",
                prenom: "",
                matricule: "",
                num_badge: "",
                date_naissance: "",
                num_cnss: "",
                num_cnamgs: "",
                telephone1: "",
                telephone2: "",
                photo: "",
                date_embauche: "",
                download_date: "",
                actif_id: "",
                nationalite_id: "",
                contrat_id: "",
                direction_id: "",
                categorie_id: "",
                echelon_id: "",
                sexe_id: "",
                matrimoniale_id: "",
                poste_id: "",
                ville_id: "",
                zone_id: "",
                site_id: "",
                situation_id: "",
                balise_id: "",
                fonction_id: "",
                user_id: "",
                email: "",
                email_verified_at: "",
                password: "",
                emp_code: "",
                nombre_enfant: "",
                num_dossier: "",
                online_id: "",
                type_id: "",
                faction_id: "",
                remember_token: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        },
        validationForm() {
            return new Promise((resolve, reject) => {
                resolve(true)
                // this.$refs.accountRules.validate().then(success => {
                //   if (success) {
                //     resolve(true)
                //   } else {
                //     reject()
                //   }
                // })
            })
        },
        validationFormInfo() {
            return new Promise((resolve, reject) => {
                this.$refs.infoRules.validate().then(success => {
                    if (success) {
                        resolve(true)
                    } else {
                        reject()
                    }
                })
            })
        },
        validationFormAddress() {
            return new Promise((resolve, reject) => {
                this.$refs.addressRules.validate().then(success => {
                    if (success) {
                        resolve(true)
                    } else {
                        reject()
                    }
                })
            })
        },
        validationFormSocial() {
            return new Promise((resolve, reject) => {
                this.$refs.socialRules.validate().then(success => {
                    if (success) {
                        resolve(true)
                    } else {
                        reject()
                    }
                })
            })
        },
        ishidden(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            // if (this.champsAfficher.includes(fieldName)) {
            //     return "none"
            // }
            return true;
        },
    },

}
</script>
<style>
.blockBadge {
    padding: 10px;
    border: dashed;
    border-radius: 5px;
}
</style>
