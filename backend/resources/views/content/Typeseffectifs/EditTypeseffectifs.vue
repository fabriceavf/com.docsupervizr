<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>code </label>
                    <input v-model="form.code" :class="errors.code ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.code" class="invalid-feedback">
                        <template v-for=" error in errors.code"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>


                <!-- <div class="form-group">
                    <label>creat_by </label>
                    <input v-model="form.creat_by" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.creat_by" class="invalid-feedback">
                        <template v-for=" error in errors.creat_by"> {{ error[0] }}</template>

                    </div>
                </div> -->


                <label>droit </label>
                <div class="row form-group cadre ">

                    <div class="form-group col-sm mt-1">
                        <input :checked="form.canCreate == 1" :value="form.canCreate" class="fakeCheckBox mx-1"
                               type="checkbox" @change="updateCheckboxValue('canCreate')">
                        <label>Ajouter </label>

                        <div v-if="errors.canCreate" class="invalid-feedback">
                            <template v-for=" error in errors.canCreate"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="form-group col-sm mt-1">
                        <input :checked="form.canUpdate == 1" :value="form.canUpdate" class="fakeCheckBox mx-1"
                               type="checkbox" @change="updateCheckboxValue('canUpdate')">
                        <label>Modifier </label>

                        <div v-if="errors.canUpdate" class="invalid-feedback">
                            <template v-for=" error in errors.canUpdate"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="form-group col-sm mt-1">
                        <input :checked="form.canDelete == 1" :value="form.canDelete" class="fakeCheckBox mx-1"
                               type="checkbox" @change="updateCheckboxValue('canDelete')">
                        <label>Supprimer </label>

                        <div v-if="errors.canDelete" class="invalid-feedback">
                            <template v-for=" error in errors.canDelete"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>
                <label>Champ à afficher</label>
                <div class="row form-group cadre ">
                    <div v-for="(label, value) in champsAfficher" :key="value" class="form-group col-sm mt-1">
                        <input :checked="isChecked(value)" :value="value" class="fakeCheckBox mx-1" type="checkbox"
                               @change="selectChampsAfficher(value)">
                        <label>{{ label }}</label>
                    </div>
                </div>

                <SwitchsusersView :parentId="form.id"/>

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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"
import SwitchsusersView from "../Switchsusers/SwitchsusersView.vue"

export default {
    name: 'EditTypeseffectifs',
    components: {CustomSelect, Files, SwitchsusersView},
    props: ['data', 'gridApi', 'modalFormId',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                libelle: "",

                creat_by: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                canCreate: "",

                canUpdate: "",

                canDelete: "",

            },
            champhide: [],
            champsAfficher: {},
        }
    },

    mounted() {
        this.form = this.data
        this.champsAfficher = {
            num_cnamgs: "CNAMGS",
            date_naissance: "Date de naissance",
            num_cnss: "CNSS",
            contrat_id: "contrat",
            faction_id: "faction",
            direction_id: "direction",
            // poste_id: "poste",
            ville_id: "ville",
            nationalite_id: "nationalité",
            service: "Service",
            telephone1: "Téléphone ",
            nom: "Nom",
            prenom: "Prénom",
            matricule: "Matricule",
            num_badge: "badge",
            date_embauche: "Date d'embauche",
            sexe_id: "Sexe",
            fonction_id: "Fonction",
            typeseffectif_id: "Type",
        }
        if (this.form.champHide) {
            this.champhide = this.form.champHide.split(",");
        }
        console.log('this.champsAfficher', this.champsAfficher, this.champhide);
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
        updateCheckboxValue(fieldName) {
            // this.form[fieldName] = this.form[fieldName] ? 1 : 2;
            if (this.form[fieldName] === 1) {
                this.form[fieldName] = 2;
            } else {
                this.form[fieldName] = 1;
            }
            console.log('this.form[fieldName]', this.form[fieldName], fieldName);

        },
        EditLine() {
            this.isLoading = true
            this.form.champHide = this.champhide.join(',')
            // console.log('this.form.champHide', this.champhide.join(', '));
            this.axios.post('/api/typeseffectifs/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/typeseffectifs/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
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
    width: 20px;
    height: 20px;
    border-radius: 5px;
    border-color: red;
    display: inline-block;
    border: 2px solid #867f7f;
    cursor: pointer
}

.cadre {
    border-radius: 3px;
    border: 2px solid #867f7f;
}
</style>
