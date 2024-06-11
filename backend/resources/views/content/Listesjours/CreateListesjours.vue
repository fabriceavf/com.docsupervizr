<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>rand </label>
                    <input v-model="form.rand" :class="errors.rand?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.rand" class="invalid-feedback">
                        <template v-for=" error in errors.rand"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour </label>
                    <input v-model="form.jour" :class="errors.jour?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour" class="invalid-feedback">
                        <template v-for=" error in errors.jour"> {{ error[0] }}</template>

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
                    <label>listesappels </label>
                    <CustomSelect
                        :key="form.listesappel"
                        :columnDefs="['libelle']"
                        :oldValue="form.listesappel"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.listesappel_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/listesappels-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.listesappel_id" class="invalid-feedback">
                        <template v-for=" error in errors.listesappel_id"> {{ error[0] }}</template>

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
    name: 'CreateListesjours',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'listesappelsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                rand: "",

                jour: "",

                listesappel_id: "",

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
            this.axios.post('/api/listesjours', this.form).then(response => {
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
                rand: "",
                jour: "",
                listesappel_id: "",
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
