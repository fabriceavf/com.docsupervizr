<template>
    <b-overlay :show="isLoading">
        <div v-for="erreur in Object.keys(errors)">
            <div v-for="message in Object.values(errors[erreur])">
                <b-alert show style="padding: 5px" variant="danger">{{ erreur }} : {{ message[0] }}</b-alert>

            </div>
        </div>
        <div class="header-detail">
            <b-avatar v-if="form.photo" :src="$store.getters['general/apiUrl'] + '/' + form.photo" size="70px"/>

            <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                <i class="fas fa-close"></i> Supprimer l'users
            </button>
        </div>

        <form-wizard :subtitle="null" :title="null" back-button-text="Precedent" class="mb-3 formUsers"
                     color="rgb(40, 167, 69)" finish-button-text="Soumettre" next-button-text="Suivant" shape="circle"
                     stepSize="sm"
                     @on-complete="EditLine">

            <tab-content :before-change="validationForm" title="Information personnel">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>nom </label>
                        <input v-model="form.nom" :class="errors.nom ? 'form-control is-invalid' : 'form-control'"
                               type="text">

                        <div v-if="errors.nom" class="invalid-feedback">
                            <template v-for=" error in errors.nom"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="form-group col-sm-6">
                        <label>prenom </label>
                        <input v-model="form.prenom" :class="errors.prenom ? 'form-control is-invalid' : 'form-control'"
                               type="text">

                        <div v-if="errors.prenom" class="invalid-feedback">
                            <template v-for=" error in errors.prenom"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>email </label>
                        <input v-model="form.email" :class="errors.email ? 'form-control is-invalid' : 'form-control'"
                               type="text">

                        <div v-if="errors.email" class="invalid-feedback">
                            <template v-for=" error in errors.email"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="form-group col-sm-6 ">
                        <label>sexes </label>
                        <CustomSelect :key="form.sexe" :columnDefs="['libelle']" :oldValue="form.sexe"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.sexe_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/sexes-Aggrid`" filter-key=""
                                      filter-value=""/>
                        <div v-if="errors.sexe_id" class="invalid-feedback">
                            <template v-for=" error in errors.sexe_id"> {{ error[0] }}</template>

                        </div>
                    </div>


                </div>

                <div class="row">

                    <div class="form-group col-sm-6">
                        <label>code sur la pointeuse </label>
                        <input v-model="form.emp_code"
                               :class="errors.emp_code ? 'form-control is-invalid' : 'form-control'"
                               type="text">

                        <div v-if="errors.emp_code" class="invalid-feedback">
                            <template v-for=" error in errors.emp_code"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="form-group col-sm-6 ">
                        <label>Roles/Profils </label>
                        <CustomSelect :key="form.role" :columnDefs="['name']" :oldValue="form.role"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.role_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/roles-Aggrid`" filter-key=""
                                      filter-value=""/>
                        <div v-if="errors.role_id" class="invalid-feedback">
                            <template v-for=" error in errors.role_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Nouveau mot de passe </label></br>
                        <span>Attention en renseignant ce champs le mot de passe l'utilisateur sera modifier</span>
                        <input v-model="newPassword"
                               :class="errors.newPassword ? 'form-control is-invalid' : 'form-control'"
                               type="text">

                        <div v-if="errors.newPassword" class="invalid-feedback">
                            <template v-for=" error in errors.newPassword"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>
            </tab-content>

            <tab-content :before-change="validationForm" title="Permissions Par zone">
                <!-- <div>
                    En cours de devellopement
                    <b-overlay :show="true"></b-overlay>
                </div> -->
                <!-- {{form.id}} -->
                <Userszones :key="form.id" :UsersData="form.id"/>

            </tab-content>
            <!-- <tab-content v-if="$domaine == 'sgs'" :before-change="validationForm" title="GRAPHIQUES">
                <Usersgraphiques :parentId="form.id"/>

            </tab-content> -->
            <tab-content :before-change="validationForm" title="Types de postes">
                <Userstypespostes :UsersData="form.id"/>

            </tab-content>
            <tab-content :before-change="validationForm" title="Stat dashboard">
                <Statszones :parentId="form.id"/>

            </tab-content>
            <tab-content :before-change="validationForm" title="Activites Recente">
                <Activitesrecentes :key="form.id" :user-select="form.id"></Activitesrecentes>

            </tab-content>


        </form-wizard>


    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import PhotoSgs from "@/components/PhotoSgs.vue";
import {FormWizard, TabContent} from "vue-form-wizard";
import {ValidationObserver, ValidationProvider} from "vee-validate";
import PrintBadge from "@/components/PrintBadge.vue";
import Permissions from "./Permissions.vue";
import Activitesrecentes from "./Activitesrecentes.vue";
import Userszones from "../Userszones/UserszonesView.vue";
import Usersgraphiques from "../Usersgraphiques/UsersgraphiquesView.vue";
import Userstypespostes from "../Userstypespostes/UserstypespostesView.vue";
import Statszones from "../Statszones/StatszonesView.vue";

export default {
    name: 'EditAgents',
    components: {
        VSelect, CustomSelect,
        Files,
        PhotoSgs,
        FormWizard,
        TabContent,
        ValidationProvider,
        ValidationObserver,
        PrintBadge,
        Permissions,
        Activitesrecentes,
        Userszones,
        Usersgraphiques,
        Userstypespostes, Statszones
    },
    props: ['data', 'gridApi', 'modalFormId',
        'actifsData',
        'contratsData',
        'fonctionsData',
        'matrimonialesData',
        'nationalitesData',
        'onlinesData',
        'sexesData',
        'typesData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            newPassword: '',
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
                role_id: "",

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
            }
        }
    },
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
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
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
        this.form['date_naissance'] = this.form['date_naissance'].split(' ')[0]
        this.form['date_embauche'] = this.form['date_embauche'].split(' ')[0]
    },
    methods: {

        EditLine() {
            this.isLoading = true
            if (this.newPassword != '') {
                this.form.password = this.newPassword
            }
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
    }
}
</script>

<style>
.header-detail {
    display: flex;
    justify-content: space-between;
}
</style>
