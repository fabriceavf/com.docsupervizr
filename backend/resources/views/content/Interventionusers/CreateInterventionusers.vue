<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>statut </label>
                    <input v-model="form.statut" :class="errors.statut?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.statut" class="invalid-feedback">
                        <template v-for=" error in errors.statut"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>interventions </label>
                    <CustomSelect
                        :key="form.intervention"
                        :columnDefs="['libelle']"
                        :oldValue="form.intervention"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.intervention_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/interventions-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.intervention_id" class="invalid-feedback">
                        <template v-for=" error in errors.intervention_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>users </label>
                    <CustomSelect
                        :key="form.user"
                        :columnDefs="['nom','prenom','matricule']"
                        :oldValue="form.user"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.user_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/users-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.user_id" class="invalid-feedback">
                        <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

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
    name: 'CreateInterventionusers',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'interventionsData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                intervention_id: "",

                user_id: "",

                statut: "",

                created_at: "",

                updated_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/interventionusers', this.form).then(response => {
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
                intervention_id: "",
                user_id: "",
                statut: "",
                created_at: "",
                updated_at: "",
            }
        }
    }
}
</script>
