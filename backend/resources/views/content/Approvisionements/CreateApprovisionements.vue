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
                    <label>date </label>
                    <input v-model="form.date" :class="errors.date?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.date" class="invalid-feedback">
                        <template v-for=" error in errors.date"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>valider </label>
                    <input v-model="form.valider" :class="errors.valider?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.valider" class="invalid-feedback">
                        <template v-for=" error in errors.valider"> {{ error[0] }}</template>

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
    name: 'CreateApprovisionements',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                date: "",

                created_at: "",

                updated_at: "",

                valider: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/approvisionements', this.form).then(response => {
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
                date: "",
                created_at: "",
                updated_at: "",
                valider: "",
            }
        }
    }
}
</script>
