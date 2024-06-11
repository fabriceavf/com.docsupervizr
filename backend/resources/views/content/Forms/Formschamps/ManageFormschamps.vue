<template>
    <b-overlay :show="isLoading">
        <form>
            <div class="container-fuild">


                <div class="row">

                    <div class="form-group col-sm-12">
                        <label>type </label>
                        <v-select
                            v-model="form.type"
                            :options="typesData"
                            :reduce="ele => ele.id"
                            label="Selectlabel"
                        />

                        <div v-if="errors.type" class="invalid-feedback">
                            <template v-for=" error in errors.type"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>libelle </label>
                        <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.libelle" class="invalid-feedback">
                            <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>width </label>
                        <input v-model="form.width" :class="errors.width?'form-control is-invalid':'form-control'"
                               type="number">

                        <div v-if="errors.width" class="invalid-feedback">
                            <template v-for=" error in errors.width"> {{ error[0] }}</template>

                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>description </label>
                        <textarea v-model="form.description"
                                  :class="errors.description?'form-control is-invalid':'form-control'"
                                  type="text"></textarea>

                        <div v-if="errors.description" class="invalid-feedback">
                            <template v-for=" error in errors.description"> {{ error[0] }}</template>

                        </div>
                    </div>

                </div>

            </div>

            <template v-if="form.id!=0">

                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary" @click.prevent="EditLine()">
                        <i class="fas fa-floppy-disk"></i> Mettre à jour
                    </button>
                    <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                        <i class="fas fa-close"></i> Supprimer
                    </button>
                </div>

            </template>
            <template v-else>

                <button class="btn btn-primary" @click.prevent="createLine()">
                    <i class="fas fa-floppy-disk"></i> Créer
                </button>
            </template>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'ManageFormschamps',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'newChamp',
        'data'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                description: "",

                type: "",

                cle: "",

                width: "",

                extra_attributes: "",

                creat_by: "",

                deleted_at: "",

                created_at: "",

                updated_at: "",
            },
            typesData: [
                {id: 'TEXT', Selectlabel: 'Petit texte'},
                {id: 'TEXTAREA', Selectlabel: 'Grand texte'},
                {id: 'IMAGE', Selectlabel: 'Une image'},
                {id: 'FILES', Selectlabel: 'Un fichier'},
            ]
        }
    },
    mounted() {
        if (this.data.id) {
            this.form = this.data
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/formschamps', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.newChamp(response.data)

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
        EditLine() {
            this.isLoading = true
            this.axios.post('/api/formschamps/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.newChamp(response.data)
                this.$bvModal.hide(this.modalFormId)
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/formschamps/' + this.form.id + '/delete').then(response => {
                this.isLoading = false
                this.newChamp(response.data)
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
        resetForm() {
            this.form = {
                id: "",
                libelle: "",
                description: "",
                type: "",
                cle: "",
                width: "",
                extra_attributes: "",
                creat_by: "",
                deleted_at: "",
                created_at: "",
                updated_at: "",
            }
        }
    }
}
</script>
