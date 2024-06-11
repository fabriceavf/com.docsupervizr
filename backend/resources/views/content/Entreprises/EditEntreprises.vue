<template>
    <b-overlay :show="isLoading">
        <div v-for="erreur in Object.keys(errors)">
            <div v-for="message in Object.values(errors[erreur])">
                <b-alert show style="padding: 5px" variant="danger">{{ erreur }} : {{ message[0] }}</b-alert>

            </div>
        </div>
        <div class="header-detail">
            <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                <i class="fas fa-close"></i> Supprimer
            </button>
        </div>
        <form-wizard :subtitle="null" :title="null" back-button-text="Precedent" class="mb-3 formUsers"
                     color="rgb(40, 167, 69)" finish-button-text="Soumettre" next-button-text="Suivant" shape="circle"
                     stepSize="sm" @on-complete="EditLine">

            <tab-content :before-change="validationForm" title="Information client">
                <div class="mb-3">

                    <h3>Presentation</h3>
                    <div class="row">
                        <div class="col-sm form-group">
                            <label>nom </label>
                            <input v-model="form.nom" :class="errors.nom ? 'form-control is-invalid' : 'form-control'"
                                   type="text">

                            <div v-if="errors.nom" class="invalid-feedback">
                                <template v-for=" error in errors.nom"> {{ error[0] }}</template>

                            </div>
                        </div>


                        <div class="col-sm form-group">
                            <label>host </label>
                            <input v-model="form.host" :class="errors.host ? 'form-control is-invalid' : 'form-control'"
                                   type="text">

                            <div v-if="errors.host" class="invalid-feedback">
                                <template v-for=" error in errors.host"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>


                    <div class="row">


                        <div class="col-sm-6 form-group">
                            <label>icon </label>
                            <img v-if="form.icon" :src="$store.getters['general/apiUrl'] + '/' + form.icon" alt=""
                                 style="width:100%;height: 100px;border-radius:8px; object-fit: cover;">

                            <div class="form-group col-sm-12" style="margin:10px auto">
                                <b-form-file v-model="form.icon" :state="Boolean(form.icon)"
                                             drop-placeholder="Drop file here..."
                                             placeholder="Selectionner le fichier"></b-form-file>

                                <!-- <PhotoSgs v-model="form.icon"></PhotoSgs> -->

                                <div v-if="errors.icon" class="invalid-feedback">
                                    <template v-for=" error in errors.icon"> {{ error[0] }}</template>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label>favicon </label>

                            <img v-if="form.favicon" :src="$store.getters['general/apiUrl'] + '/' + form.favicon" alt=""
                                 style="width:100%;height: 100px;border-radius:8px; object-fit: cover;">

                            <div class="form-group col-sm-12" style="margin:10px auto">
                                <b-form-file v-model="form.favicon" :state="Boolean(form.favicon)"
                                             drop-placeholder="Drop file here..."
                                             placeholder="Selectionner le fichier"></b-form-file>
                                <!-- <PhotoSgs v-model="form.favicon"></PhotoSgs> -->

                                <div v-if="errors.favicon" class="invalid-feedback">
                                    <template v-for=" error in errors.favicon"> {{ error[0] }}</template>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6 form-group">
                            <label>badge avant </label>
                            <img v-if="form.badge_avant"
                                 :src="$store.getters['general/apiUrl'] + '/' + form.badge_avant" alt=""
                                 style="width:100%;height: 100px;border-radius:8px; object-fit: cover;">

                            <div class="form-group col-sm-12" style="margin:10px auto">
                                <b-form-file v-model="form.badge_avant" :state="Boolean(form.badge_avant)"
                                             drop-placeholder="Drop file here..."
                                             placeholder="Selectionner le fichier"></b-form-file>
                                <!-- <PhotoSgs v-model="form.badge_avant"></PhotoSgs> -->

                                <div v-if="errors.badge_avant" class="invalid-feedback">
                                    <template v-for=" error in errors.badge_avant"> {{ error[0] }}</template>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label>badge arriere </label>
                            <img v-if="form.badge_arriere"
                                 :src="$store.getters['general/apiUrl'] + '/' + form.badge_arriere" alt=""
                                 style="width:100%;height: 100px;border-radius:8px; object-fit: cover;">

                            <div class="form-group col-sm-12" style="margin:10px auto">
                                <b-form-file v-model="form.badge_arriere" :state="Boolean(form.badge_arriere)"
                                             drop-placeholder="Drop file here..."
                                             placeholder="Selectionner le fichier"></b-form-file>
                                <!-- <PhotoSgs v-model="form.badge_arriere"></PhotoSgs> -->

                                <div v-if="errors.badge_arriere" class="invalid-feedback">
                                    <template v-for=" error in errors.badge_arriere"> {{ error[0] }}</template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3>Base de donnee</h3>
                    <div class="row">

                        <div class="col-sm form-group">
                            <label>db_host </label>
                            <input v-model="form.db_host"
                                   :class="errors.db_host ? 'form-control is-invalid' : 'form-control'"
                                   type="text">

                            <div v-if="errors.db_host" class="invalid-feedback">
                                <template v-for=" error in errors.db_host"> {{ error[0] }}</template>

                            </div>
                        </div>


                        <div class="col-sm form-group">
                            <label>db_user </label>
                            <input v-model="form.db_user"
                                   :class="errors.db_user ? 'form-control is-invalid' : 'form-control'"
                                   type="text">

                            <div v-if="errors.db_user" class="invalid-feedback">
                                <template v-for=" error in errors.db_user"> {{ error[0] }}</template>

                            </div>
                        </div>


                        <div class="col-sm form-group">
                            <label>db_pass </label>
                            <input v-model="form.db_pass"
                                   :class="errors.db_pass ? 'form-control is-invalid' : 'form-control'"
                                   type="text">

                            <div v-if="errors.db_pass" class="invalid-feedback">
                                <template v-for=" error in errors.db_pass"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>


                    <h3>Module du client</h3>

                    <div class="row">
                        <div class="col-sm form-group">
                            <div style="display: flex;flex-direction: row;flex-wrap: wrap;gap: 10px;">
                                <template v-for="(label, value)  in champsAfficher">

                                    <button v-if="isChecked(value)" :key='`Select-${key}-${key1}`' v-b-tooltip.hover
                                            class=" btn btn-outline-primary"
                                            @click.prevent="selectChampsAfficher(value)">

                                        <span><i class="far fa-check-square"></i> {{ label }}</span>


                                    </button>
                                    <button v-else :key='`UnSelect-${key}-${key1}`' v-b-tooltip.hover class="btn"
                                            @click.prevent="selectChampsAfficher(value)">
                                        <span>
                                            <i class="far fa-square"></i> {{ label }}
                                        </span>


                                    </button>

                                </template>

                            </div>
                        </div>

                    </div>

                    <div class="form-group ">
                        <p>fichier module</p>
                        <b-form-file v-model="form.filemodules" :state="Boolean(form.filemodules)"
                                     drop-placeholder="Drop file here..." placeholder="Selectionner le fichier"
                        ></b-form-file>

                        <div v-if="errors.filemodules" class="invalid-feedback">
                            <template v-for=" error in errors.filemodules"> {{ error[0] }}</template>

                        </div>
                    </div>

                    <div class="col-12">
                        <HeadselementsView :parentId="form.id"/>
                    </div>
                </div>

            </tab-content>
        </form-wizard>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import MenusView from "./Menus/MenusView.vue";
