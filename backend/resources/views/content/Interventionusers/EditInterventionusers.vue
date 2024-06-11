<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
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

            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'EditInterventionusers',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
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

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/interventionusers/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
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
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/interventionusers/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
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
    }
}
</script>
