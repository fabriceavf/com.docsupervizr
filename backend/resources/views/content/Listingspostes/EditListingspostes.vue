<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
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
    name: 'EditListingspostes',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
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

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/listingspostes/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/listingspostes/' + this.form.id + '/delete').then(response => {
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
