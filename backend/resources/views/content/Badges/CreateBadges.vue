<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>content </label>
                    <input v-model="form.content" :class="errors.content ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.content" class="invalid-feedback">
                        <template v-for=" error in errors.content"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>js </label>
                    <input v-model="form.js" :class="errors.js ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.js" class="invalid-feedback">
                        <template v-for=" error in errors.js"> {{ error[0] }}</template>

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


                <div class="form-group">
                    <label>css </label>
                    <input v-model="form.css" :class="errors.css ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.css" class="invalid-feedback">
                        <template v-for=" error in errors.css"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>node_version </label>
                    <input v-model="form.node_version"
                           :class="errors.node_version ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.node_version" class="invalid-feedback">
                        <template v-for=" error in errors.node_version"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>identifiants_sadge </label>
                    <input v-model="form.identifiants_sadge"
                           :class="errors.identifiants_sadge ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.identifiants_sadge" class="invalid-feedback">
                        <template v-for=" error in errors.identifiants_sadge"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>clients </label>
                    <v-select v-model="form.client_id" :options="clientsData" :reduce="ele => ele.id"
                              label="Selectlabel"/>
                    <div v-if="errors.client_id" class="invalid-feedback">
                        <template v-for=" error in errors.client_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <label>Dependance </label>
                <div v-for="(dependance, index) in dependances" :key="index" class="form-group">

                    <div class="row">
                        <div class="form-group col-sm-9">
                            <input v-model="dependance.libelle"
                                   :class="errors.libelle ? 'form-control is-invalid' : 'form-control'" type="text">
                        </div>
                        <div class="form-group col-sm-3">
                            <button v-show="index > 0" class="btn btn-danger" type="button"
                                    @click="removeField(index)">Remove
                            </button>
                        </div>
                        <div v-if="errors.libelle" class="invalid-feedback">
                            <template v-for=" error in errors.libelle"> {{ error[0] }}</template>


                        </div>
                    </div>
                </div>
                <button class="btn btn-info" type="button" @click="addField()">Add Field</button>

            </div>
            <div class="form-group">
                <CalendrierBadges/>
            </div>
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-floppy-disk"></i> Créer
            </button>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import CalendrierBadges from './CalendrierBadges.vue'

export default {
    name: 'CreateBadges',

    components: {VSelect, CustomSelect, Files, CalendrierBadges},

    props: [
        'gridApi',
        'modalFormId',
        'clientsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                client_id: "",

                content: "",

                created_at: "",

                updated_at: "",

                js: "",

                libelle: "",

                css: "",

                node_version: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",
            },
            dependances: [
                {
                    libelle: "",
                },
            ],
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/badges', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
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
        resetForm() {
            this.form = {
                id: "",
                client_id: "",
                content: "",
                created_at: "",
                updated_at: "",
                js: "",
                libelle: "",
                css: "",
                node_version: "",
                extra_attributes: "",
                deleted_at: "",
                identifiants_sadge: "",
            },
                this.dependances = {
                    libelle: ""
                }
        },
        addField() {
            this.dependances.push({value: ''});
        },
        removeField(index) {
            this.dependances.splice(index, 1);
        }
    }
}
</script>
