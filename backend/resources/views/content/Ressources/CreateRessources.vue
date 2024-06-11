<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>type </label>
                    <input v-model="form.type" :class="errors.type?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.type" class="invalid-feedback">
                        <template v-for=" error in errors.type"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle </label>
                    <input v-model="form.cle" :class="errors.cle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle" class="invalid-feedback">
                        <template v-for=" error in errors.cle"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>valeur </label>
                    <input v-model="form.valeur" :class="errors.valeur?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.valeur" class="invalid-feedback">
                        <template v-for=" error in errors.valeur"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>activites </label>
                    <CustomSelect
                        :key="form.activite"
                        :columnDefs="['libelle']"
                        :oldValue="form.activite"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.activite_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/activites-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.activite_id" class="invalid-feedback">
                        <template v-for=" error in errors.activite_id"> {{ error[0] }}</template>

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
    name: 'CreateRessources',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'activitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                type: "",

                cle: "",

                valeur: "",

                activite_id: "",

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
            this.axios.post('/api/ressources', this.form).then(response => {
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
                type: "",
                cle: "",
                valeur: "",
                activite_id: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
            }
        }
    }
}
</script>