import PhotoSgs from "@/components/PhotoSgs.vue";
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import HeadselementsView from "./Headselements/HeadselementsView.vue";

export default {
    name: 'EditEntreprises',
    components: {
        TabContent, FormWizard, VSelect, PhotoSgs, CustomSelect, Files, MenusView, HeadselementsView
    },
    props: ['data', 'gridApi', 'modalFormId',],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                nom: "",

                icon: "",

                host: "",

                favicon: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            },
            champhide: [],
            champsAfficher: {},
            htmlFromDb: "<h3>Module du client</h3>"
        }
    },

    mounted() {
        this.champsAfficher = {
            Dashbord: "Dashbord",
            Effectif: "Effectif",
            Poste: "Poste",
            Listing: "Mise en place ",
            Rapport: "Rapport",
            Transport: "Transport",
            Equipement: "Equipement",
            Configuration: "Configuration",
            Administration: "Administration",
        }
        this.form = this.data
        if (this.form.modules) {
            this.champhide = this.form.modules.split(",");
        }
        console.log('this.data2', this.form)
        console.log('this.data', this.data)
    },
    methods: {
        isChecked(value) {
            return this.champhide.includes(value);
        },
        selectChampsAfficher(value) {
            // console.log('value', this.champhide);

            if (this.champhide.includes(value)) {
                this.champhide = this.champhide.filter(item => item !== value);
                console.log('value', this.champhide);

            } else {
                this.champhide.push(value);
                console.log('value', this.champhide);


            }
        },
        EditLine() {
            this.isLoading = true
            this.form.modules = this.champhide.join(',')
            this.axios.post('/api/entreprises/' + this.form.id + '/update', this.form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
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
            this.axios.post('/api/entreprises/' + this.form.id + '/delete').then(response => {
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

<style scoped>
.fakeCheckBox {
    border-radius: 5px;
    border: 2px solid #73ee15;
    background-color: #fff;
    /* Couleur de fond des boutons non sélectionnés */
    cursor: pointer;
    padding: 8px 16px;
    /* Ajustez le rembourrage selon votre préférence */
    margin: 4px;
    /* Ajustez la marge selon votre préférence */
    transition: background-color 0.3s, color 0.3s;
    /* Transition pour un changement de couleur en douceur */
}

/* Style pour les boutons sélectionnés */
.selected {
    background-color: #73ee15;
    /* Couleur de fond des boutons sélectionnés */
    color: #fff;
    /* Couleur du texte pour les boutons sélectionnés */
}

.cadre {
    border-radius: 3px;
    border: 2px solid #867f7f;
    background-color: #867f7f;
    padding: 8px;
    /* Ajoutez un peu de rembourrage autour du cadre */
    margin-top: 16px;
    /* Ajoutez une marge en haut du cadre */
}
</style>
