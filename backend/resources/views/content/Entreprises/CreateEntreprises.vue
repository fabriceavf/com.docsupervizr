<template>
    <b-overlay :show="isLoading">
        <div v-for="erreur in Object.keys(errors)">
            <div v-for="message in Object.values(errors[erreur])">
                <b-alert show style="padding: 5px" variant="danger">{{ erreur }} : {{ message[0] }}</b-alert>

            </div>
        </div>
        <form-wizard :subtitle="null" :title="null" back-button-text="Precedent" class="mb-3 formUsers"
                     color="rgb(40, 167, 69)" finish-button-text="Soumettre" next-button-text="Suivant" shape="circle"
                     stepSize="sm" @on-complete="createLine">

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


                    <h3>Image</h3>
                    <div class="row">


                        <div class="col-sm form-group">
                            <label>icon </label>
                            <!-- <b-form-file v-model="form.icon" :state="Boolean(form.icon)"
                            drop-placeholder="Drop file here..." placeholder="Selectionner le fichier"></b-form-file> -->
                            <img v-if="form.icon" :src="$store.getters['general/apiUrl'] + '/' + form.icon" alt=""
                                 style="width:100%;height: 100px;border-radius:8px; object-fit: cover;">

                            <div class="form-group col-sm-12" style="margin:10px auto">

                                <PhotoSgs v-model="form.icon"></PhotoSgs>

                                <div v-if="errors.icon" class="invalid-feedback">
                                    <template v-for=" error in errors.icon"> {{ error[0] }}</template>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm form-group">
                            <label>favicon </label>
                            <!-- <b-form-file v-model="form.favicon" :state="Boolean(form.favicon)"
                                     drop-placeholder="Drop file here..." placeholder="Selectionner le fichier"
                        ></b-form-file> -->
                            <img v-if="form.favicon" :src="$store.getters['general/apiUrl'] + '/' + form.favicon" alt=""
                                 style="width:100%;height: 100px;border-radius:8px; object-fit: cover;">

                            <div class="form-group col-sm-12" style="margin:10px auto">

                                <PhotoSgs v-model="form.favicon"></PhotoSgs>

                                <div v-if="errors.favicon" class="invalid-feedback">
                                    <template v-for=" error in errors.favicon"> {{ error[0] }}</template>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm form-group">
                            <label>badge avant </label>
                            <img v-if="form.badge_avant"
                                 :src="$store.getters['general/apiUrl'] + '/' + form.badge_avant" alt=""
                                 style="width:100%;height: 100px;border-radius:8px; object-fit: cover;">

                            <div class="form-group col-sm-12" style="margin:10px auto">

                                <PhotoSgs v-model="form.badge_avant"></PhotoSgs>

                                <div v-if="errors.badge_avant" class="invalid-feedback">
                                    <template v-for=" error in errors.badge_avant"> {{ error[0] }}</template>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm form-group">
                            <label>badge arriere </label>
                            <img v-if="form.badge_arriere"
                                 :src="$store.getters['general/apiUrl'] + '/' + form.badge_arriere" alt=""
                                 style="width:100%;height: 100px;border-radius:8px; object-fit: cover;">

                            <div class="form-group col-sm-12" style="margin:10px auto">

                                <PhotoSgs v-model="form.badge_arriere"></PhotoSgs>

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


                    <label>Modules à afficher</label>
                    <div class="row form-group cadre ">
                        <!-- <div v-for="(label, value) in champsAfficher" :key="value" class="form-group col-sm mt-1">
                            <input :checked="isChecked(value)" :value="value" class="fakeCheckBox mx-1" type="checkbox"
                                @change="selectChampsAfficher(value)">
                            <label>{{ label }}</label>
                        </div> -->
                        <div v-for="(label, value) in champsAfficher" :key="value" class="form-group col-sm mt-1">
                            <!-- Utilisation de la classe 'selected' si le module est sélectionné -->
                            <button :class="{ 'selected': isChecked(value) }" class="fakeCheckBox mx-1"
                                    @click="selectChampsAfficher(value)">
                                {{ label }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- <button class="btn btn-primary" type="submit">
                <i class="fas fa-floppy-disk"></i> Créer
            </button>
        </form> -->
            </tab-content>
        </form-wizard>
    </b-overlay>
</template>

<script>

import {FormWizard, TabContent} from 'vue-form-wizard'
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import PhotoSgs from "@/components/PhotoSgs.vue";
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

export default {
    name: 'CreateEntreprises',
    components: {
        FormWizard,
        TabContent, VSelect, PhotoSgs, CustomSelect, Files
    },
    props: [
        'gridApi',
        'modalFormId',
    ],
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

        }
    },
    mounted() {
        this.champsAfficher = {
            effectifs: "Effectifs",
            postes: "Postes",
            listings: "Mise en place ",
            rapports: "Rapports",
            transport: "Transport",
            equipement: "Equipement",
            Configurations: "Configurations",
            administraion: "Administraion",
        }
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
        createLine() {
            this.isLoading = true
            console.log('this.form', this.form);
            this.form.modules = this.champhide.join(',')
            this.axios.post('/api/entreprises', this.form).then(response => {
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
                nom: "",
                menu: "",
                host: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
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
