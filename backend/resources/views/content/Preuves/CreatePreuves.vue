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
                    <label>identifiants_sadge </label>
                    <input v-model="form.identifiants_sadge"
                           :class="errors.identifiants_sadge?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.identifiants_sadge" class="invalid-feedback">
                        <template v-for=" error in errors.identifiants_sadge"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>programmes </label>
                    <CustomSelect
                        :key="form.programme"
                        :columnDefs="['libelle']"
                        :oldValue="form.programme"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.programme_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/programmes-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.programme_id" class="invalid-feedback">
                        <template v-for=" error in errors.programme_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>transactions </label>
                    <CustomSelect
                        :key="form.transaction"
                        :columnDefs="['libelle']"
                        :oldValue="form.transaction"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.transaction_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/transactions-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.transaction_id" class="invalid-feedback">
                        <template v-for=" error in errors.transaction_id"> {{ error[0] }}</template>

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
    name: 'CreatePreuves',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'programmesData',
        'transactionsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                programme_id: "",

                transaction_id: "",

                etats: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                identifiants_sadge: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/preuves', this.form).then(response => {
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
                programme_id: "",
                transaction_id: "",
                etats: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                identifiants_sadge: "",
            }
        }
    }
}
</script>
