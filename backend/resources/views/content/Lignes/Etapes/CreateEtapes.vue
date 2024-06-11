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
                    <label>ordre </label>
                    <input v-model="form.ordre" :class="errors.ordre?'form-control is-invalid':'form-control'"
                           min="1" type="number">

                    <div v-if="errors.ordre" class="invalid-feedback">
                        <template v-for=" error in errors.ordre"> {{ error[0] }}</template>

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
    name: 'CreateEtapes',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId', 'parentId'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.form.ligne_id = this.parentId
            this.axios.post('/api/etapes', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
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
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
    }
}
</script>
