<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>descriptions </label>
                    <input v-model="form.descriptions"
                           :class="errors.descriptions?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.descriptions" class="invalid-feedback">
                        <template v-for=" error in errors.descriptions"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>debut_previsionnel </label>
                    <input v-model="form.debut_previsionnel"
                           :class="errors.debut_previsionnel?'form-control is-invalid':'form-control'"
                           type="date">

                    <div v-if="errors.debut_previsionnel" class="invalid-feedback">
                        <template v-for=" error in errors.debut_previsionnel"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>fin_previsionnel </label>
                    <input v-model="form.fin_previsionnel"
                           :class="errors.fin_previsionnel?'form-control is-invalid':'form-control'"
                           type="date">

                    <div v-if="errors.fin_previsionnel" class="invalid-feedback">
                        <template v-for=" error in errors.fin_previsionnel"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>debut_reel </label>
                    <input v-model="form.debut_reel" :class="errors.debut_reel?'form-control is-invalid':'form-control'"
                           type="date">

                    <div v-if="errors.debut_reel" class="invalid-feedback">
                        <template v-for=" error in errors.debut_reel"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>fin_reel </label>
                    <input v-model="form.fin_reel" :class="errors.fin_reel?'form-control is-invalid':'form-control'"
                           type="date">

                    <div v-if="errors.fin_reel" class="invalid-feedback">
                        <template v-for=" error in errors.fin_reel"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>creat_by </label>
                    <input v-model="form.creat_by" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.creat_by" class="invalid-feedback">
                        <template v-for=" error in errors.creat_by"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>evaluation </label>
                    <input v-model="form.evaluation" :class="errors.evaluation?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.evaluation" class="invalid-feedback">
                        <template v-for=" error in errors.evaluation"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>actionsprevisionelles </label>
                    <CustomSelect
                        :key="form.actionsprevisionelle"
                        :columnDefs="['libelle']"
                        :oldValue="form.actionsprevisionelle"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.actionsprevisionelle_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/actionsprevisionelles-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.actionsprevisionelle_id" class="invalid-feedback">
                        <template v-for=" error in errors.actionsprevisionelle_id"> {{ error[0] }}</template>

                    </div>
                </div>

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
    name: 'CreateActionsrealises',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'actionsprevisionellesData',
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

                actionsprevisionelle_id: "",

                creat_by: "",

                evaluation: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/actionsrealises', this.form).then(response => {
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
                actionsprevisionelle_id: "",
                creat_by: "",
                evaluation: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
            }
        }
    }
}
</script>
