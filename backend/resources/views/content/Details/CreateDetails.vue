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
                    <label>description </label>
                    <input v-model="form.description"
                           :class="errors.description?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.description" class="invalid-feedback">
                        <template v-for=" error in errors.description"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>order </label>
                    <input v-model="form.order" :class="errors.order?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.order" class="invalid-feedback">
                        <template v-for=" error in errors.order"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>processus </label>
                    <CustomSelect
                        :key="form.processu"
                        :columnDefs="['libelle']"
                        :oldValue="form.processu"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.processu_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/processus-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.processu_id" class="invalid-feedback">
                        <template v-for=" error in errors.processu_id"> {{ error[0] }}</template>

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
    name: 'CreateDetails',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'processusData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                description: "",

                order: "",

                processu_id: "",

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
            this.axios.post('/api/details', this.form).then(response => {
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
                description: "",
                order: "",
                processu_id: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
            }
        }
    }
}
</script>
