<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


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
    name: 'CreateHeadselements',
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

                cle: "",

                valeur: "",

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
            this.form.entreprise_id = this.parentId
            this.axios.post('/api/headselements', this.form).then(response => {
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
                cle: "",
                valeur: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
    }
}
</script>
