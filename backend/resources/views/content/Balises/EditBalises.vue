<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">
                <div class="row">

                    <div class="col-sm form-group">
                        <label>ref </label>
                        <input v-model="form.ref" :class="errors.ref?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.ref" class="invalid-feedback">
                            <template v-for=" error in errors.ref"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="col-sm form-group">
                        <label>libelle </label>
                        <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.libelle" class="invalid-feedback">
                            <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="col-sm form-group">
                        <label>imei </label>
                        <input v-model="form.imei" :class="errors.imei?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.imei" class="invalid-feedback">
                            <template v-for=" error in errors.imei"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-sm">

                    <PositionsView :balise_id="form.id"></PositionsView>
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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"
import PositionsView from "./Positions/PositionsView.vue";

export default {
    name: 'EditBalises',
    components: {CustomSelect, Files, PositionsView},
    props: ['data', 'gridApi', 'modalFormId',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                ref: "",

                libelle: "",

                imei: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",
            }
        }
    },

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/balises/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/balises/' + this.form.id + '/delete').then(response => {
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
