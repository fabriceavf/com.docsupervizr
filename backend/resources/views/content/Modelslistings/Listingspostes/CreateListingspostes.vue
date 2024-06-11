<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>etats </label>
                    <input v-model="form.etats" :class="errors.etats?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.etats" class="invalid-feedback">
                        <template v-for=" error in errors.etats"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>modelslistings </label>
                    <CustomSelect
                        :key="form.modelslisting"
                        :columnDefs="['libelle']"
                        :oldValue="form.modelslisting"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.modelslisting_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/modelslistings-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.modelslisting_id" class="invalid-feedback">
                        <template v-for=" error in errors.modelslisting_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>postes </label>
                    <CustomSelect
                        :key="form.poste"
                        :columnDefs="['libelle']"
                        :oldValue="form.poste"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.poste_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/postes-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.poste_id" class="invalid-feedback">
                        <template v-for=" error in errors.poste_id"> {{ error[0] }}</template>

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
    name: 'CreateListingspostes',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'modelslistingsData',
        'postesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                modelslisting_id: "",

                poste_id: "",

                etats: "",

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
            this.axios.post('/api/listingspostes', this.form).then(response => {
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
                modelslisting_id: "",
                poste_id: "",
                etats: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
            }
        }
    }
}
</script>
