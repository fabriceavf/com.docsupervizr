<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>libelle </label>
                            <input v-model="form.libelle"
                                   :class="errors.libelle?'form-control is-invalid':'form-control'"
                                   type="text">

                            <div v-if="errors.libelle" class="invalid-feedback">
                                <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">

                        <div class="form-group">
                            <label>besoins </label>
                            <v-select
                                v-model="form.besoin_id"
                                :options="besoinsData"
                                :reduce="ele => ele.id"
                                disabled
                                label="Selectlabel"
                            />
                            <div v-if="errors.besoin_id" class="invalid-feedback">
                                <template v-for=" error in errors.projet_id"> {{ error[0] }}</template>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>descriptions </label>
                            <textarea v-model="form.descriptions"
                                      :class="errors.descriptions?'form-control is-invalid':'form-control'"/>

                            <div v-if="errors.descriptions" class="invalid-feedback">
                                <template v-for=" error in errors.descriptions"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>debut_previsionnel </label>
                            <input v-model="form.debut_previsionnel"
                                   :class="errors.debut_previsionnel?'form-control is-invalid':'form-control'"
                                   type="date">

                            <div v-if="errors.debut_previsionnel" class="invalid-feedback">
                                <template v-for=" error in errors.debut_previsionnel"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label>fin_previsionnel </label>
                            <input v-model="form.fin_previsionnel"
                                   :class="errors.fin_previsionnel?'form-control is-invalid':'form-control'"
                                   type="date">

                            <div v-if="errors.fin_previsionnel" class="invalid-feedback">
                                <template v-for=" error in errors.fin_previsionnel"> {{ error[0] }}</template>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>debut_reel </label>
                            <input v-model="form.debut_reel"
                                   :class="errors.debut_reel?'form-control is-invalid':'form-control'"
                                   type="date">

                            <div v-if="errors.debut_reel" class="invalid-feedback">
                                <template v-for=" error in errors.debut_reel"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>fin_reel </label>
                            <input v-model="form.fin_reel"
                                   :class="errors.fin_reel?'form-control is-invalid':'form-control'"
                                   type="date">

                            <div v-if="errors.fin_reel" class="invalid-feedback">
                                <template v-for=" error in errors.fin_reel"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                </div>


                <!--                <div class="form-group">-->
                <!--                    <label>evaluation </label>-->
                <!--                    <input type="text" :class="errors.evaluation?'form-control is-invalid':'form-control'"-->
                <!--                           v-model="form.evaluation">-->

                <!--                    <div class="invalid-feedback" v-if="errors.evaluation">-->
                <!--                        <template v-for=" error in errors.evaluation"> {{ error[0] }}</template>-->

                <!--                    </div>-->
                <!--                </div>-->


                <!--                <div class="form-group">-->
                <!--                    <label>creat_by </label>-->
                <!--                    <input type="text" :class="errors.creat_by?'form-control is-invalid':'form-control'"-->
                <!--                           v-model="form.creat_by">-->

                <!--                    <div class="invalid-feedback" v-if="errors.creat_by">-->
                <!--                        <template v-for=" error in errors.creat_by"> {{ error[0] }}</template>-->

                <!--                    </div>-->
                <!--                </div>-->


                <!--                <div class="form-group">-->
                <!--                    <label>valider </label>-->
                <!--                    <input type="text" :class="errors.valider?'form-control is-invalid':'form-control'"-->
                <!--                           v-model="form.valider">-->

                <!--                    <div class="invalid-feedback" v-if="errors.valider">-->
                <!--                        <template v-for=" error in errors.valider"> {{ error[0] }}</template>-->

                <!--                    </div>-->
                <!--                </div>-->


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

export default {
    name: 'CreateActionsprevisionelles',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'besoinsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                descriptions: "",

                debut_previsionnel: "",

                fin_previsionnel: "",

                debut_reel: "",

                fin_reel: "",

                besoin_id: "",

                creat_by: "",

                evaluation: "",

                valider: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",
            }
        }
    },
    mounted() {
        if (this.besoinsData.length == 1) {
            this.form.besoin_id = this.besoinsData[0].id;
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/actionsprevisionelles', this.form).then(response => {
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
                libelle: "",
                descriptions: "",
                debut_previsionnel: "",
                fin_previsionnel: "",
                debut_reel: "",
                fin_reel: "",
                besoin_id: "",
                creat_by: "",
                evaluation: "",
                valider: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
            }
        }
    }
}
</script>
