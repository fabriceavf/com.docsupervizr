<template>

    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>quantite </label>
                    <input v-model="form.quantite" :class="errors.quantite?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.quantite" class="invalid-feedback">
                        <template v-for=" error in errors.quantite"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>approvisionements </label>
                    <CustomSelect
                        :key="form.approvisionement"
                        :columnDefs="['libelle']"
                        :oldValue="form.approvisionement"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.approvisionement_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/approvisionements-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />

                    <div v-if="errors.approvisionement_id" class="invalid-feedback">
                        <template v-for=" error in errors.approvisionement_id"> {{ error[0] }}</template>

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
    name: 'CreateApprovisionementdetails',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'approvisionementsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                approvisionement_id: "",

                quantite: "",

                created_at: "",

                updated_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/approvisionementdetails', this.form).then(response => {
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
                approvisionement_id: "",
                quantite: "",
                created_at: "",
                updated_at: "",
            }
        }
    }
}
</script>
